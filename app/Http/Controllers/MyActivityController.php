<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MyActivityController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $posts = $user->posts()->withCount('comments')->latest()->get();
        $comments = $user->comments()->with('post')->latest()->get();

        return view('my-activity', compact('posts', 'comments'));
    }
}
