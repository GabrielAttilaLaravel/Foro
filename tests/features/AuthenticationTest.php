<?php


use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthenticationTest extends FeatureTestCase
{
    function test_a_user_can_login_with_a_token_url()
    {
        $user = $this->defaultUser();

        $token = Token::generateFor($user);

        $this->visitRoute('login', $token);

        $this->seeIsAuthenticated()
            ->seeIsAuthenticatedAs($user);

        $this->dontSeeInDatabase('tokens', [
            'id' => $token->id
        ]);

        $this->seePageIs('/');
    }

    function test_a_user_cannot_login_with_an_invalid_token()
    {
        $user = $this->defaultUser();

        $token = Token::generateFor($user);

        $invalidToken = str_random(60);

        $this->visitRoute('login', $invalidToken);

        $this->dontSeeIsAuthenticated()
            ->seeRouteIs('token.create')
            ->see('Este enlace ya expiró, por favor solicita otro');


        $this->seeInDatabase('tokens', [
            'id' => $token->id
        ]);
    }

    function test_a_user_cannot_use_the_same_token_twice()
    {
        $user = $this->defaultUser();

        $token = Token::generateFor($user);

        $token->login();

        Auth::logout();

        $this->visitRoute('login', $token);

        $this->dontSeeIsAuthenticated()
            ->seeRouteIs('token.create')
            ->see('Este enlace ya expiró, por favor solicita otro');

        $this->dontSeeInDatabase('tokens', [
            'id' => $token->id
        ]);
    }

    function test_the_token_expires_after_30_minutes()
    {
        $user = $this->defaultUser();

        $token = Token::generateFor($user);

        Carbon::setTestNow(Carbon::parse('+ 31 minutes'));

        $this->visitRoute('login', $token);

        $this->dontSeeIsAuthenticated()
            ->seeRouteIs('token.create')
            ->see('Este enlace ya expiró, por favor solicita otro');
    }

    function test_the_token_is_case_sensitive()
    {
        $user = $this->defaultUser();

        $token = Token::generateFor($user);

        $this->visitRoute('login', strtolower($token->token));

        $this->dontSeeIsAuthenticated()
            ->seeRouteIs('token.create')
            ->see('Este enlace ya expiró, por favor solicita otro');
    }
}
