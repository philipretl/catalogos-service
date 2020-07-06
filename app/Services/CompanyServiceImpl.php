<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\Contracts\CompanyService;

use App\Entities\Company;
use App\Validators\ImageValidator;
use App\Validators\Company\RegisterCompanyValidator;
use App\Actions\Company\RegisterCompanyAction;
use App\Actions\Company\ListCompanyAction;
use App\Actions\Shared\AttachimagesModelAction;

class CompanyServiceImpl implements CompanyService{

    public function registerCompany($request):Company{

        $data = $request->only(['name', 'images', 'image']);

        RegisterCompanyValidator::execute($data);
        ImageValidator::execute($data);
        $company = RegisterCompanyAction::execute($data);
        AttachImagesModelAction::execute($data, 'company', Company::class, $company->id);

        return $company;
    }

    public function findCompany(int $id):Company{
        return null;
    }

    public function listCompany(){
        return ListCompanyAction::execute();
    }

    public function DeleteCompany(int $id):void{

    }
}
