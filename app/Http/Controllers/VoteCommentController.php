<?php

namespace App\Http\Controllers;

use App\Models\Comment;

class VoteCommentController extends Controller
{
    public function upvote(Comment $comment)
    {
        $comment->upvote();

        return [
            'new_score' => $comment->score
        ];
    }

    public function downvote(Comment $comment)
    {
        $comment->downvote();

        return [
            'new_score' => $comment->score
        ];
    }

    public function undovote(Comment $comment)
    {
        $comment->undovote();

        return [
            'new_score' => $comment->score
        ];
    }
}
