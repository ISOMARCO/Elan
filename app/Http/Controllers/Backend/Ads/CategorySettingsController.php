<?php

namespace App\Http\Controllers\Backend\Ads;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategorySettingsController extends Controller
{
    public function main()
    {
        return view('Backend.Ads.category_settings');
    }
}
