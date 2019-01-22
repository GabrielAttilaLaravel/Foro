<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 21/01/19
 * Time: 08:49 PM
 */

namespace App\Repositories;


use App\Models\Post;
use App\Models\Vote;

class VoteRepository
{
    public function upvote(Post $post)
    {
        $this->addVote($post, 1);
    }

    public function downvote(Post $post)
    {
        $this->addVote($post, -1);
    }


    protected function addVote(Post $post, $amount)
    {

        Vote::updateOrCreate(
            ['post_id' => $post->id, 'user_id' => auth()->id()],
            ['vote' => $amount]
        );

        $this->refreshPostScore($post);
    }

    public function undoVote(Post $post)
    {
        Vote::where([
            'post_id' => $post->id,
            'user_id' => auth()->id()
        ])->delete();

        $this->refreshPostScore($post);
    }

    public function refreshPostScore(Post $post)
    {
        $post->score = Vote::where(['post_id' => $post->id])->sum('vote');

        $post->save();
    }
}