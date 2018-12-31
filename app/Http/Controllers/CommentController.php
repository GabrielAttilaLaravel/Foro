<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        auth()->user()->comment($post, $request->comment);

        return redirect($post->url);
    }

    public function accept(Comment $comment)
    {
        $comment->markAsAnswer();

        return redirect($comment->post->url);
    }
}
