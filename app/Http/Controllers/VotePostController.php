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
}
