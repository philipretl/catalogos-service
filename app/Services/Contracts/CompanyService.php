<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;
use App\Entities\Company;

interface CompanyService{

    public function listCompany();
    public function registerCompany(Request $request):Company;
    public function findCompany(int $company_id):Company;
    public function updateCompanyData(Request $request,int $company_id):Company;
    public function deleteCompany(Request $request, int $company_id):void;
    public function storeCompanyImage(Request $request):void;
    public function updateCompanyImage(Request $request, int $company_id):void;
    public function deleteCompanyImage(Request $request, int $company_id):void;

}
