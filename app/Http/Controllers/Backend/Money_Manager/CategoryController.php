<?php

namespace App\Http\Controllers\Backend\Money_Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function main()
    {
        return view('Backed.Money_Manager.main');
    }
}
