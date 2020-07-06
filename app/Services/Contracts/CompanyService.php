<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;
use App\Entities\Company;

interface CompanyService{

    public function registerCompany(Request $request):Company;
    public function findCompany(int $company_id):Company;
    public function listCompany();
    public function DeleteCompany(Request $request, int $company_id):void;

}
