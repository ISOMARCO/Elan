<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
class HomeController extends Controller
{
    public function main(Request $request) : string
    {
        return view('Frontend.Home.main');
    }
}
