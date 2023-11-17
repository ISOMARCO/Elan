<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
class HomeController extends Controller
{
    public function main() : string
    {
        Cache::store('redis')->pull('Key');
        return view('Frontend.Home.main');
    }
}
