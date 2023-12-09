<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function main(Request $request) : string
    {
        Cookie::queue(Cookie::make(encrypt('deneme'), '123', (60*24*365)));
        echo $request->cookie(encrypt('deneme'));
        return view('Frontend.Home.main');
    }
}
