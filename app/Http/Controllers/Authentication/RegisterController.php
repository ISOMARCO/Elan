<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function main()
    {
        return view('Frontend.Login.main');
    }
}
