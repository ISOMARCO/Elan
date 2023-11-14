<?php

namespace App\Http\Controllers\Ads;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class Ads1Controller extends Controller
{
    public function __construct()
    {
        echo "AA";
    }
    public function main()
    {
        echo "OK";
        #return view('Frontend.Home.main');
    }
}
