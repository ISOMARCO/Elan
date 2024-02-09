<?php

namespace App\Http\Controllers\Frontend\Home;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function main(Request $request) : string
    {
        return view('Frontend.Home.main');
    }
}
