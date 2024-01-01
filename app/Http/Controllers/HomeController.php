<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function main(Request $request) : string
    {
        Cookie::queue(Cookie::make('name', 'value', 100));
        echo Cookie::get('name');
        return view('Frontend.Home.main');
    }
}
