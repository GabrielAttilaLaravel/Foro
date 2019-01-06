<?php


use App\Mail\TokenMail;
use App\Models\Token;
use App\User;
use Illuminate\Support\Facades\Mail;

class RegistrationTest extends FeatureTestCase
{
    function test_a_user_can_create_a_account()
    {
        Mail::fake();

        $this->visitRoute('user.create')
            ->type('admin@gabrielattila.com.ve', 'email')
            ->type('gabrielattila', 'username')
            ->type('Gabriel', 'first_name')
            ->type('Moreno', 'last_name')
            ->press('Registrate');

        $this->seeInDatabase('users', [
            'email' => 'admin@gabrielattila.com.ve',
            'username' => 'gabrielattila',
            'first_name' => 'Gabriel',
            'last_name' => 'Moreno',
        ]);

        $user = User::first();

        $this->seeInDatabase('tokens', [
            'user_id' => $user->id
        ]);

        $token = Token::where('user_id', $user->id)->first();

        $this->assertNotNull($token);

        Mail::assertSentTo($user, TokenMail::class, function ($mail) use ($token){
            return $mail->token->id == $token->id;
        });

        //TODO: finish this feature

        return;

        $this->seeRouteIs('register.confirmation')
            ->see('Gracias por registrarte')
            ->see('Enviamos a tu email un enlace para que inicies sesión');

    }
}
