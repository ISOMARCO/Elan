<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
class HomeController extends Controller
{
    public function main(Request $request) : string
    {
        Cookie::make('hello', '1', 10);
        echo $request->cookie('hello', 'yoxdu');
        return view('Frontend.Home.main');
    }
}
