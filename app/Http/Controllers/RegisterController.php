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
        //TODO: add valiadtion!

        $user = User::create($request->all());

        Token::generateFor($user)->sendByEmail();
    }
}
