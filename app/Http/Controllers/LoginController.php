<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    public function main()
    {
        echo Route::is();
        return view('Frontend.Login.main');
    }
}
