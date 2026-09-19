<?php

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('the posts index lists posts with pagination', function () {
    Post::factory()->count(12)->sequence(fn ($sequence) => [
        'title' => "Post number {$sequence->index}",
        'slug' => "post-{$sequence->index}",
    ])->create();

    $this->get('/posts')
        ->assertOk()
        ->assertViewHas('posts', fn ($posts) => $posts->count() === 10 && $posts->total() === 12);

    $this->get('/posts?page=2')
        ->assertOk()
        ->assertViewHas('posts', fn ($posts) => $posts->currentPage() === 2 && $posts->count() === 2);
});

test('a guest can view a single post', function () {
    $post = Post::factory()->create();

    $this->get("/posts/{$post->id}")->assertOk()->assertSee($post->title);
});

test('guests cannot access the post write routes', function () {
    $post = Post::factory()->create();

    $this->get('/posts/create')->assertRedirect(route('login'));
    $this->post('/posts', [])->assertRedirect(route('login'));
    $this->get("/posts/{$post->id}/edit")->assertRedirect(route('login'));
    $this->put("/posts/{$post->id}", [])->assertRedirect(route('login'));
    $this->delete("/posts/{$post->id}")->assertRedirect(route('login'));
});

test('an authenticated user can create a post with tags', function () {
    $user = User::factory()->create();
    $tag = Tag::factory()->create();

    $response = $this->actingAs($user)->post('/posts', [
        'title' => 'My First Post',
        'content' => 'Some content',
        'tags' => [$tag->id],
    ]);

    $post = Post::firstWhere('title', 'My First Post');

    $response->assertRedirect(route('posts.show', $post));
    expect($post->user_id)->toBe($user->id)
        ->and($post->slug)->toStartWith('my-first-post-')
        ->and($post->tags->pluck('id')->all())->toBe([$tag->id]);
});

test('a post can be created with an image', function () {
    Storage::fake('public');

    $this->actingAs(User::factory()->create())->post('/posts', [
        'title' => 'With image',
        'content' => 'Body',
        'image' => UploadedFile::fake()->image('cover.jpg'),
    ]);

    $post = Post::firstWhere('title', 'With image');

    expect($post->image)->not->toBeNull();
    Storage::disk('public')->assertExists($post->image);
});

test('creating a post validates its input', function () {
    $this->actingAs(User::factory()->create())
        ->post('/posts', ['tags' => [999]])
        ->assertSessionHasErrors(['title', 'content', 'tags.0']);

    expect(Post::count())->toBe(0);
});

test('the owner can update their post', function () {
    $post = Post::factory()->create();
    $tag = Tag::factory()->create();

    $this->actingAs($post->user)
        ->put("/posts/{$post->id}", [
            'title' => 'Updated title',
            'content' => 'Updated content',
            'tags' => [$tag->id],
        ])
        ->assertRedirect(route('posts.show', $post));

    $post->refresh();
    expect($post->title)->toBe('Updated title')
        ->and($post->content)->toBe('Updated content')
        ->and($post->tags->pluck('id')->all())->toBe([$tag->id]);
});

test('updating a post with a new image replaces the old one', function () {
    Storage::fake('public');
    $post = Post::factory()->create(['image' => UploadedFile::fake()->image('old.jpg')->store('posts', 'public')]);
    $oldImage = $post->image;

    $this->actingAs($post->user)->put("/posts/{$post->id}", [
        'title' => $post->title,
        'content' => $post->content,
        'image' => UploadedFile::fake()->image('new.jpg'),
    ]);

    $post->refresh();
    expect($post->image)->not->toBe($oldImage);
    Storage::disk('public')->assertMissing($oldImage);
    Storage::disk('public')->assertExists($post->image);
});

test('a user cannot edit or update another users post', function () {
    $post = Post::factory()->create();
    $other = User::factory()->create();

    $this->actingAs($other)->get("/posts/{$post->id}/edit")->assertForbidden();
    $this->actingAs($other)
        ->put("/posts/{$post->id}", ['title' => 'Hacked', 'content' => 'x'])
        ->assertForbidden();

    expect($post->fresh()->title)->not->toBe('Hacked');
});

test('the owner can delete their post and its image', function () {
    Storage::fake('public');
    $post = Post::factory()->create(['image' => UploadedFile::fake()->image('a.jpg')->store('posts', 'public')]);

    $this->actingAs($post->user)
        ->delete("/posts/{$post->id}")
        ->assertRedirect(route('posts.index'));

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    Storage::disk('public')->assertMissing($post->image);
});

test('a user cannot delete another users post', function () {
    $post = Post::factory()->create();

    $this->actingAs(User::factory()->create())->delete("/posts/{$post->id}")->assertForbidden();

    $this->assertDatabaseHas('posts', ['id' => $post->id]);
});
