<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    public function main()
    {
        echo request()->route()->getName()."Controller";
        return view('Frontend.Login.main');
    }
}
