<?php

namespace App\Validators\Company;

use Venoudev\Results\Contracts\Result;
use Illuminate\Support\Facades\Validator;
use Venoudev\Results\Exceptions\CheckDataException;
use App\Entities\Company;

class UpdateCompanyValidator {

    public static function execute($data, $company_id):Company{

        $company = Company::find($company_id);
        if ($company == null){
            $exception = new NotFoundException();
            throw $exception;
        }

        $validator=Validator::make($data,[
          'name'=> ['string', 'max:100'],
          'description' => ['string', 'max:250'],
        ]);

        if ($validator->fails()) {
            $exception = new CheckDataException();
            $exception->addFieldErrors($validator->errors());
            throw $exception;
        }
        return $company;
    }
}
