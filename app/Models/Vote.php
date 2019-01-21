<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Static_;

class Vote extends Model
{
    protected $guarded = [];

    public static function upvote(Post $post)
    {
        static::addVote($post, 1);
    }

    public static function downvote(Post $post)
    {
        static::addVote($post, -1);
    }


    protected static function addVote(Post $post, $amount)
    {

        static::updateOrCreate(
            ['post_id' => $post->id, 'user_id' => auth()->id()],
            ['vote' => $amount]
        );

        $post->score = static::where(['post_id' => $post->id])->sum('vote');

        $post->save();
    }
}
