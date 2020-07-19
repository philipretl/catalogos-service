<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;
use App\Entities\User;

interface UserSellerService {

    public function registerSellerUser(Request $request):User;
}
