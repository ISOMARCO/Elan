<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function main() : string
    {
        Cache::store('redis')->put('key', ['name' => 'Ismayil'], 360);
        print_r(Cache::store('redis')->get('key'));
        return view('Frontend.Home.main');
    }
}
