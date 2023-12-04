<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function main() : string
    {
        echo Encrypt('123');
        return view('Frontend.Home.main');
    }
}
