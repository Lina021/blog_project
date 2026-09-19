<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewCommentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

test('comments are shown on the post page', function () {
    $comment = Comment::factory()->create();

    $this->get("/posts/{$comment->post_id}")->assertOk()->assertSee($comment->comment);
});

test('an authenticated user can comment on a post', function () {
    $post = Post::factory()->create();
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post("/posts/{$post->id}/comments", ['comment' => 'Nice post!'])
        ->assertRedirect();

    $this->assertDatabaseHas('comments', [
        'post_id' => $post->id,
        'user_id' => $user->id,
        'comment' => 'Nice post!',
    ]);
});

test('a guest cannot comment', function () {
    $post = Post::factory()->create();

    $this->post("/posts/{$post->id}/comments", ['comment' => 'Hi'])->assertRedirect(route('login'));

    expect(Comment::count())->toBe(0);
});

test('a comment is required and limited to 1000 characters', function () {
    $post = Post::factory()->create();
    $this->actingAs(User::factory()->create());

    $this->post("/posts/{$post->id}/comments", [])->assertSessionHasErrors('comment');
    $this->post("/posts/{$post->id}/comments", ['comment' => str_repeat('a', 1001)])
        ->assertSessionHasErrors('comment');

    expect(Comment::count())->toBe(0);
});

test('a user can delete their own comment', function () {
    $comment = Comment::factory()->create();

    $this->actingAs($comment->user)->delete("/comments/{$comment->id}")->assertRedirect();

    $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
});

test('a user cannot delete another users comment', function () {
    $comment = Comment::factory()->create();

    $this->actingAs(User::factory()->create())->delete("/comments/{$comment->id}")->assertForbidden();

    $this->assertDatabaseHas('comments', ['id' => $comment->id]);
});

test('the post author is notified by queued mail when someone comments', function () {
    Notification::fake();
    $post = Post::factory()->create();

    $this->actingAs(User::factory()->create())
        ->post("/posts/{$post->id}/comments", ['comment' => 'Nice post!']);

    Notification::assertSentTo($post->user, NewCommentNotification::class, function ($notification) {
        return $notification instanceof ShouldQueue && $notification->comment->comment === 'Nice post!';
    });
});

test('the author is not notified about their own comment', function () {
    Notification::fake();
    $post = Post::factory()->create();

    $this->actingAs($post->user)->post("/posts/{$post->id}/comments", ['comment' => 'Note to self']);

    Notification::assertNothingSent();
});
