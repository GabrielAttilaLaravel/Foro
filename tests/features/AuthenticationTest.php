<?php

use App\Mail\TokenMail;
use App\Models\Token;
use Illuminate\Support\Facades\Mail;

class AuthenticationTest extends FeatureTestCase
{
    function test_a_guest_user_can_request_a_token()
    {
        Mail::fake();

        $user = $this->defaultUser(['email' => 'admin@gabrielattila.com.ve']);

        $this->visitRoute('login.create')
            ->type('admin@gabrielattila.com.ve', 'email')
            ->press('Solicitar token');

        $token = Token::where('user_id', $user->id)->first();

        $this->assertNotNull($token);

        Mail::assertSentTo($user, TokenMail::class, function ($mail) use ($token){
            return $mail->token->id === $token->id;
        });

        $this->dontSeeIsAuthenticated();

        $this->see('Enviamos a tu email un enlace para que inicies sesión');
    }

    function test_a_guest_user_can_request_a_token_an_email()
    {
        Mail::fake();

        $this->visitRoute('login.create')
            ->press('Solicitar token');

        $token = Token::first();

        $this->assertNull($token, 'A token was created');

        Mail::assertNotSent(TokenMail::class);

        $this->dontSeeIsAuthenticated();

        $this->seeErrors([
            'email' => 'El campo correo electrónico es obligatorio'
        ]);
    }

    function test_a_guest_user_can_request_a_token_an_invalid_email()
    {
        $this->visitRoute('login.create')
            ->type('Gabriel', 'email')
            ->press('Solicitar token');

        $this->seeErrors([
            'email' => 'Correo electrónico no es un correo válido'
        ]);
    }

    function test_a_guest_user_can_request_a_token_with_a_non_existent_email()
    {
        $this->defaultUser([
            'email' => 'admin@gabrielattila.com.ve'
        ]);

        $this->visitRoute('login.create')
            ->type('attila@gabrielattila.com.ve', 'email')
            ->press('Solicitar token');

        $this->seeErrors([
            'email' => 'Este correo electrónico no existe'
        ]);
    }
}
