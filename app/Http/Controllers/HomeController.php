<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    public function main(Request $request) : string
    {
        $cookie = Cookie::make('hello', '1', 10);
        $response =  new Response();
        $response->withCookie($cookie);
        echo $request->cookie('hello', 'yoxdu');
        return view('Frontend.Home.main');
    }
}
