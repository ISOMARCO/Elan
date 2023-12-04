<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function main() : string
    {
        $cookie = Cookie::make('Hello', '1', 10);
        echo $cookie->getValue();
        if(Cookie::has('Hello'))
        {
            echo 'var';
        }
        else
        {
            echo 'yoxdu';
        }
        return view('Frontend.Home.main');
    }
}
