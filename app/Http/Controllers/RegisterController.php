<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Token;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return  view('register.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
        ],[
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email no es valido',
            'last_name' => 'El campo apellido es obligatorio'
        ]);

        $user = User::create($request->all());

        Token::generateFor($user)->sendByEmail();

        return redirect()->route('user.confirm');
    }

    public function confirm()
    {
        return  view('register.registerConfirmation');
    }
}
