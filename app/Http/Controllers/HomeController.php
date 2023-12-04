<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
class HomeController extends Controller
{
    public function main() : string
    {
        Cookie::make(encrypt('Remember_Me_Token'), '1', 30);
        echo Cookie::has(encrypt('Remember_Me_Token'));
        return view('Frontend.Home.main');
    }
}
