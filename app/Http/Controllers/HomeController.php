<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Users;
class HomeController extends Controller
{
    public function main()
    {
        print_r(Users::get());
        return view('Frontend.Home.main');
    }
}
