<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
class HomeController extends Controller
{
    public function main() : string
    {
        echo Session::get('id', 'yoxdu');
        return view('Frontend.Home.main');
    }
}
