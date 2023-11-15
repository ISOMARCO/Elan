<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Auth\Users;
class LoginController extends Controller
{
    public function main()
    {
        $users = new Users();
        $users->deleteUser();
        return view('Frontend.Login.main');
    }
}
