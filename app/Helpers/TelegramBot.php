<?php
namespace App\Helpers;
use App\Models\Logs\Logs;

class TelegramBot
{
    const API_URL = 'https://api.telegram.org/bot';
    public int|NULL $chatId = NULL;
    protected int|NULL $userId = NULL;
    protected string|NULL $file_path = NULL;
    protected int|NULL $messageId = NULL;
    protected  int|NULL $callBackQueryId = NULL;
    private function request(string $method, array $posts = [], bool $file = false)
    {
        if($file)
        {
            $url = 'https://api.telegram.org/file/bot'.env('TELEGRAM_TOKEN').'/'.$this->file_path;
        }
        else
        {
            $url = self::API_URL.env('TELEGRAM_TOKEN').'/'.$method;
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($posts));

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $count = 0;
        while ($httpCode == 301 || $httpCode == 302) {
            if($count == 100) break;
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($response, 0, $headerSize);
            preg_match('/Location:(.*?)\n/', $header, $matches);
            $redirectUrl = trim(array_pop($matches));

            curl_setopt($ch, CURLOPT_URL, $redirectUrl);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $count++;
        }
        if (curl_errno($ch)) {
            return 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        if(!empty($result))
        {
            $logs = new Logs();
            $logs->insertTelegramBotLog($result, '65');
        }
        return json_decode($result, true);
    }

    public function getUserProfilePhotos()
    {
        return $this->request('getUserProfilePhotos', [
            'user_id' => $this->userId
        ]);
    }
    public function getFile(int $file_id)
    {
        $file_path = $this->request('getFile', [
            'file_id' => $file_id
        ]);
        $file_path_array = json_decode($file_path, true);
        $this->file_path = $file_path_array['result']['file_path'];
        return $file_path;
    }
    public function setWebhook(string $url)
    {
        return $this->request('setWebhook', [
            'url' => $url
        ]);
    }

    public function setMyCommands(array $data = [])
    {
        return $this->request('setMyCommands', $data);
    }

    public function sendContact(array $data = [])
    {
        if(!isset($data['chat_id']))
        {
            $data['chat_id'] = $this->chatId;
        }
        $this->request('sendContact', $data);
    }

    public function getWebhookInfo()
    {
        return $this->request('getWebhookInfo');
    }

    public function deleteMessage($messageId)
    {
        return $this->request("deleteMessage", [
            'chat_id' => $this->chatId,
            'message_id' => $messageId
        ]);
    }

    public function getData()
    {
        $data = json_decode( file_get_contents("php://input"), true );
        if(isset($data['callback_query']['data']))
        {
            $this->chatId = $data['callback_query']['message']['chat']['id'];
            $this->callBackQueryId = $data['callback_query']['id'];
            if(isset($data['message']['from']['id']))
            {
                $this->userId = $data['callback_query']['message']['from']['id'];
            }
        }
        elseif(!empty($data))
        {
            $this->chatId = $data['message']['chat']['id'];
            $this->callBackQueryId = NULL;
            if(isset($data['message']['from']['id']))
            {
                $this->userId = $data['message']['from']['id'];
            }
        }
        if(!empty($data))
        {
            $logs = new Logs();
            $logs->insertTelegramBotLog(json_encode($data, true), '145');
        }
        return $data;
    }

    public function sendMessage(array $data = [])
    {
        if(!isset($data['chat_id']))
        {
            $data['chat_id'] = $this->chatId;
        }
        $send = $this->request('sendMessage', $data);
        return $send;
    }

    public function answerCallBackQuery(array $data = [])
    {
        if(!isset($data['callback_query_id']))
        {
            $data['callback_query_id'] = $this->callBackQueryId;
        }
        if(!isset($data['show_alert']))
        {
            $data['show_alert'] = false;
        }
        return $this->request('answerCallBackQuery', $data);
    }

    public function setMessageReaction(array $data = [])
    {
        if(!isset($data['chat_id']))
        {
            $data['chat_id'] = $this->chatId;
        }
        if(!isset($data['message_id']))
        {
            $data['message_id'] = $this->messageId;
        }
        return $this->request('setMessageReaction', $data);
    }
}
