<?php

namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
class HomeController extends Controller
{
    public function main()
    {
        return view('Backend.Home.main');
    }
}
