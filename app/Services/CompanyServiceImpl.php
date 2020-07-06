<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\Contracts\CompanyService;

use App\Entities\Company;
use App\Validators\ImageValidator;
use App\Validators\Company\RegisterCompanyValidator;
use App\Actions\Company\RegisterCompanyAction;
use App\Actions\Company\ListCompanyAction;
use App\Actions\Company\FindCompanyAction;
use App\Actions\Shared\AttachimagesModelAction;
use App\Actions\Shared\DeleteAction;

class CompanyServiceImpl implements CompanyService{

    public function registerCompany($request):Company{

        $data = $request->only(['name', 'images', 'image']);
        RegisterCompanyValidator::execute($data);
        ImageValidator::execute($data);
        $company = RegisterCompanyAction::execute($data);
        AttachImagesModelAction::execute($data, 'company', Company::class, $company->id);

        return $company;
    }

    public function findCompany(int $company_id):Company{
        return FindCompanyAction::execute($company_id);
    }

    public function listCompany(){
        return ListCompanyAction::execute();
    }

    public function DeleteCompany(Request $request, int $company_id):void{

        $model = Company::class;
        if($request->hard_delete == 'true'){
            DeleteAction::execute($model, $company_id, true);
            return;
        }

        DeleteAction::execute($model, $company_id, false);
        return;
    }
}
