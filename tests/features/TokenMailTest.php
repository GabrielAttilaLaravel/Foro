<?php

use App\Mail\TokenMail;
use App\Models\Token;

class TokenMailTest extends FeatureTestCase
{
    use InteractsWithMailable;

    function test_it_sends_a_link_with_the_token()
    {
        $user = new \App\User([
            'first_name' => 'Gabriel',
            'last_name' => 'Moreno',
            'email' => 'gabriel@attila.com'
        ]);

        $token = new Token([
            'token' => 'thist_is_a_token',
            'user' => $user,
        ]);

        $this->open(new TokenMail($token))
            ->seeLink($token->url, $token->url);
    }
}
