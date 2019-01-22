<?php

namespace App\Http\Controllers;

use App\Models\Post;

class VotePostController extends Controller
{
    public function upvote(Post $post)
    {
        $post->upvote();

        return [
            'new_score' => $post->score
        ];
    }

    public function downvote(Post $post)
    {
        $post->downvote();

        return [
            'new_score' => $post->score
        ];
    }

    public function undovote(Post $post)
    {
        $post->undovote();

        return [
            'new_score' => $post->score
        ];
    }
}
