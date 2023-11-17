<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
class HomeController extends Controller
{
    public function main() : string
    {
        Cache::store('redis')->put('Key', 'Value', 120);
        if(Cache::store('redis')->has('Key'))
        {
            echo "12";
        }
        else
        {
            echo "16";
        }
        Cache::store('redis')->pull('Key');
        if(Cache::store('redis')->has('Key'))
        {
            echo "21";
        }
        else
        {
            echo "25";
        }
        return view('Frontend.Home.main');
    }
}
