<?php

namespace App\Services;

use Venoudev\Results\Contracts\Result;
use Illuminate\Http\Request;

use App\Services\Contracts\AuthService;
use App\Validators\Auth\LoginValidator;
use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;

class AuthServiceImpl implements AuthService{

    public function login($request){

        $data = $request->only(['email', 'password', 'phone']);
        LoginValidator::execute($data);
        return LoginAction::execute($data);
    }

    public function logout():void{

        LogoutAction::execute();
    }
}
