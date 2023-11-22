<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function main() : string
    {
        print_r(DB::table('Users')->where('Email', '=', 'inagiyev@icloud.com')->where('Password', '=', 'ismayil')->count());
        return view('Frontend.Home.main');
    }
}
