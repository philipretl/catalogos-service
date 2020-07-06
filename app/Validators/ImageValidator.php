<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use Venoudev\Results\Exceptions\CheckDataException;

class ImageValidator{

    public static function execute($data):void{

        $validator = Validator::make($data, [
            'image' => ['required_without_all:images','file', 'image'],
            'images'=> ['required_without_all:image', 'array'],
            'images.*' => ['bail', 'required_with_all:images', 'file', 'image'],
        ]);

        if ($validator->fails()) {
            $exception = new CheckDataException();
            $exception->addFieldErrors($validator->errors());
            throw $exception;
        }
        return;

    }

}
