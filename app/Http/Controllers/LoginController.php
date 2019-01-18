<?php

namespace App\Http\Controllers;

use App\Models\Token;

class LoginController extends Controller
{
    public function login($token)
    {
        $token = Token::fineActive($token);

        if ($token == null){
            alert('Este enlace ya expiró, por favor solicita otro', 'danger');

            return redirect()->route('token.create');
        }

        $token->login();

        return redirect('/');
    }
}
