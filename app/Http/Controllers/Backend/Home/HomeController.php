<?php

namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    public function main(Request $request)
    {
        echo date('Y-m-d H:i:s');
        return view('Backend.Home.main');
    }
}
