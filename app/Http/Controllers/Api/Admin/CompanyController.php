<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Venoudev\Results\Contracts\Result;
use Venoudev\Results\ApiJsonResources\PaginatedResource;
use App\Services\Contracts\CompanyService;
use App\Http\Resources\Admin\CompanyAdminResource;

class CompanyController extends Controller
{

    protected $service;
    protected $result;

    public function __construct(Result $result, CompanyService $service){
        $this->service = $service;
        $this->result = $result;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = $this->service->listCompany();

        if($companies->isEmpty()){
            $this->result->success();
            $this->result->addMessage('EMPTY_LIST','Empty model list solicited');
            $this->result->setDescription('List empty of companies registred in nuestroscatalogos.com');
            return $this->result->getJsonResponse();
        }


        $data = CompanyAdminResource::collection($companies);
        $this->result->success();
        $this->result->addMessage('PAGINATED_LIST','Paginated model list');
        $this->result->setDescription('List of companies registred in nuestroscatalogos.com');
        $this->result->addDatum('companies_paginated', PaginatedResource::make($data->paginate(15), 'companies'));

        return $this->result->getJsonResponse();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = $this->service->registerCompany($request);

        $this->result->success();
        $this->result->addMessage('REGISTERED','Model registered in the service');
        $this->result->setDescription('Company registred succesfuly in nuestroscatalogos.com');
        $this->result->addDatum('company', CompanyAdminResource::make($company));
        return $this->result->getJsonResponse();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($company_id)
    {
        $company = $this->service->findCompany($company_id);

        $this->result->success();
        $this->result->addMessage('FOUND','Model found in the service');
        $this->result->setDescription('Company found succesfuly in nuestroscatalogos.com');
        $this->result->addDatum('company', CompanyAdminResource::make($company));
        return $this->result->getJsonResponse();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $company_id)
    {
        $company = $this->service->updateCompanyData($request, $company_id);

        $this->result->success();
        $this->result->addMessage('UPDATED','Model updated in the service');
        $this->result->setDescription('Company data updated succesfuly in nuestroscatalogos.com');
        $this->result->addDatum('company', CompanyAdminResource::make($company));
        return $this->result->getJsonResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $company_id)
    {
        $this->service->deleteCompany($request, $company_id);
        $this->result->success();
        $this->result->addMessage('DELETED','Model deleted in the service');
        $this->result->setDescription('Company deleted succesfuly in nuestroscatalogos.com');

        return $this->result->getJsonResponse();
    }

}
