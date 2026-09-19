<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return PostResource::collection(Post::with('user', 'tags')->latest()->paginate(10));
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $post = $request->user()->posts()->create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::random(6),
            'content' => $validated['content'],
            'image' => $request->file('image')?->store('posts', 'public'),
        ]);

        $post->tags()->sync($request->input('tags', []));

        return (new PostResource($post->load('user', 'tags')))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Post $post): PostResource
    {
        return new PostResource($post->load('user', 'tags', 'comments.user'));
    }

    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        $data = $request->only('title', 'content');

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);
        $post->tags()->sync($request->input('tags', []));

        return new PostResource($post->load('user', 'tags'));
    }

    public function destroy(Post $post): JsonResponse
    {
        $this->authorize('delete', $post);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return response()->json(null, 204);
    }
}
