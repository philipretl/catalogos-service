<?php

namespace App\Validators\Auth;

use Venoudev\Results\Contracts\Result;
use Illuminate\Support\Facades\Validator;
use Venoudev\Results\Exceptions\CheckDataException;

class LoginValidator
{

    public static function execute($data):void{

        $validator=Validator::make($data,[
            'email' => ['bail', 'required_without_all:phone', 'string', 'email'],
            'phone'=> ['bail', 'required_without_all:email', 'string'],
            'password' => ['bail', 'required', 'min:8'],

        ]);

        if ($validator->fails()) {
            $exception = new CheckDataException();
            $exception->addFieldErrors($validator->errors());
            throw $exception;
        }
        return;
    }
}
