<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

test('a visitor can register and receives a token', function () {
    $this->postJson('/api/register', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])
        ->assertCreated()
        ->assertJsonStructure(['user' => ['id', 'name'], 'token']);

    $this->assertDatabaseHas('users', ['email' => 'jane@example.com']);
});

test('a user can log in, use the token and log out', function () {
    $user = User::factory()->create(['password' => 'password']);

    $token = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertOk()->json('token');

    $this->withToken($token)->getJson('/api/user')
        ->assertOk()
        ->assertJsonPath('data.id', $user->id);

    $this->withToken($token)->postJson('/api/logout')->assertOk();

    expect($user->tokens()->count())->toBe(0);
});

test('invalid credentials are rejected', function () {
    $user = User::factory()->create(['password' => 'password']);

    $this->postJson('/api/login', ['email' => $user->email, 'password' => 'wrong'])
        ->assertUnprocessable();
});

test('guests can read posts but not write', function () {
    $post = Post::factory()->create();

    $this->getJson('/api/posts')->assertOk()->assertJsonPath('data.0.id', $post->id);
    $this->getJson("/api/posts/{$post->id}")->assertOk()->assertJsonPath('data.slug', $post->slug);
    $this->postJson('/api/posts', ['title' => 'x', 'content' => 'y'])->assertUnauthorized();
});

test('an authenticated user can create, update and delete their post', function () {
    $user = User::factory()->create();
    $tag = Tag::factory()->create();
    Sanctum::actingAs($user);

    $id = $this->postJson('/api/posts', [
        'title' => 'Hello',
        'content' => 'World',
        'tags' => [$tag->id],
    ])->assertCreated()->assertJsonPath('data.tags.0.id', $tag->id)->json('data.id');

    $this->putJson("/api/posts/{$id}", ['title' => 'Updated', 'content' => 'World'])
        ->assertOk()
        ->assertJsonPath('data.title', 'Updated');

    $this->deleteJson("/api/posts/{$id}")->assertNoContent();
    $this->assertDatabaseMissing('posts', ['id' => $id]);
});

test('users cannot modify other users posts', function () {
    $post = Post::factory()->create();
    Sanctum::actingAs(User::factory()->create());

    $this->putJson("/api/posts/{$post->id}", ['title' => 'Hack', 'content' => 'x'])->assertForbidden();
    $this->deleteJson("/api/posts/{$post->id}")->assertForbidden();
});

test('post validation errors return 422', function () {
    Sanctum::actingAs(User::factory()->create());

    $this->postJson('/api/posts', [])->assertUnprocessable()->assertJsonValidationErrors(['title', 'content']);
});

test('comments can be listed, created and deleted by their owner only', function () {
    $post = Post::factory()->create();
    $owner = User::factory()->create();

    $this->getJson("/api/posts/{$post->id}/comments")->assertOk();
    $this->postJson("/api/posts/{$post->id}/comments", ['comment' => 'Hi'])->assertUnauthorized();

    Sanctum::actingAs($owner);
    $id = $this->postJson("/api/posts/{$post->id}/comments", ['comment' => 'Hi'])
        ->assertCreated()
        ->assertJsonPath('data.user.id', $owner->id)
        ->json('data.id');

    Sanctum::actingAs(User::factory()->create());
    $this->deleteJson("/api/comments/{$id}")->assertForbidden();

    Sanctum::actingAs($owner);
    $this->deleteJson("/api/comments/{$id}")->assertNoContent();
    expect(Comment::count())->toBe(0);
});

test('tags are listed', function () {
    Tag::factory()->count(2)->create();

    $this->getJson('/api/tags')->assertOk()->assertJsonCount(2, 'data');
});
