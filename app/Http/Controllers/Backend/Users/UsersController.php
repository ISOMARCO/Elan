<?php

namespace App\Http\Controllers\Backend\Users;

use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function main()
    {
        return view('Backend.Users.main');
    }
}
