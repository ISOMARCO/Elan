<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
class HomeController extends Controller
{
    public function main() : string
    {
        echo decrypt('eyJpdiI6Ik42L2lMeWltNUkrR3NRV25rc2x6T3c9PSIsInZhbHVlIjoiTlJRdGpLMnZyRmFkaVVWQ3A4TE9Tdz09IiwibWFjIjoiNjZkMTM4YjBlMTQzOGQ4MGMzODMzNGU4NGFkMWQ5N2YwNzQ2NTkwYjkyMWY0YTlhZTI0MDdhMDgyZmVlMjI5NiIsInRhZyI6IiJ9');

        //echo decrypt('Hello');
        return view('Frontend.Home.main');
    }
}
