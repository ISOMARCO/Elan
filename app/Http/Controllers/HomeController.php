<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
use App\Helpers\Functions;

class HomeController extends Controller
{
    public function main() : string
    {
        echo encrypt('Hello');

        //echo decrypt('Hello');
        return view('Frontend.Home.main');
    }
}
