<?php

namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function App\Http\Controllers\Backend\view;
class HomeController extends Controller
{
    public function main(Request $request)
    {
        return view('Backend.Home.main');
    }
}
