<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('IsLogin');
    }
    public function main()
    {
        return view('Frontend.Login.main');
    }
}
