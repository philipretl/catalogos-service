<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use Venoudev\Results\Exceptions\CheckDataException;
use App\Rules\ActiveModelRule;

class ExistAndActiveModelValidator{

    /**
     * Undocumented function
     *
     * @param Eloquent/Model $model
     * @param string $field
     * @param string $table
     * @param array $data
     * @return void
     */
    public static function execute(array $data, $model, string  $field, string $table){

        $validator = Validator::make($data, [
            $field => ['bail', 'required', 'exists:'.$table.',id', new ActiveModelRule($model)],
        ]);

        if ($validator->fails()) {
            $exception = new CheckDataException();
            $exception->addFieldErrors($validator->errors());
            throw $exception;
        }
        return;
    }

}
