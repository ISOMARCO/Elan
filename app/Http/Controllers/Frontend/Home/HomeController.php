<?php

namespace App\Http\Controllers\Frontend\Home;
#use App\Helpers\TelegramActions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function main(Request $request) : string
    {
        //$method = 'print';
        //$telegram = new TelegramActions();
        //echo call_user_func([$telegram, $method]);
        //echo $telegram->{$method}();
        #print_r(DB::table('Users')->get());
        return view('Frontend.Home.main');
    }
}
