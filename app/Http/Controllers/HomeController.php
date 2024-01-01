<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function main(Request $request) : string
    {
        $rememberToken = hash('sha256', uniqid());
        Cookie::queue(Cookie::make(encrypt('Remember_Me_Token'), $rememberToken, (60*24*365)));
        return view('Frontend.Home.main');
    }
}
