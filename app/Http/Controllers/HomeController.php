<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
class HomeController extends Controller
{
    public function main(Request $request) : string
    {
        Cookie::queue(Cookie::make('deneme', '123', (60*24*365)));
        Cookie::queue(Cookie::forget('deneme'));
        echo request()->cookie('deneme');
        return view('Frontend.Home.main');
    }
}
