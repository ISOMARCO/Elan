<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function main()
    {
        return view('Frontend.User.setting');
    }
}
