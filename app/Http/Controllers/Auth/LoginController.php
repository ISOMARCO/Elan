<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function main()
    {
        return view('Frontend.Login.main');
    }
}
