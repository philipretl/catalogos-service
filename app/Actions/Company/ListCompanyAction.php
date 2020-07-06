<?php

namespace App\Actions\Company;

use App\Entities\Company;

class ListCompanyAction{

    public static function execute(){

        $companies = Company::with(['images'])->get();
        return $companies;
    }
}
