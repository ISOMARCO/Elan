<?php

namespace App\Exceptions\Backend\Authentication;

use Exception;

class Authentication extends Exception
{
    protected $code = 500;
    public function __construct($statusCode = NULL, $message = NULL)
    {
        $this->code = $statusCode;
        if($message == NULL)
        {
            $message = $this->errorCodeMessage();
        }
        parent::__construct($message, $statusCode);
    }

    protected function errorCodeMessage() : String
    {
        $codes = [
            '1000' => 'Email adresi düzgün yazın',
            '1001' => 'Bütün xanaları doldurmalısınız',
            '1002' => 'Email və ya şifrə yanlışdır'
        ];
        if(isset($codes[$this->code]))
        {
            return $codes[$this->code];
        }
        return "ERROR";
    }

    protected function reportErrorCodes() : String
    {
        $codes = [
            '5000'
        ];
        if(isset($codes[$this->code]))
        {
            return $codes[$this->code];
        }
        return "";
    }
}

/*
//814802441
if (!class_exists("Telegram_Webhook"))
{
    class Webhook_Exception extends Exception #do not delete (required)
    {
        public function __construct($message, $code = 0, Exception $previous = null, $adminMessage = NULL)
        {
            parent::__construct($message, $code, $previous);
            if ($this->adminErrorCodes($code) !== false) {
                $telegram = new Telegram_Webhook();
                foreach ($telegram->adminList() as $value) {
                    $telegram->sendMessage([
                        'chat_id' => $value,
                        'text' => "Sistemdə problem var. \nFile: " . $this->getFile() . "\nError code: " . $this->getCode() . "\nLine: " . $this->getLine() . "\nMessage: " . $this->adminErrorCodes($code) . " " . $adminMessage
                    ]);
                }
            }
        }

        public function adminErrorCodes($code = NULL)
        {
            $codes = [
                '1004' => 'Redis connection error',
                '1006' => 'Servis hazır deyil',
                '1007' => 'Scope list siyahı hazır deyil',
                '1008' => 'Seçilən scope list sistemdə mövcud deyil',
                '1011' => 'Telegramdan şəkili açmaq mümkün olmadı',
                '1012' => 'Fayl mövcud deyil',
                '1013' => 'Database error: ',
                '1016' => 'Şəkil silinə bilmədi. Path:'
            ];
            if (isset($codes[$code])) {
                return $codes[$code];
            }
            return false;
        }
    }

    class Telegram_Webhook extends Create_Webhook_Log
    {
        const TELEGRAM_TOKEN = '6854768056:AAGPICflEJXf7myfdKs6xZQ37gI00sQTpNQ';
        const API_URL = 'https://api.telegram.org/bot';
        public $chatId = NULL;
        protected $userId = NULL;
        protected $file_path = NULL;
        protected $file_id = NULL;
        protected $callBackQueryId = NULL;
        public $messageId = NULL;
        public $redis = FALSE;
        public $imagePath = NULL;
        public $sendGroup = FALSE;


        public function __construct()
        {
            $this->imagePath = "../../" . $GLOBALS['userFolder'] . "/images/upld/";
            $this->connectRedis();
        }

        public function sendGroup($groupChatId = NULL)
        {
            if ($this->sendGroup === true) {

            }
        }

        public function setImagePath()
        {
            if ($this->imagePath === NULL) {
                $this->imagePath = "../../" . $GLOBALS['userFolder'] . "/images/upld/";
            }
            return $this;
        }

        public function __destruct()
        {
            if ($this->redis !== FALSE) {
                $this->redis->close();
            }

        }

        public function __call($method, $args = [])
        {
            if ($method == 'dbRequestSingleRow' || $method == 'dbRequestArray') {
                $args[1] = "";
                $args[2] = "1";
            }
            return $method(...$args);
        }

        public function adminList()
        {
            return [
                '814802441'
            ];
        }

        private function connectRedis($host = 'localhost', $port = '6379')
        {
            try {
                $this->redis = new Redis();
                $this->redis->connect($host, $port);
            } catch (RedisException $e) {
                $this->redis = FALSE;
            }
        }

        private function request($method, $posts = [], $file = false)
        {
            if ($file) {
                $url = 'https://api.telegram.org/file/bot' . self::TELEGRAM_TOKEN . '/' . $this->file_path;
            } else {
                $url = self::API_URL . self::TELEGRAM_TOKEN . '/' . $method;
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
                if ($count == 100) break;
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
            return json_decode($result, true);
        }

        public function setWebhook($url)
        {
            return $this->request('setWebhook', [
                'url' => $url
            ]);
        }

        public function getWebhookInfo()
        {
            return $this->request('getWebhookInfo');
        }

        public function getData()
        {
            $data = json_decode(file_get_contents("php://input"), true);
            if (isset($data['message']['photo'])) {
                $this->file_id = $data['message']['photo'][0]['file_id'];
            }
            if (isset($data['callback_query']['data'])) {
                $this->chatId = $data['callback_query']['message']['chat']['id'];
                $this->callBackQueryId = $data['callback_query']['id'];
                if (isset($data['message']['from']['id'])) {
                    $this->userId = $data['callback_query']['message']['from']['id'];
                }
            } elseif (!empty($data)) {
                $this->chatId = $data['message']['chat']['id'];
                $this->callBackQueryId = NULL;
                if (isset($data['message']['from']['id'])) {
                    $this->userId = $data['message']['from']['id'];
                }
            }
            $this->messageId = $data['message']['message_id'];
            if ($data['message']['text'] !== '/start' && !isset($data['message']['contact']['phone_number'])) {
                $this->checkLogin();
            }
            return $data;
        }

        public function saveFileDB($fileName, $realFileName = NULL)
        {
            $uid = uniqid();
            if ($realFileName == NULL) {
                $realFileName = $fileName;
            }
            $res = $this->DBrequest("INSERT INTO s_files_link SET
                fid = '" . $uid . "',
                fname = '" . $fileName . "',
                realname = '" . $realFileName . "',
                fld = '" . $GLOBALS['userFolder'] . "'
            ", "returnErrors");
            if ($res === "true") {
                return $uid;
            }
            $code = '1013';
            throw new Webhook_Exception($this->errorCodes($code), $code, NULL, $res);
        }

        public function getFile($saveDB = true)
        {
            $filePath = $this->request('getFile', [
                'file_id' => $this->file_id
            ])['result']['file_path'];
            $imageContent = file_get_contents('https://api.telegram.org/file/bot' . self::TELEGRAM_TOKEN . '/' . $filePath);
            if ($imageContent !== false) {
                $newName = uniqid();
                $pathInfo = pathinfo($filePath);
                $fileExtension = strtolower($pathInfo['extension']);
                if (!file_exists($this->imagePath)) {
                    $code = '1012';
                    throw new Webhook_Exception($this->errorCodes($code), $code, NULL, $this->imagePath);
                }
                $res = file_put_contents($this->imagePath . $newName . "." . pathinfo($filePath)['extension'], $imageContent);
                if ($res === false) {
                    $code = '1012';
                    throw new Webhook_Exception($this->errorCodes($code) . " " . $this->imagePath, $code);
                }
                if ($saveDB === true) {
                    return $this->saveFileDB($newName . "." . pathinfo($filePath)['extension'], basename($filePath));
                }
                return $res;
            } else {
                $code = '1011';
                throw new Webhook_Exception($this->errorCodes($code), $code);
            }
        }

        public function errorCodes($code = NULL)
        {
            $codes = [
                '1000' => 'Banlandığınıza görə sistemə giriş edə bilməzsiniz',
                '1001' => 'Sistemə girişiniz bağlanıb',
                '1002' => 'Qeydiyyatdan keçmədiyiniz üçün botu istifadə edə bilməyəcəksiniz',
                '1003' => 'Bu əməliyyatı etmək üçün giriş etməlisiniz',
                '1004' => 'Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin',
                '1005' => 'Etmək istədiyiniz əməliyyatı zəhmət olmasa menyudan seçin. Yeni müraciət yaratdıqda sizə 15 dəqiqə vaxt verilir və bu vaxt ərzində yarımçıq əməliyyat etmisinizsə sistem tərəfindən sıfırlanır və yenidən yaratmalısınız.',
                '1006' => 'Hazır deyil',
                '1007' => 'Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin',
                '1008' => 'Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin',
                '1009' => 'Ünvan kod sistemdə mövcud deyil. Fərqli kod yazmağa çalışın',
                '1010' => 'Sadəcə şəkil yükləyin və ya menyudan seçim edin',
                '1011' => 'Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin',
                '1012' => 'Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin',
                '1013' => 'Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin',
                '1014' => 'Yalnız nömrə qeyd edin',
                '1015' => 'nömrəli aktiv müraciətiniz mövcud deyil',
                '1016' => 'Task silinə bilmədi. Zəhmət olmasa yenidən cəhd edin'
            ];
            if (isset($codes[$code])) {
                return $codes[$code];
            }
            return NULL;
        }

        public function deleteMessage($messageId)
        {
            return $this->request("deleteMessage", [
                'chat_id' => $this->chatId,
                'message_id' => $messageId
            ]);
        }

        public function deletePhoto($imageUid = NULL): bool
        {
            if ($imageUid == NULL) return true;
            $images = explode("|", $imageUid);
            $i = 0;
            while (true) {
                if (!isset($images[$i])) {
                    break;
                }
                if (!file_exists($this->imagePath)) {
                    $code = '1012';
                    throw new Webhook_Exception($this->errorCodes($code), $code, NULL, $this->imagePath);
                }
                if ($images[$i] != NULL) {
                    $imageLink = $this->dbRequestSingleRow("SELECT fname FROM s_files_link WHERE fid = '" . $images[$i] . "' AND fld = '" . $GLOBALS['userFolder'] . "'");
                    $delete = unlink($this->imagePath . $imageLink['fname']);
                    if (!$delete) {
                        $code = '1016';
                        throw new Webhook_Exception($this->errorCodes($code), $code, NULL, $this->imagePath . $imageLink['fname']);
                    }
                    $result = $this->DBrequest("REALDELETE FROM s_files_link WHERE fid = '" . $images[$i] . "' AND fld = '" . $GLOBALS['userFolder'] . "'", "returnErrors");
                    if ($result !== "true") {
                        $code = '1013';
                        throw new Webhook_Exception($this->errorCodes($code), $code, NULL, $result);
                    }
                }
                $i++;
            }
            return true;
        }

        public function sendMessage($data = [])
        {
            if (!isset($data['chat_id'])) {
                $data['chat_id'] = $this->chatId;
            }
            $data['protect_content'] = true;
            return $this->request('sendMessage', $data);
        }

        public function login($data = [])
        {
            $phone = $data['message']['contact']['phone_number'];
            $check = $this->dbRequestSingleRow("SELECT uid, Status, Chat_Id, Phone FROM u_customers WHERE Phone = '" . $phone . "'");
            if ($check['uid'] != NULL) {
                if ($check['Status'] == 'ACTIVE') {
                    $this->redis->set($this->chatId . "_login", json_encode(['uid' => $check['uid'], 'phone' => $check['Phone']]));
                    if ($check['Chat_Id'] == NULL) {
                        $res = $this->DBrequest("UPDATE u_customers SET Chat_Id = '" . $this->chatId . "' WHERE Phone = '" . $phone . "'", "returnErrors");
                        if ($res !== "true") {
                            $code = '1013';
                            throw new Webhook_Exception($this->errorCodes($code), $code, NULL, $res);
                        }
                    }
                    $this->next('1');
                } elseif ($check['Status'] == 'BAN') {
                    $code = '1000';
                    throw new Webhook_Exception($this->errorCodes($code), $code);
                } else {
                    $code = '1001';
                    throw new Webhook_Exception($this->errorCodes($code), $code);
                }

            } else {
                $code = '1002';
                throw new Webhook_Exception($this->errorCodes($code), $code);
            }
        }

        public function checkLogin()
        {
            if ($this->redis->exists($this->chatId . "_login")) {
                return true;
            }
            $code = '1003';
            throw new Webhook_Exception($this->errorCodes($code), $code);
        }

        public function answerCallBackQuery($data = [])
        {
            if (!isset($data['callback_query_id'])) {
                $data['callback_query_id'] = $this->callBackQueryId;
            }
            if (!isset($data['show_alert'])) {
                $data['show_alert'] = false;
            }
            return $this->request('answerCallBackQuery', $data);
        }

        public function next($which = '1')
        {
            switch ($which) {
                case "1":
                    "(";
                    $keyboard = json_encode([
                        "inline_keyboard" => [
                            [
                                [
                                    "text" => "Yeni sorğu yarat",
                                    "callback_data" => "create_new_request"
                                ],
                                [
                                    'text' => 'Sorğunu yoxla',
                                    'callback_data' => 'check_request_status'
                                ]
                            ]
                        ]
                    ], true);
                    $this->sendMessage([
                        'text' => 'Xoş gəlmisiniz',
                        'reply_markup' => json_encode(['remove_keyboard' => true])
                    ]);
                    return $this->sendMessage([
                        'text' => 'Əməliyyat seçin',
                        'parse_mode' => 'HTML',
                        'reply_markup' => $keyboard
                    ]);
                    ")";
                    break;

                case "2":
                    "(";
                    $this->sendMessage([
                        'text' => 'Ünvan kodu yazın',
                        'reply_markup' => json_encode(['remove_keyboard' => true])
                    ]);
                    return $this->redis->set($this->chatId . "_process", "enter_location_code", ['EX' => 900]);
                    ")";
                    break;

                case "3":
                    "(";
                    $workTypes = $this->getWorkTypes();
                    $keyboard_workTypes = [];

                    foreach ($workTypes as $value) {
                        $keyboard_workTypes[] = [
                            [
                                "text" => $value["Description"],
                                "callback_data" => "selected_work_type_" . $value['uid']
                            ]
                        ];
                    }

                    $keyboard = json_encode([
                        "inline_keyboard" => $keyboard_workTypes
                    ]);
                    return $this->sendMessage([
                        'text' => 'Zəhmət olmasa seçim edin',
                        'parse_mode' => 'HTML',
                        'reply_to_message_id' => $this->messageId,
                        'reply_markup' => $keyboard
                    ]);
                    ")";
                    break;

                case "4":
                    "(";
                    $scopeList = $this->getScopeList();
                    $keyboard_scope = [];

                    foreach ($scopeList as $value) {
                        $keyboard_scope[] = [
                            [
                                "text" => $value["Description"],
                                "callback_data" => "selected_scope_" . $value['uid']
                            ]
                        ];
                    }

                    $keyboard = json_encode([
                        "inline_keyboard" => $keyboard_scope
                    ]);
                    return $this->sendMessage([
                        'text' => 'Zəhmət olmasa seçim edin',
                        'parse_mode' => 'HTML',
                        'reply_markup' => $keyboard
                    ]);
                    ")";
                    break;

                case "5":
                    "(";
                    $this->redis->set($this->chatId . "_process", "describe_problem", ['EX' => 900]);
                    return $this->sendMessage([
                        'text' => 'Probleminizi yazılı izah edin'
                    ]);
                    ")";
                    break;

                case "6":
                    "(";
                    $data = $this->redis->get($this->chatId . "_data");
                    $data = json_decode($data, true);
                    $this->redis->del($this->chatId . "_process");
                    $text = "Ünvan kodu: " . $data['confirm']['location_code'] . " (" . $data['location_description'] . ")\nWork type: " . $data['confirm']['work_type']['Description'] . "\nScope: " . $data['confirm']['scope']['Description'] . "\nQeyd: " . $data['description'];
                    $keyboard = json_encode([
                        "inline_keyboard" => [
                            [
                                [
                                    "text" => "Bəli",
                                    "callback_data" => "confirm_request_yes"
                                ],
                                [
                                    "text" => "Xeyr",
                                    "callback_data" => "confirm_request_no"
                                ]
                            ]
                        ]
                    ], true);
                    $this->sendMessage([
                        'text' => $text
                    ]);
                    return $this->sendMessage([
                        'text' => 'Sorğunun düzgünlüyünü təsdiqləyirsiniz ?',
                        'reply_markup' => $keyboard
                    ]);
                    ")";
                    break;

                case "7":
                    "(";
                    $this->sendMessage([
                        'text' => 'Zəhmət olmasa 15 dəqiqə ərzində şəkil (şəkillər) göndərin'
                    ]);
                    $this->redis->del($this->chatId . "_process");
                    return $this->redis->set($this->chatId . "_photoProcess", "get_task_photo", ['EX' => 900]);
                    ")";
                    break;

                case "8":
                    "(";
                    $this->redis->set($this->chatId . "_process", "enter_task_number", ["EX" => 900]);
                    return $this->sendMessage([
                        'text' => 'Task nömrəsini yazın',
                        'reply_markup' => json_encode(['remove_keyboard' => true])
                    ]);
                    ")";
                    break;

                case "9":
                    "(";

                    ")";
                    break;
                default:
                    return FALSE;
                    break;
            }
        }

        public function callBackQuery($data = [])
        {
            $messageText = $data['callback_query']['data'];
            if (strpos($messageText, 'selected_work_type_') === 0) {
                $switch = "selected_work_type";
            } elseif (strpos($messageText, 'selected_scope_') === 0) {
                $switch = 'selected_scope';
            } else {
                $switch = $messageText;
            }
            switch ($switch) {
                case "create_new_request":
                    $this->next('2');
                    break;

                case "check_request_status":
                    "(";
                    $keyboard = json_encode([
                        "inline_keyboard" => [
                            [
                                [
                                    "text" => "Şəkil göndər",
                                    "callback_data" => "send_picture_for_task"
                                ]
                            ],
                            [
                                [
                                    "text" => "Taskı ləğv et",
                                    "callback_data" => "cancel_task"
                                ]
                            ],
                            [
                                [
                                    "text" => "Taskı izlə",
                                    'callback_data' => "view_task"
                                ]
                            ],
                            [
                                [
                                    "text" => "Task qəbul et",
                                    "callback_data" => "accept_task"
                                ]
                            ]
                        ]
                    ], true);
                    return $this->sendMessage([
                        'text' => 'Zəhmət olmasa seçim edin',
                        'reply_markup' => $keyboard
                    ]);
                    ")";
                    break;

                case "selected_work_type":
                    "(";
                    $workType = str_replace("selected_work_type_", "", $messageText);
                    $data = $this->redis->get($this->chatId . "_data");
                    $data = json_decode($data, true);
                    $data['work_type'] = $workType;
                    $data['confirm']['work_type'] = $this->getWorkTypes($workType);
                    if (!isset($data['location_code'])) {
                        $this->next('2');
                    } elseif (!isset($data['scope'])) {
                        $this->next('4');
                    } else {
                        $this->next('5');
                    }
                    $data = json_encode($data);
                    return $this->redis->set($this->chatId . "_data", $data, ['EX' => 900]);
                    ")";
                    break;

                case "selected_scope":
                    "(";
                    $scope = str_replace("selected_scope_", "", $messageText);
                    $data = $this->redis->get($this->chatId . "_data");
                    $data = json_decode($data, true);
                    $data['scope'] = $scope;
                    $data['confirm']['scope'] = $this->getScopeList($scope);
                    if (!isset($data['location_code'])) {
                        $this->next('2');
                    } elseif (!isset($data['work_type'])) {
                        $this->next('3');
                    } else {
                        $this->next('5');
                    }

                    $data = json_encode($data);
                    return $this->redis->set($this->chatId . "_data", $data, ['EX' => 900]);
                    ")";
                    break;

                case "confirm_request_yes":
                    "(";
                    $data = $this->redis->get($this->chatId . "_data");
                    $data = json_decode($data, true);
                    if (isset($data['location_code']) && isset($data['scope']) && isset($data['work_type']) && isset($data['description'])) {
                        $uid = uniqid();
                        $phone = json_decode($this->redis->get($this->chatId . "_login"), true)['phone'];

                        $this->DBrequest_push("insert", "INSERT INTO u_tasks SET
                            uid = '" . $uid . "',
                            Location_Code = '" . $data['location_code'] . "',
                            Scope  = '" . $data['scope'] . "',
                            Description = '" . $data['description'] . "',
                            Date_Time = '" . date('Y-m-d H:i:s') . "',
                            Author = '" . $phone . "',
                            Work_Type = '" . $data['work_type'] . "'
                        ");
                        $this->DBrequest_push("insert", "INSERT INTO u_tasks_manager SET
                            uid = '" . uniqid() . "',
                            Location_Code = '" . $data['location_code'] . "',
                            Scope  = '" . $data['scope'] . "',
                            Description = '" . $data['description'] . "',
                            Date_Time = '" . date('Y-m-d H:i:s') . "',
                            Author = '" . $phone . "',
                            Work_Type = '" . $data['work_type'] . "',
                            Task_Uid = '" . $uid . "'
                        ");
                        $result = $this->DBrequest_commit("insert", true);
                        if ($result[0] !== 'ok') {
                            $code = '1013';
                            throw new Webhook_Exception($this->errorCodes($code), $code, NULL, $result[2]);
                        }
                        $docNo = $this->dbRequestSingleRow("SELECT id FROM u_tasks WHERE uid = '" . $uid . "'");
                        $this->redis->del($this->chatId . "_data");
                        $this->redis->set($this->chatId . "_data", json_encode(['task_id' => $docNo['id'], 'task_uid' => $uid], true), ['EX' => 900]);
                        $this->sendMessage([
                            'text' => 'Sorğunuz yaradıldı. Sorğu nömrəsi: <code>' . $docNo['id'] . '</code>',
                            'parse_mode' => 'HTML'
                        ]);
                        return $this->next('7');
                    }
                    $code = '1005';
                    throw new Webhook_Exception($this->errorCodes($code), $code);
                    ")";
                    break;

                case "confirm_request_no":
                    "(";
                    $this->redis->del($this->chatId . "_data");
                    $this->redis->del($this->chatId . "_process");
                    $this->redis->del($this->chatId . "_photoProcess");
                    return $this->sendMessage([
                        'text' => 'Əməliyyat ləğv olundu. Müraciət yaratmaq və ya izləmək üçün menyudan seçim edin'
                    ]);
                    ")";
                    break;

                case "view_task":
                    "(";
                    $this->redis->set($this->chatId . "_do", "view_task", ["EX" => 900]);
                    $this->redis->del($this->chatId . "_photoProcess");
                    return $this->next("8");
                    ")";
                    break;

                case "cancel_task":
                    "(";
                    $this->redis->del($this->chatId . "_photoProcess");
                    $this->redis->set($this->chatId . "_do", "cancel_task", ["EX" => 900]);
                    return $this->next("8");
                    ")";
                    break;

                case "accept_task":
                    "(";
                    $this->redis->del($this->chatId . "_photoProcess");
                    $this->redis->set($this->chatId . "_do", "accept_task", ["EX" => 900]);
                    return $this->next("8");
                    ")";
                    break;

                case "send_picture_for_task":
                    "(";
                    $this->redis->del($this->chatId . "_photoProcess");
                    $this->redis->set($this->chatId . "_do", "send_picture", ["EX" => 900]);
                    return $this->next("8");
                    ")";
                    break;

                case "confirm_task_yes":
                    $taskId = $this->redis->get($this->chatId . "_data");
                    $taskId = json_decode($taskId, true)['task_id'];
                    $uid = $this->dbRequestSingleRow("SELECT uid FROM u_tasks WHERE id = '" . $taskId . "'")['uid'];
                    DBrequest_push("change", "UPDATE u_tasks SET
                        Customer_Status = 'DONE'
                        WHERE id = '" . $taskId . "'
                    ");
                    DBrequest_push("change", "UPDATE u_tasks_manager SET
                        Customer_Status = 'DONE'
                        WHERE Task_Uid = '" . $uid . "'
                    ");
                    DBrequest_commit("change", true);
                    $this->redis->del($this->chatId . "_data");
                    return $this->sendMessage([
                        'text' => $taskId . ' nömrəli müraciətiniz təsdiqləndi',
                        'reply_markup' => json_encode(['remove_keyboard' => true])
                    ]);
                    break;

                default:
                    "(";
                    $code = '1006';
                    throw new Webhook_Exception($this->errorCodes($code), $code);
                    ")";
                    break;
            }
        }

        public function process($data = [])
        {
            if ($this->redis->exists($this->chatId . "_photoProcess")) {
                $code = '1010';
                throw new Webhook_Exception($this->errorCodes($code), $code);
            }
            $messageText = $data['message']['text'];
            $fromCache = $this->redis->get($this->chatId . "_process");
            switch ($fromCache) {
                case "enter_location_code":
                    "(";
                    $checkLocation = $this->dbRequestSingleRow("SELECT Code, Description FROM u_locations WHERE Code = '" . strtoupper($messageText) . "' AND Status = 'ACTIVE'");
                    if ($checkLocation['Code'] != NULL) {
                        $data = $this->redis->get($this->chatId . "_data");
                        $data = json_decode($data, true);
                        if (!isset($data['work_type'])) {
                            $this->next('3');
                        } elseif (isset($data['scope'])) {
                            $this->next('5');
                        } else {
                            $this->next('4');
                        }
                        $data['location_code'] = $checkLocation['Code'];
                        $data['location_description'] = $checkLocation['Description'];
                        $data['confirm']['location_code'] = $checkLocation['Code'];
                        $data = json_encode($data, true);
                        return $this->redis->set($this->chatId . "_data", $data, ['EX' => 900]);
                    }
                    $code = '1009';
                    throw new Webhook_Exception($this->errorCodes($code), $code);
                    ")";
                    break;

                case "describe_problem":
                    "(";
                    $data = $this->redis->get($this->chatId . "_data");
                    $data = json_decode($data, true);
                    $data['description'] = $messageText;
                    $data = json_encode($data, true);
                    $this->redis->set($this->chatId . "_data", $data, ['EX' => 900]);
                    return $this->next('6');
                    ")";
                    break;

                case "enter_task_number":
                    "(";
                    if (!is_numeric($messageText)) {
                        $code = '1014';
                        throw new Webhook_Exception($this->errorCodes($code), $code);
                    }
                    switch ($this->redis->get($this->chatId . "_do")) {
                        case "view_task":
                            "(";
                            $search = dbRequestSingleRow("SELECT t.id, t.Location_Code, loc.Description as Location_Description, scope.Description as Scope, t.Description, work_type.Description as Work_Type FROM u_tasks as t LEFT JOIN u_scope_list as scope ON t.Scope = scope.uid LEFT JOIN u_work_types as work_type ON t.Work_Type = work_type.uid LEFT JOIN u_locations as loc ON t.Location_Code = loc.Code WHERE t.id = '" . $messageText . "'", "", "1");
                            if ($search['id'] == NULL) {
                                $code = '1015';
                                throw new Webhook_Exception($messageText . " " . $this->errorCodes($code), $code);
                            }
                            $text = "Task nömrəsi: " . $search['id'] . "\nLocation code: " . $search['Location_Code'] . " (" . $search['Location_Description'] . ")\nScope: " . $search['Scope'] . "\nWork type: " . $search['Work_Type'];
                            $this->redis->del($this->chatId . "_process");
                            $this->redis->del($this->chatId . "_do");
                            return $this->sendMessage([
                                'text' => $text,
                                'reply_markup' => json_encode(['remove_keyboard' => true])
                            ]);
                            ")";
                            break;

                        case "cancel_task":
                            "(";
                            $taskUid = $this->dbRequestSingleRow("SELECT uid, Photo FROM u_tasks WHERE id = '" . $messageText . "' AND Customer_Status in('NEW')");
                            if ($taskUid['uid'] == NULL) {
                                $code = '1015';
                                throw new Webhook_Exception($messageText . " " . $this->errorCodes($code), $code);
                            }
                            $this->deletePhoto($taskUid['Photo']);
                            $this->DBrequest_push("delete", "DELETE FROM u_tasks WHERE id = '" . $messageText . "'");
                            $this->DBrequest_push("delete", "DELETE FROM u_tasks_manager WHERE Task_Uid = '" . $taskUid['uid'] . "'");
                            $this->DBrequest_push("delete", "DELETE FROM u_tasks_supervisor WHERE Task_Uid = '" . $taskUid['uid'] . "'");
                            $result = $this->DBrequest_commit("delete", true);
                            if ($result[0] !== 'ok') {
                                $code = '1013';
                                throw new Webhook_Exception($this->errorCodes($code), $code, NULL, $result[2]);
                            }
                            $this->redis->del($this->chatId . "_process");
                            $this->redis->del($this->chatId . "_do");
                            return $this->sendMessage([
                                'text' => $messageText . " nömrəli taskı ləğv etdiniz.",
                                'reply_markup' => json_encode(['remove_keyboard' => true])
                            ]);
                            ")";
                            break;

                        case "send_picture":
                            "(";
                            $task = $this->dbRequestSingleRow("SELECT id FROM u_tasks WHERE id = '" . $messageText . "' AND Customer_Status IN('NEW')");
                            if ($task['id'] == NULL) {
                                $code = '1015';
                                throw new Webhook_Exception($messageText . " " . $this->errorCodes($code), $code);
                            }
                            $this->redis->set($this->chatId . "_data", json_encode(['task_id' => $task['id']], true), ["EX" => 900]);
                            return $this->next("7");
                            ")";
                            break;

                        case "accept_task":
                            "(";
                            $task = $this->dbRequestSingleRow("SELECT id FROM u_tasks WHERE id = '" . $messageText . "' AND Customer_Status IN('NEW')");
                            if ($task['id'] == NULL) {
                                $code = '1015';
                                throw new Webhook_Exception($messageText . " " . $this->errorCodes($code), $code);
                            }
                            $uid = $this->dbRequestSingleRow("SELECT uid FROM u_tasks WHERE id = '" . $taskId . "'")['uid'];
                            DBrequest_push("change", "UPDATE u_tasks SET
                                Customer_Status = 'DONE'
                                WHERE id = '" . $taskId . "'
                            ");
                            DBrequest_push("change", "UPDATE u_tasks_manager SET
                                Customer_Status = 'DONE'
                                WHERE Task_Uid = '" . $uid . "'
                            ");
                            DBrequest_commit("change", true);
                            $this->redis->del($this->chatId . "_data");
                            return $this->sendMessage([
                                'text' => $taskId . ' nömrəli müraciətiniz təsdiqləndi',
                                'reply_markup' => json_encode(['remove_keyboard' => true])
                            ]);
                            ")";
                            break;
                    }
                    ")";
                    break;

                default:
                    "(";
                    $code = '1005';
                    throw new Webhook_Exception($this->errorCodes($code), $code);
                    ")";
                    break;
            }
        }

        public function photoProcess($data = [])
        {
            $fromCache = $this->redis->get($this->chatId . "_photoProcess");
            switch ($fromCache) {
                case "get_task_photo":
                    $photoUid = $this->getFile();
                    $data = $this->redis->get($this->chatId . "_data");
                    $data = json_decode($data, true);
                    $result = $this->DBrequest("UPDATE u_tasks SET Photo = CONCAT(if(Photo is null, '', Photo), '|', '" . $photoUid . "') WHERE id = '" . $data['task_id'] . "'", "returnErrors");
                    if ($result !== "true") {
                        $code = '1013';
                        throw new Webhook_Exception($this->errorCodes($code), $code, NULL, $result);
                    }
                    return $result;
                    break;
                default:
                    $code = '1005';
                    throw new Webhook_Exception($this->errorCodes($code), $code);
                    break;
            }
        }

        public function getWorkTypes($uid = NULL)
        {
            if ($this->redis->exists('all_work_types')) {
                if ($uid != NULL) {
                    foreach (json_decode($this->redis->get('all_work_types'), true) as $key => $value) {
                        if ($value['uid'] == $uid) {
                            return $value;
                        }
                    }
                    return [];
                }
                return json_decode($this->redis->get('all_work_types'), true);
            }
            $workTypes = $this->dbRequestArray("SELECT uid, Description FROM u_work_types WHERE Active = '1'");
            $this->redis->set('all_work_types', json_encode($workTypes, true));
            if ($uid != NULL) {
                foreach (json_decode($this->redis->get('all_work_types'), true) as $key => $value) {
                    if ($value['uid'] == $uid) {
                        return $value;
                    }
                }
                return [];
            }
            return $workTypes;
        }

        public function getScopeList($uid = NULL)
        {
            if ($this->redis->exists('all_scope_list')) {
                if ($uid != NULL) {
                    foreach (json_decode($this->redis->get('all_scope_list'), true) as $key => $value) {
                        if ($value['uid'] == $uid) {
                            return $value;
                        }
                    }
                    $code = '1007';
                    throw new Webhook_Exception($this->errorCodes($code), $code);
                }
                return json_decode($this->redis->get('all_scope_list'), true);
            }
            $scopeList = $this->dbRequestArray("SELECT uid, Description FROM u_scope_list WHERE Active = '1'");
            $this->redis->set('all_scope_list', json_encode($scopeList, true));
            if ($uid != NULL) {
                foreach (json_decode($this->redis->get('all_scope_list'), true) as $key => $value) {
                    if ($value['uid'] == $uid) {
                        return $value;
                    }
                }
                $code = '1008';
                throw new Webhook_Exception($this->errorCodes($code), $code);
            }

        }

    }
} else {
    $telegram = new Telegram_Webhook();
    try {
        $data = $telegram->getData();
    } catch (Webhook_Exception $e) {
        return $telegram->sendMessage([
            'text' => $e->getMessage(),
            'reply_markup' => json_encode(['remove_keyboard' => true])
        ]);
    }
    if ($telegram->redis !== false) {
        if (isset($data['message']['contact']['phone_number'])) {
            try {
                return $telegram->login($data);
            } catch (Webhook_Exception $e) {
                return $telegram->sendMessage([
                    'text' => $e->getMessage(),
                    'reply_markup' => json_encode(['remove_keyboard' => true])
                ]);
            }
        }
        if (isset($data['callback_query']['data'])) {
            try {
                return $telegram->callBackQuery($data);
            } catch (Webhook_Exception $e) {
                return $telegram->sendMessage([
                    'text' => $e->getMessage(),
                    'reply_markup' => json_encode(['remove_keyboard' => true])
                ]);
            }

        }
        if (isset($data['message']['photo'])) {
            try {
                return $telegram->photoProcess($data);
            } catch (Webhook_Exception $e) {
                return $telegram->sendMessage([
                    'text' => $e->getMessage(),
                    'reply_to_message_id' => $telegram->messageId,
                    'reply_markup' => json_encode(['remove_keyboard' => true])
                ]);
            }
        }
        switch ($data['message']['text']) {
            case "/start":
                "(";
                $telegram->redis->del($telegram->chatId . "_process");
                $telegram->redis->del($telegram->chatId . "_data");
                if ($telegram->redis->exists($telegram->chatId . "_login")) {
                    return $telegram->sendMessage([
                        'text' => 'Müraciət yaratmaq və ya izləmək üçün menyudan seçim edin',
                        'reply_markup' => json_encode(['remove_keyboard' => true])
                    ]);
                }
                $keyboard = array(
                    "keyboard" => array(
                        array(
                            array(
                                "text" => "Nömrəni paylaş",
                                "request_contact" => true
                            ))),
                    'resize_keyboard' => true
                );
                return $telegram->sendMessage([
                    'reply_markup' => json_encode($keyboard),
                    'text' => 'Zəhmət olmasa nömrənizi paylaşın'
                ]);
                ")";
                break;

            case "/new_request":
                "(";
                $telegram->redis->del($telegram->chatId . "_data");
                $telegram->redis->del($telegram->chatId . "_photoProcess");
                $telegram->redis->del($telegram->chatId . "_process");
                $telegram->redis->del($telegram->chatId . "_do");
                return $telegram->next('2');
                ")";
                break;

            case "/cancel":
                "(";
                $telegram->sendMessage([
                    'text' => 'Əməliyyat ləğv olundu. Müraciət yaratmaq və ya izləmək üçün menyudan seçim edin',
                    'reply_markup' => json_encode(['remove_keyboard' => true])
                ]);
                $telegram->redis->del($telegram->chatId . "_process");
                $telegram->redis->del($telegram->chatId . "_photoProcess");
                $telegram->redis->del($telegram->chatId . "_do");
                return $telegram->redis->del($telegram->chatId . "_data");
                ")";
                break;

            case "/active_tasks":
                "(";
                $telegram->redis->del($telegram->chatId . "_process");
                $telegram->redis->del($telegram->chatId . "_photoProcess");
                $telegram->redis->del($telegram->chatId . "_data");
                $keyboard = json_encode([
                    "inline_keyboard" => [
                        [
                            [
                                "text" => "Şəkil göndər",
                                "callback_data" => "send_picture_for_task"
                            ]
                        ],
                        [
                            [
                                "text" => "Taskı ləğv et",
                                "callback_data" => "cancel_task"
                            ]
                        ],
                        [
                            [
                                "text" => "Taskı izlə",
                                'callback_data' => "view_task"
                            ]
                        ],
                        [
                            [
                                "text" => "Task qəbul et",
                                "callback_data" => "accept_task"
                            ]
                        ]
                    ]
                ], true);
                return $telegram->sendMessage([
                    'text' => 'Zəhmət olmasa seçim edin',
                    'reply_markup' => $keyboard
                ]);
                ")";
                break;

            case "/exit":
                "(";
                $telegram->redis->del($telegram->chatId . "_login");
                $telegram->redis->del($telegram->chatId . "_process");
                $telegram->redis->del($telegram->chatId . "_photoProcess");
                $telegram->redis->del($telegram->chatId . "_do");
                return $telegram->sendMessage([
                    'text' => 'Çıxış verdiniz',
                    'reply_markup' => json_encode(['remove_keyboard' => true])
                ]);
                ")";
                break;

            default:
                "(";
                try {
                    return $telegram->process($data);
                } catch (Webhook_Exception $e) {
                    return $telegram->sendMessage([
                        'text' => $e->getMessage(),
                        'reply_to_message_id' => $telegram->messageId,
                        'reply_markup' => json_encode(['remove_keyboard' => true]),
                        'disable_notification' => true
                    ]);
                }
                ")";
                break;
        }
    } else {
        $code = '1004';
        throw new Webhook_Exception($telegram->errorCodes($code), $code);
    }
}
*/






