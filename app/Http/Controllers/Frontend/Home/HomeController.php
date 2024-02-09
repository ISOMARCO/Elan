<?php

namespace App\Http\Controllers\Frontend\Home;
use App\Http\Controllers\Controller;
use http\Client\Request;

class HomeController extends Controller
{
    public function main(Request $request) : string
    {
        return view('Frontend.Home.main');
    }
}
