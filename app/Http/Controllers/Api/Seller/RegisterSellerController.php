<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Venoudev\Results\Contracts\Result;
use App\Services\Contracts\UserSellerService;

use App\Http\Resources\Seller\UserSellerResource;

class RegisterSellerController extends Controller
{
    protected $result;
    protected $service;


    public function __construct(Result $result, UserSellerService $service){
        $this->result = $result;
        $this->service = $service;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $seller = $this->service->registerSellerUser($request);

        $this->result->success();
        $this->result->addMessage('REGISTERED','Process completed.');
        $this->result->setDescription('Seller registered succesfuly in nuestroscatalogos.com.');
        $this->result->addDatum('seller_user', UserSellerResource::make($seller));
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
