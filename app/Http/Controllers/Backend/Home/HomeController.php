<?php

namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Backend\Users;
class HomeController extends Controller
{
    public function main(Request $request)
    {
        return view('Backend.Home.main');
    }
}
