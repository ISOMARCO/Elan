<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Helpers\TelegramBot;
//use Illuminate\Http\Request;

class TelegramWebhookController extends Controller
{
    public function main()
    {
        echo "OK";
        $telegram = new TelegramBot();
        $data = $telegram->getData();
        if(!empty($data))
        {
            if(strtolower($data['message']['text']) == 'hello')
            {
                $telegram->sendMessage([
                    'text' => 'Hello'
                ]);
            }
        }
    }
}
