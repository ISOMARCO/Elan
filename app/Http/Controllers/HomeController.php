<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
class HomeController extends Controller
{
    public function main() : string
    {
        //echo Session::has('id');
        return view('Frontend.Home.main');
    }
}
