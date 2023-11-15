<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Helpers\TelegramBot;
class HomeController extends Controller
{
    public function main()
    {
        $telegram = new TelegramBot();
        echo $telegram->demo();
        return view('Frontend.Home.main');
    }
}
