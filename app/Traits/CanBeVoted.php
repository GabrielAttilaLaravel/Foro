<?php
namespace App\Traits;


use App\Models\Vote;

trait CanBeVoted
{
    public function upvote()
    {
        $this->addVote(1);
    }

    public function downvote()
    {
        $this->addVote(-1);
    }


    protected function addVote($amount)
    {
        Vote::updateOrCreate(
            ['post_id' => $this->id, 'user_id' => auth()->id()],
            ['vote' => $amount]
        );

        $this->refreshPostScore();
    }

    public function undoVote()
    {
        Vote::where([
            'post_id' => $this->id,
            'user_id' => auth()->id()
        ])->delete();

        $this->refreshPostScore();
    }

    public function refreshPostScore()
    {
        $this->score = Vote::where(['post_id' => $this->id])->sum('vote');

        $this->save();
    }
}