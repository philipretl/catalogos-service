<?php

namespace App\Actions\Auth;

use App\Entities\User;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction{

    public static function execute($data, $role):User{

        $user = User::make([
            'name' => $data['name'],
            'phone' => $data['phone'],

        ]);
        if(array_key_exists('email', $data)){
            $user->email=$data['email'];
        }
        if(array_key_exists('phone', $data)){
            $user->phone=$data['phone'];
        }
        $user->assignRole($role);
        $user->password = Hash::make($data['password']);
        $user->save();
        return $user;

    }
}
