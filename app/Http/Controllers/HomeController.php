<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function main() : string
    {
        Cache::store('redis')->put('Key', 'Value', 120);
        if(Cache::has('Key'))
        {
            echo "var";
        }
        else
        {
            echo "yox";
        }
        return view('Frontend.Home.main');
    }
}
