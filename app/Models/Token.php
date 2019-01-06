<?php

namespace App\Models;

use App\Mail\TokenMail;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Token extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateFor(User $user)
    {
        $token = new static;

        $token->token = str_random(60);

        $token->user()->associate($user);

        $token->save();

        return $token;

       /* return static::create([
            'token' => str_random(60),
            'user_id' => $user->id
        ]);*/
    }

    public function sendByEmail()
    {
        Mail::to($this->user)->send(new TokenMail($this));
    }
}
