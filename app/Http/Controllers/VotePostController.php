<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Vote;

class VotePostController extends Controller
{
    public function upvote(Post $post)
    {
        Vote::upvote($post);

        return [
            'new_score' => $post->score
        ];
    }

    public function downvote(Post $post)
    {
        Vote::downvote($post);

        return [
            'new_score' => $post->score
        ];
    }

    public function undovote(Post $post)
    {
        Vote::undovote($post);

        return [
            'new_score' => $post->score
        ];
    }
}
