<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
class HomeController extends Controller
{
    public function main() : string
    {
        $cookie = Cookie::make('Remember_Me_Token', '1', 30);
        echo response(request()->cookie('Remember_Me_Token'))->withCookie($cookie);
        return view('Frontend.Home.main');
    }
}
