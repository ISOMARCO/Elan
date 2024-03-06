<?php

namespace App\Http\Controllers\Frontend\Home;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function main() : string
    {
        print_r(Session::all());
        return view('Frontend.Home.main');
    }
}
