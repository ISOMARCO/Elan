<?php

namespace App\Http\Controllers\Backend\Ads;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    public function main()
    {
        return view('Backend.Money_Manager.goods');
    }
}
