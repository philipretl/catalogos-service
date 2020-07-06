<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;
use App\Entities\Company;

interface CompanyService{

    public function registerCompany(Request $request):Company;
    public function findCompany(int $id):Company;
    public function listCompany();
    public function DeleteCompany(int $id):void;

}
