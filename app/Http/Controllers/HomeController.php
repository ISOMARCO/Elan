<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function main(Request $request) : string
    {
        #echo Cookie::make('name', 'value', 10);
        echo Cookie::get('name');
        return view('Frontend.Home.main');
    }
}
