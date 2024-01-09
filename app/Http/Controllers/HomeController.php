<?php

namespace App\Http\Controllers;
use App\Helpers\TelegramActions;
use Illuminate\Http\Request;
#use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function main(Request $request) : string
    {
        $telegramActions = new TelegramActions();
        echo $telegramActions->print();
        #print_r(DB::table('Users')->get());
        return view('Frontend.Home.main');
    }
}
