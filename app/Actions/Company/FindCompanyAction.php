<?php

namespace App\Actions\Company;

use App\Entities\Company;
use Venoudev\Results\Exceptions\NotFoundException;

class FindCompanyAction{

    public static function execute($company_id){

        $company = Company::with(['images'])->find($company_id);
        if ($company == null){
            $exception = new NotFoundException();
            throw $exception;
        }
        return $company;
    }
}
