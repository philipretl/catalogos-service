<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Venoudev\Results\Contracts\Result;
use Venoudev\Results\ApiJsonResources\PaginatedResource;
use App\Services\Contracts\CompanyService;
use App\Http\Resources\Admin\CompanyResource;

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
        $data = CompanyResource::collection($companies);
        $this->result->success();
        $this->result->addMessage('PAGINATED_LIST','Paginated model list');
        $this->result->setDescription('List of companies registred in nuestroscatalogos.com');
        $this->result->addDatum('companies_paginated',PaginatedResource::make($data->paginate(15),'companies'));

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
        $this->result->addDatum('company', CompanyResource::make($company));
        return $this->result->getJsonResponse();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
