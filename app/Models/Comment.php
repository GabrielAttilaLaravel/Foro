<?php

namespace App\Models;

use App\User;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['comment', 'post_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsAnswer()
    {
        $this->post->pending = false;
        $this->post->answer_id = $this->id;

        $this->post->save();
    }

    public function answer($answerID)
    {
        return $this->id == $answerID;
    }

    public function getSafeHtmlCommentAttribute()
    {
        return Markdown::convertToHtml(e($this->comment));
    }
}
