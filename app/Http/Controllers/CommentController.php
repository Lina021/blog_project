<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Notifications\NewCommentNotification;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post): RedirectResponse
    {
        $comment = $post->comments()->create([
            'user_id' => $request->user()->id,
            'comment' => $request->validated()['comment'],
        ]);

        if ($post->user_id !== $comment->user_id) {
            $post->user->notify(new NewCommentNotification($comment));
        }

        return back()->with('status', 'Comment added.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('status', 'Comment deleted.');
    }
}