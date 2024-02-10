<?php

namespace App\Http\Controllers\Backend\Users;

use App\Http\Controllers\Controller;
use App\Models\Backend\Users\Users;
class UsersController extends Controller
{
    public function main()
    {
        $users = new Users();
        print_r($users->allUsers()[0]->Id);
        return view('Backend.Users.main');
    }
}
