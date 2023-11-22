<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function main() : string
    {
        print_r(DB::table('Users')->whereRaw("Email = ? and Password = ?", [$email_or_phone, $password]));
        return view('Frontend.Home.main');
    }
}
