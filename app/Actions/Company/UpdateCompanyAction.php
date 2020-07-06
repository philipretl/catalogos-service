<?php

namespace App\Actions\Company;

use App\Entities\Company;

class UpdateCompanyAction{

    public static function execute($data, int $company_id):Company{
        $company = Company::find($company_id);
        $company->fill($data);
        $company->save();
        return $company;
    }
}
