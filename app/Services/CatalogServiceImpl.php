<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\Contracts\CatalogService;
use DB;

use App\Validators\ImageValidator;
use App\Validators\Catalog\RegisterCatalogValidator;
use App\Validators\Catalog\UpdateCatalogValidator;

use App\Actions\Catalog\RegisterCatalogAction;
use App\Actions\Catalog\UpdateCatalogAction;
use App\Actions\Catalog\ListCatalogAction;
use App\Actions\Catalog\FindCatalogAction;
use App\Actions\Company\FindCompanyAction;
use App\Actions\Shared\AttachimagesModelAction;
use App\Actions\Shared\DeleteAction;

use App\Entities\Catalog;

class CatalogServiceImpl implements CatalogService{

    public function registerCatalog($request):Catalog{

        $catalog=null;
        $data = $request->only(['company_id', 'file', 'campaing', 'start_date', 'pages', 'finish_date', 'limit_order_date']);

        RegisterCatalogValidator::execute($data);
        ImageValidator::execute($data);
        DB::transaction(function() use ($data, &$company){
            $company = FindCompanyAction::execute($data['company_id']);
            $catalog = RegisterCatalogAction::execute($data);
            $model_name = strtolower(str_replace(' ','_',$company->name.'/'.$catalog->campaing));
            AttachImagesModelAction::execute($data, 'catalog', $model_name, $company);
        });
        return $company;
    }

    public function findCatalog(int $company_id):Catalog{
        return FindCatalogAction::execute($company_id);
    }

    public function listCatalog(){
        return ListCatalogAction::execute();
    }

    public function listCatalogByCompany(int $company_id){
        return ListCatalogAction::execute();
    }

    public function updateCatalogData(Request $request, $company_id):Catalog{

        $company = null;
        $data = $request->only(['name', 'description']);

        UpdateCatalogValidator::execute($data, $company_id);
        DB::transaction(function() use ($data, &$company, $company_id){
            $company = UpdateCatalogAction::execute($data, $company_id);
        });
        return $company;
    }

    public function DeleteCatalog(Request $request, int $company_id):void{

        if($request->hard_delete == 'true'){
            DeleteAction::execute(Catalog::class, $company_id, true);
            return;
        }
        DeleteAction::execute(Catalog::class, $company_id, false);
        return;
    }

    public function StoreCatalogImage(Request $request):void{

    }

    public function UpdateCatalogImage(Request $request, int $company_id):void{

    }

    public function DeleteCatalogImage(Request $request, int $company_id):void{

    }
}
