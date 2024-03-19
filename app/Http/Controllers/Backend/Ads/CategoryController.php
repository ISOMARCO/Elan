<?php

namespace App\Http\Controllers\Backend\Ads;

use App\Http\Controllers\Controller;
use App\Models\Backend\Ads\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function main(Request $request)
    {
        $category = new Category();
        $allCategory = $category->allCategory();
        return view('Backend.Ads.category', compact('allCategory'));
    }

}
