<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Hash;
use Auth;

use App\Exceptions\FailLoginException;
use App\Entities\User;


class LoginAction{

    public static function execute($data ){

        $user = null;
        $user_by_email = null;
        $user_by_phone = null;

        if(array_key_exists('email', $data)){
            $user_by_email = User::where('email', $data['email'])->first();
        }
        if(array_key_exists('phone', $data)){
            $user_by_phone = User::where('phone', $data['phone'])->first();
        }

        if($user_by_phone == null && $user_by_email == null){
            $exception = new FailLoginException();
            throw $exception;
        }
        if($user_by_email != null) $user = $user_by_email;
        if($user_by_phone != null) $user = $user_by_phone;

        if(Hash::check($data['password'], $user->password) == false) {
            $exception = new FailLoginException();
            throw $exception;
        }
        $accessToken = $user->createToken('auth_token')->accessToken;
        $user->access_token = $accessToken;
        $user->roles = $user->getRoleNames()->all();

        return $user;
    }
}
