<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function main(Request $request) : string
    {
        Cookie::queue(Cookie::make('Remember_Me_Token', '1', 10));
        return view('Frontend.Home.main');
    }
}
