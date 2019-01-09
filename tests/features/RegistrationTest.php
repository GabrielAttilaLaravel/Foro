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

        Mail::assertSent(TokenMail::class, function ($mail) use ($token, $user){
            return $mail->hasTo($user) && $mail->token->id == $token->id;
        });

        $this->seeRouteIs('user.confirm')
            ->see('Gracias por registrarte')
            ->see('Enviamos a tu email un enlace para que inicies sesión');

    }

    function test_the_first_name_is_required()
    {
        $this->visitRoute('user.create')
            ->type('admin@gabrielattila.com.ve', 'email')
            ->type('gabrielattila', 'username')
            ->type('', 'first_name')
            ->type('Moreno', 'last_name')
            ->press('Registrate');

        $this->seeRouteIs('user.create')
            ->see('El campo nombre es obligatorio');

        $this->assertEquals(0, User::count());
    }

    function test_the_last_name_is_required()
    {
        $this->visitRoute('user.create')
            ->type('admin@gabrielattila.com.ve', 'email')
            ->type('gabrielattila', 'username')
            ->type('Gabriel', 'first_name')
            ->type('', 'last_name')
            ->press('Registrate');

        $this->seeRouteIs('user.create')
            ->see('El campo apellido es obligatorio');

        $this->assertEquals(0, User::count());
    }

    function test_the_email_is_required()
    {
        $this->visitRoute('user.create')
            ->type('', 'email')
            ->type('gabrielattila', 'username')
            ->type('Gabriel', 'first_name')
            ->type('Moreno', 'last_name')
            ->press('Registrate');

        $this->seeRouteIs('user.create')
            ->see('El campo email es obligatorio');

        $this->assertEquals(0, User::count());
    }

    function test_a_user_enters_an_invalid_email()
    {
        $this->visitRoute('user.create')
            ->type('gabriel@.c', 'email')
            ->type('gabrielattila', 'username')
            ->type('Gabriel', 'first_name')
            ->type('Moreno', 'last_name')
            ->press('Registrate');

        $this->seeRouteIs('user.create')
            ->see('El campo email no es valido');

        $this->assertEquals(0, User::count());
    }


}
