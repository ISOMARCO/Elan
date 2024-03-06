<?php

namespace App\Http\Controllers\Frontend\Home;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function main() : string
    {
        return view('Frontend.Home.main');
    }
}
