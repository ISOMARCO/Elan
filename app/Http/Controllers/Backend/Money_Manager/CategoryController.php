<?php

namespace App\Http\Controllers\Backend\Money_Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function main(Request $request) : string
    {
        return view('Backend.Money_Manager.main');
    }
}
