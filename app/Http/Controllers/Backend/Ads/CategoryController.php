<?php

namespace App\Http\Controllers\Backend\Ads;

use App\Exceptions\Backend\Ads\AdsException;
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

    public function createAction(Request $request)
    {
        if($request->ajax() || $request->wantsJson())
        {
            $category = new Category();
            try
            {
                $category->name($request->post('name'))->parent($request->post('parent'));
            }
            catch(AdsException $e)
            {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
        abort(403, 'Unauthorized');
    }

}
