<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function main(Request $request) : string
    {
        print_r(DB::table('Users')->get());
        return view('Frontend.Home.main');
    }
}
