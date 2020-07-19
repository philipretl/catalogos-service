<?php

namespace App\Services;

use App\Services\Contracts\UserSellerService;
use Illuminate\Http\Request;
use App\Entities\User;

use App\Validators\Auth\RegisterUserValidator;
use App\Actions\Auth\RegisterUserAction;

class UserSellerServiceImpl implements UserSellerService{

    public function registerSellerUser(Request $request):User{
        $data = $request->only([
            'name', 'email', 'password', 'password_confirmation', 'phone'
        ]);
        RegisterUserValidator::execute($data);
        $user = RegisterUserAction::execute($data, 'seller');
        return $user;
    }

}
