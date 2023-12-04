<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
use App\Helpers\Functions;

class HomeController extends Controller
{
    public function main() : string
    {
        echo Cookie::has(Decrypt('Remember_Me_Token'));
        return view('Frontend.Home.main');
    }
}
