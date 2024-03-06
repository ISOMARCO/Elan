<?php

namespace App\Http\Controllers\Frontend\Home;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function main() : string
    {
        echo "ok";
        return view('Frontend.Home.main');
    }
}
