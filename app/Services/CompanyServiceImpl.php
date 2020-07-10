<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\Contracts\CompanyService;
use DB;

use App\Validators\ImageValidator;
use App\Validators\Company\RegisterCompanyValidator;
use App\Validators\Company\UpdateCompanyValidator;

use App\Actions\Company\RegisterCompanyAction;
use App\Actions\Company\UpdateCompanyAction;
use App\Actions\Company\ListCompanyAction;
use App\Actions\Company\FindCompanyAction;
use App\Actions\Shared\AttachimagesModelAction;
use App\Actions\Shared\DeleteAction;

use App\Entities\Company;

class CompanyServiceImpl implements CompanyService{

    public function registerCompany($request):Company{

        $company=null;
        $data = $request->only(['name', 'images', 'image', 'description']);

        RegisterCompanyValidator::execute($data);
        ImageValidator::execute($data);
        DB::transaction(function() use ($data, &$company){
            $company = RegisterCompanyAction::execute($data);
            $model_name = strtolower(str_replace(' ','_',$company->name));
            AttachImagesModelAction::execute($data, 'company', $model_name, $company);
        });
        return $company;
    }

    public function findCompany(int $company_id):Company{
        return FindCompanyAction::execute($company_id);
    }

    public function listCompany(){
        return ListCompanyAction::execute();
    }

    public function updateCompanyData(Request $request, $company_id):Company{

        $company = null;
        $data = $request->only(['name', 'description']);

        UpdateCompanyValidator::execute($data, $company_id);
        DB::transaction(function() use ($data, &$company, $company_id){
            $company = UpdateCompanyAction::execute($data, $company_id);
        });
        return $company;
    }

    public function DeleteCompany(Request $request, int $company_id):void{

        if($request->hard_delete == 'true'){
            DeleteAction::execute(Company::class, $company_id, true);
            return;
        }
        DeleteAction::execute(Company::class, $company_id, false);
        return;
    }

    public function StoreCompanyImage(Request $request):void{

    }

    public function UpdateCompanyImage(Request $request, int $company_id):void{

    }

    public function DeleteCompanyImage(Request $request, int $company_id):void{

    }
}
