<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;
class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('IsLogin');
    }
    public function main()
    {
        return view('Frontend.Login.main');
    }
}
