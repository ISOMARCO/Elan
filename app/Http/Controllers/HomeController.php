<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function main(Request $request) : string
    {
        echo $request->cookie(encrypt('Remember_Me_Token'), 'yoxdu');
        return view('Frontend.Home.main');
    }
}
