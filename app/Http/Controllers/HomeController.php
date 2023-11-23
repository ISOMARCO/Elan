<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
class HomeController extends Controller
{
    public function main() : string
    {
        return view('Frontend.Home.main');
    }
}
