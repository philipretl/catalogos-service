<?php

namespace App\Validators\Company;

use Venoudev\Results\Contracts\Result;
use Illuminate\Support\Facades\Validator;
use Venoudev\Results\Exceptions\CheckDataException;

class RegisterCompanyValidator {

    public static function execute($data){
        $validator=Validator::make($data,[
          'name'=> ['required', 'string', 'max:100'],
          'description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            $exception = new CheckDataException();
            $exception->addFieldErrors($validator->errors());
            throw $exception;
        }
        return;
    }
}
