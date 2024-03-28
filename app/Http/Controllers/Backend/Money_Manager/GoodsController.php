<?php

namespace App\Http\Controllers\Backend\Money_Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Backend\Money_Manager\Goods;
use App\Exceptions\Backend\Money_Manager\MoneyManagerException;

class GoodsController extends Controller
{
    public function main()
    {
        try
        {
            $goods = new Goods();
            $all = $goods->allGoods();
            return view('Backend.Money_Manager.goods', compact('all'));
        }
        catch(\Exception $e)
        {
            $all = (object) [];
            return view('Backend.Money_Manager.goods', compact('all'));
        }
    }

    public function createAction(Request $request) : RedirectResponse|JsonResponse
    {
//        if(!$request->isMethod('POST'))
//        {
//            return abort(403, 'Method not allowed');
//        }
        //if($request->ajax() || $request->wantsJson())
        //{
            $goods = new Goods();
            try
            {
                $goods->name($request->post('name'))->barcode($request->post('barcode'))->price($request->post('price'))->tax($request->post('tax'))->status($request->post('status'));
                return response()->json(['success' => 'Məhsul əlavə olundu', 'goods' => $goods->createGoods()]);
            }
            catch(MoneyManagerException $e)
            {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        //}
        //return abort(403, 'Unauthorized');
    }
}
