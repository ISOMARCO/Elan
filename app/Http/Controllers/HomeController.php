<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function main() : string
    {
        $cookie = Cookie::make('Hello', '1', 10);
        return response()->view('Frontend.Home.main')->withCookie($cookie);
    }
}
