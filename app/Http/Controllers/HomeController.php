<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function main() : string
    {
        Cache::store('redis')->put('demo', "demo data", 120);
        echo Cache::store('redis')->get('demo');
        return view('Frontend.Home.main');
    }
}
