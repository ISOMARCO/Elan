<?php

namespace App\Http\Controllers\Backend\Users;

use App\Http\Controllers\Controller;
use App\Models\Backend\Users\Users;
class UsersController extends Controller
{
    public function main()
    {
        $users = new Users();
        $userList = $users->allUsers();
        return view('Backend.Users.main', compact('userList'));
    }

    public function user_edit()
    {
        return view('Backend.Users.user_edit');
    }
}
