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
        print_r($telegram->setWebhook(url('/telegram_webhook')));
        return view('Frontend.Home.main');
    }
}
