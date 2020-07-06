<?php

namespace App\Actions\Company;

use App\Entities\Company;

class RegisterCompanyAction{

    public static function execute($data):Company{

        $company = Company::create([
            'name' => $data['name'],
        ]);

        return $company;
    }
}
