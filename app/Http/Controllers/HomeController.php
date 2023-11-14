<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Users;
class HomeController extends Controller
{
    public function main()
    {
        return view('Frontend.Home.main');
    }
}
