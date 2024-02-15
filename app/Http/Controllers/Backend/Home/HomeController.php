<?php

namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
class HomeController extends Controller
{
    public function main()
    {
        echo number_format(34018.6, 2);
        return view('Backend.Home.main');
    }
}
