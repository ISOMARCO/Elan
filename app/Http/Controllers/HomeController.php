<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function main() : string
    {

        return view('Frontend.Home.main');
    }
}
