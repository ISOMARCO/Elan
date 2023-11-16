<?php

namespace App\Http\Controllers;
use App\Models\Users;
use App\Helpers\TelegramBot;
class HomeController extends Controller
{
    public function main()
    {
        echo url('/telegram_webhook');
        $telegram = new TelegramBot();
        print_r($telegram->getWebhookInfo());
        return view('Frontend.Home.main');
    }
}
