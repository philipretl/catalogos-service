<?php

namespace App\Http\Controllers\Api;

use Venoudev\Results\Contracts\Result;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Contracts\AuthService;
use App\Http\Resources\UserLoginResource;

class AuthController extends Controller
{
    protected $authenticationService;
    protected $result;

    public function __construct(Result $result, AuthService $authenticationService){
        $this->authenticationService = $authenticationService;
        $this->result = $result;
    }

    public function login(Request $request){

        $user = $this->authenticationService->login($request);
        $this->result->success();
        $this->result->addMessage('AUTHENTIFIED','User authentified correctly.');
        $this->result->setDescription('Welcome Be Awesome!.');
        $this->result->addDatum('user',UserLoginResource::make($user));

        return $this->result->getJsonResponse();
    }


    public function logout(Request $request){

        $this->authenticationService->logout();
        $this->result->success();
        $this->result->addMessage('LOGOUT','Successfully logged out.');
        $this->result->setDescription('See you soon, be Awesome!.');

        return $this->result->getJsonResponse();
    }
}
