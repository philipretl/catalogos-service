<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;
use App\Entities\Company;

interface CatalogService{

    public function listCatalog();
    public function listCatalogByCompany($company_id);
    public function registerCatalog(Request $request):Catalog;
    public function findCatalog(int $catalog_id):Catalog;
    public function updateCatalogData(Request $request,int $catalog_id):Catalog;
    public function DeleteCatalog(Request $request, int $catalog_id):void;
    public function StoreCatalogImage(Request $request):void;
    public function UpdateCatalogImage(Request $request, int $catalog_id):void;
    public function DeleteCatalogImage(Request $request, int $catalog_id):void;

}
