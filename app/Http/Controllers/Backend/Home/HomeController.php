<?php

namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
class HomeController extends Controller
{
    public function main()
    {
        echo preg_replace('/(\d{1,2})(?=(\d{3})+$)/', '$1,', 10000);
        return view('Backend.Home.main');
    }
}
