<?php

namespace App\Validators\Auth;

use Illuminate\Support\Facades\Validator;
use Venoudev\Results\Exceptions\CheckDataException;

class RegisterUserValidator{

    public static function execute($data){

        $validator = Validator::make($data, [
            'name' => ['bail', 'required', 'string'],
            'email' => ['bail','required_without_all:phone','unique:users','string', 'email'],
            'phone'=> ['bail','required_without_all:email', 'string','unique:users'],
            'password' => ['bail', 'required', 'confirmed', 'min:8'],
        ]);

        if ($validator->fails()) {
            $exception = new CheckDataException();
            $exception->addFieldErrors($validator->errors());
            throw $exception;
        }
    }

}
