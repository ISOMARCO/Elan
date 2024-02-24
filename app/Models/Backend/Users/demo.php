<?php
//814802441

if(!class_exists("Telegram_Webhook"))
{
    class TelegramBot
    {
        const API_URL = 'https://api.telegram.org/bot';
        private $token = NULL;
        public $chatId;
        public $messageId = NULL;
        protected $file_id = NULL;
        public function __construct($token)
        {
            $this->token = $token;
        }
        private function request($method, $posts = [])
        {
            $url = self::API_URL.$this->token.'/'.$method;

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
            $result = json_decode($result, true);
            if(!$result['ok'])
            {
                throw new Webhook_Exception('1017', ['admin' => ['{webhook}' => $result['description']]]);
            }
            return $result;
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

        public function getData($link = NULL)
        {
            if($link === NULL)
            {
                $link = "php://input";
            }
            $data = json_decode( file_get_contents($link), true );
            if(isset($data['message']['photo']))
            {
                $this->file_id = $data['message']['photo'][$this->imageQuality[$this->selectedQuality]]['file_id'];
            }
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
            $this->messageId = $data['message']['message_id'];
            if($data['message']['text'] !== '/start' && !isset($data['message']['contact']['phone_number']))
            {
                $this->checkLogin();
            }
            return $data;
        }

        public function deleteMessage($messageId)
        {
            return $this->request("deleteMessage", [
                'chat_id' => $this->chatId,
                'message_id' => $messageId
            ]);
        }

        public function sendMessage($data = [])
        {
            if(!isset($data['chat_id']))
            {
                $data['chat_id'] = $this->chatId;
            }
            $data['protect_content'] = true;
            return $this->request('sendMessage', $data);
        }

    }
    class Webhook_Exception extends Exception #do not delete (required)
    {
        public function __construct(int $code, array $messageArr = [])
        {
            $message = $this->userErrorCodes($code, $messageArr);
            parent::__construct($message, $code);
            if($this->adminErrorCodes($code, $messageArr) !== false)
            {
                $telegram = new Telegram_Webhook();
                foreach($telegram->adminList() as $value)
                {
                    $telegram->sendMessage([
                        'chat_id' =>  $value,
                        'text' => "Sistemdə problem var. \nFile: ".$this->getFile()."\nError code: ".$this->getCode()."\nLine: ".$this->getLine()."\nMessage: ".$this->adminErrorCodes($code, $messageArr)
                    ]);

                }
            }
        }

        private function adminErrorCodes($code = NULL, array $message = [])
        {
            $codes = [
                '1004' => 'Redis connection error.',
                '1006' => 'Servis hazır deyil',
                '1007' => 'Scope list siyahı hazır deyil',
                '1008' => 'Seçilən scope list sistemdə mövcud deyil',
                '1011' => 'Telegramdan şəkili açmaq mümkün olmadı',
                '1012' => 'Fayl mövcud deyil: {path}',
                '1013' => 'Database error: {database}',
                '1016' => 'Şəkil silinə bilmədi. Path: {path}',
                '1017' => 'Webhook error: {webhook}'
            ];
            if(isset($codes[$code]))
            {
                $messageString = $codes[$code];
                if(!empty($message) && isset($message['admin']))
                {
                    $messageString = str_replace(array_keys($message['admin']), array_values($message['admin']), $messageString);
                }
                return $messageString;
            }
            return FALSE;

        }

        private function userErrorCodes($code = NULL, array $message = []) : string|null
        {

            $codes = [
                '1000' => 'Banlandığınıza görə sistemə giriş edə bilməzsiniz',
                '1001' => 'Sistemə girişiniz bağlanıb',
                '1002' => 'Qeydiyyatdan keçmədiyiniz üçün botu istifadə edə bilməyəcəksiniz',
                '1003' => 'Bu əməliyyatı etmək üçün giriş etməlisiniz',
                '1004' => 'Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin',
                '1005' => 'Etmək istədiyiniz əməliyyatı zəhmət olmasa menyudan seçin. Yeni tapşırıq yaratdıqda sizə 15 dəqiqə vaxt verilir və bu vaxt ərzində yarımçıq əməliyyat etmisinizsə sistem tərəfindən sıfırlanır və yenidən yaratmalısınız.',
                '1006' => 'Hazır deyil',
                '1007' => 'Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin',
                '1008' => 'Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin',
                '1009' => 'Ünvan kod sistemdə mövcud deyil. Fərqli kod yazmağa çalışın',
                '1010' => 'Sadəcə şəkil yükləyin və ya menyudan seçim edin',
                '1011' => 'Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin',
                '1012' => 'Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin',
                '1013' => 'Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin',
                '1014' => 'Yalnız nömrə qeyd edin',
                '1015' => '{task_id} nömrəli aktiv tapşırıq mövcud deyil',
                '1016' => 'Tapşırıq silinə bilmədi. Zəhmət olmasa yenidən cəhd edin',
                '1018' => 'Bu tapşırıqda bu əməliyyatı edə bilməzsiniz',
                '1019' => 'Siz bu iş növünü seçə bilməsziniz',
                '1020' => 'Siz bu seçimi edə bilməzsiniz',
                '1021' => 'Siz bu ünvan kodunu seçə bilməzsiniz',
                '1022' => 'Aktiv tapşırığınız mövcud deyil',
                '2000' => 'Zəhmət olmasa etmək istədiyiniz əməliyyatı menyudan seçin',
                '2001' => 'Bu tapşırıqda artıq işə başlamısınız',
                '2002' => 'Siz bu tapşırığı bitirə bilməzsiniz'
            ];
            if(isset($codes[$code]))
            {
                $messageString = $codes[$code];
                if(!empty($message) && isset($message['user']))
                {
                    $messageString = str_replace(array_keys($message['user']), array_values($message['user']), $messageString);
                }
                return $messageString;
            }
            return NULL;
        }
    }

    class Telegram_Webhook extends TelegramBot
    {
        const TELEGRAM_TOKEN = '6854768056:AAGPICflEJXf7myfdKs6xZQ37gI00sQTpNQ';
        const IN_USE = FALSE;
        protected $file_path = NULL;
        public $chatId;
        protected $file_id = NULL;
        protected  $callBackQueryId = NULL;
        public $redis = FALSE;
        public $imagePath = NULL;
        protected $imageQuality = [
            'very_low' => 0,
            'low' => 1,
            'medium' => 2,
            'high' => 3,
            'very_high' => 4
        ];
        protected string $selectedQuality = 'medium';

        public function __construct($token = NULL)
        {
            if($token == NULL)
            {
                parent::__construct(self::TELEGRAM_TOKEN);
            }
            else
            {
                parent::__construct($token);
            }
            $this->imagePath = "../../".$GLOBALS['userFolder']."/images/upld/";
            $this->connectRedis();
        }

        public function setImagePath($path = NULL)
        {
            if($path == NULL)
            {
                $path = "../../".$GLOBALS['userFolder']."/images/upld/";
            }
            $this->imagePath = $path;
            return $this;
        }

        public function __destruct()
        {
            if($this->redis !== FALSE)
            {
                $this->redis->close();
            }

        }
        public function __call($method, $args = [])
        {
            if($method == 'dbRequestSingleRow' || $method == 'dbRequestArray')
            {
                $args[1] = "";
                $args[2] = "1";
            }
            return $method(...$args);
        }

        public function adminList()
        {
            return
                [
                    '814802441'
                ];
        }

        public function connectRedis($host = 'localhost', $port = '6379')
        {
            try
            {
                $this->redis = new Redis();
                $this->redis->connect($host, $port);
            }
            catch(RedisException $e)
            {
                $this->redis = FALSE;
            }
        }

        public function saveFileDB($fileName, $realFileName = NULL)
        {
            $uid = uniqid();
            if($realFileName == NULL)
            {
                $realFileName = $fileName;
            }
            $res = $this->DBrequest("INSERT INTO s_files_link SET
                fid = '".$uid."',
                fname = '".$fileName."',
                realname = '".$realFileName."',
                fld = '".$GLOBALS['userFolder']."'
            ", "returnErrors");
            if($res === "true")
            {
                return $uid;
            }
            throw new Webhook_Exception('1013', ['admin' => ['{database}' => $res]]);
        }

        public function getFile($saveDB = true)
        {
            $filePath = $this->request('getFile', [
                'file_id' => $this->file_id
            ])['result']['file_path'];
            $imageContent = file_get_contents('https://api.telegram.org/file/bot'.self::TELEGRAM_TOKEN.'/'.$filePath);
            if($imageContent !== false)
            {
                $newName = uniqid();
                $pathInfo = pathinfo($filePath);
                $fileExtension = strtolower($pathInfo['extension']);
                if(!file_exists($this->imagePath))
                {
                    throw new Webhook_Exception(1012, ['admin' => ['{path}' => $this->imagePath]]);
                }
                $res = file_put_contents($this->imagePath.$newName.".".pathinfo($filePath)['extension'], $imageContent);
                if($res === false)
                {
                    throw new Webhook_Exception(1012, ['admin' => ['{path}' => $this->imagePath]]);
                }
                if($saveDB === true)
                {
                    return $this->saveFileDB($newName.".".pathinfo($filePath)['extension'], basename($filePath));
                }
                return $res;
            }
            else
            {
                throw new Webhook_Exception(1011);
            }
        }

        public function deletePhoto($imageUid = NULL) : Bool
        {
            if($imageUid == NULL) return true;
            $images = explode("|", $imageUid);
            $i = 0;
            while(true)
            {
                if(!isset($images[$i]))
                {
                    break;
                }
                if(!file_exists($this->imagePath))
                {
                    throw new Webhook_Exception(1012, ['admin' => ['{path}' => $this->imagePath]]);
                }
                if($images[$i] != NULL)
                {
                    $imageLink = $this->dbRequestSingleRow("SELECT fname FROM s_files_link WHERE fid = '".$images[$i]."' AND fld = '".$GLOBALS['userFolder']."'");
                    $delete = unlink($this->imagePath.$imageLink['fname']);
                    if(!$delete)
                    {
                        throw new Webhook_Exception(1016, ['admin' => ['{path}' => $this->imagePath.$imageLink['fname']]]);
                    }
                    $result = $this->DBrequest("REALDELETE FROM s_files_link WHERE fid = '".$images[$i]."' AND fld = '".$GLOBALS['userFolder']."'", "returnErrors");
                    if($result !== "true")
                    {
                        throw new Webhook_Exception(1013, ['admin' => ['{database}' => $result]]);
                    }
                }
                $i++;
            }
            return true;
        }

        public function login($data = [])
        {
            $phone = $data['message']['contact']['phone_number'];
            $check = $this->dbRequestSingleRow("SELECT uid, Status, Chat_Id, Phone, Work_Types, Scope, Locations FROM u_customers WHERE Phone = '".$phone."' AND Role = 'CUSTOMER'");
            if($check['uid'] != NULL)
            {
                if($check['Status'] == 'ACTIVE')
                {
                    $this->redis->set($this->chatId."_login", json_encode(['uid' => $check['uid'], 'phone' => $check['Phone'], 'work_types' => $check['Work_Types'], 'scope' => $check['Scope'], 'locations' => $check['Locations']]));
                    if($check['Chat_Id'] == NULL)
                    {
                        $res = $this->DBrequest("UPDATE u_customers SET Chat_Id = '".$this->chatId."' WHERE Phone = '".$phone."'", "returnErrors");
                        if($res !== "true")
                        {
                            throw new Webhook_Exception(1013, ['admin' => ['{database}' => $res]]);
                        }
                    }
                    $this->next('1');
                }
                elseif($check['Status'] == 'BAN')
                {
                    throw new Webhook_Exception(1000);
                }
                else
                {
                    throw new Webhook_Exception(1001);
                }

            }
            else
            {
                throw new Webhook_Exception(1002);
            }
        }

        public function checkLogin()
        {
            if($this->redis->exists($this->chatId."_login"))
            {
                return true;
            }
            throw new Webhook_Exception('1003');
        }

        public function answerCallBackQuery($data = [])
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

        public function next($which = '1')
        {
            switch($which)
            {
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
                    return $this->redis->set($this->chatId."_process", "enter_location_code", ['EX' => 900]);
                    ")";
                    break;

                case "3":
                    "(";
                    $workTypes = $this->getWorkTypes();
                    $userWorkTypes = json_decode($this->redis->get($this->chatId."_login"), true)['work_types'];
                    $keyboard_workTypes = [];

                    foreach($workTypes as $value)
                    {
                        if(strpos($userWorkTypes, $value['uid']) !== false)
                        {
                            $keyboard_workTypes[] = [
                                [
                                    "text" => $value["Description"],
                                    "callback_data" => "selected_work_type_" . $value['uid']
                                ]
                            ];
                        }
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
                    $userScopeList = json_decode($this->redis->get($this->chatId."_login"), true)['scope'];
                    $keyboard_scope = [];
                    foreach($scopeList as $value)
                    {
                        if(strpos($userScopeList, $value['uid']) !== false)
                        {
                            $keyboard_scope[] = [
                                [
                                    "text" => $value["Description"],
                                    "callback_data" => "selected_scope_" . $value['uid']
                                ]
                            ];
                        }
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
                    $this->redis->set($this->chatId."_process", "describe_problem", ['EX' => 900]);
                    return $this->sendMessage([
                        'text' => 'Probleminizi yazılı izah edin'
                    ]);
                    ")";
                    break;

                case "6":
                    "(";
                    $data = $this->redis->get($this->chatId."_data");
                    $data = json_decode($data, true);
                    $this->redis->del($this->chatId."_process");
                    $text = "Ünvan kodu: ".$data['confirm']['location_code']." (".$data['location_description'].")\nWork type: ".$data['confirm']['work_type']['Description']."\nScope: ".$data['confirm']['scope']['Description']."\nQeyd: ".$data['description'];
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
                    $this->redis->del($this->chatId."_process");
                    return $this->redis->set($this->chatId."_photoProcess", "get_task_photo", ['EX' => 900]);
                    ")";
                    break;

                case "8":
                    "(";
                    $this->redis->set($this->chatId."_process", "enter_task_number", ["EX" => 900]);
                    return $this->sendMessage([
                        'text' => 'Tapşırıq nömrəsini yazın',
                        'reply_markup' => json_encode(['remove_keyboard' => true])
                    ]);
                    ")";
                    break;

                default:
                    return FALSE;
                    break;
            }
        }

        public function clearCache($login = false, $chatId = NULL)
        {
            if($chatId != NULL)
            {
                $this->chatId = $chatId;
            }
            $this->redis->del($this->chatId."_data");
            $this->redis->del($this->chatId."_process");
            $this->redis->del($this->chatId."_photoProcess");
            $this->redis->del($this->chatId."_do");
            if($login === true)
            {
                $this->redis->del($this->chatId."_login");
            }
            return $this;
        }

        public function callBackQuery($data = [])
        {
            $messageText = $data['callback_query']['data'];
            if(strpos($messageText, 'selected_work_type_') === 0)
            {
                $switch = "selected_work_type";
            }
            elseif(strpos($messageText, 'selected_scope_') === 0)
            {
                $switch = 'selected_scope';
            }
            else
            {
                $switch = $messageText;
            }
            switch($switch)
            {
                case "create_new_request":
                    $this->next('2');
                    break;

                case "check_request_status":
                    "(";
                    $keyboard = json_encode([
                        "inline_keyboard" => [
                            [
                                [
                                    'text' => 'Bütün aktiv tapşırıqlar',
                                    'callback_data' => 'show_all_active_tasks'
                                ]
                            ],
                            [
                                [
                                    "text" => "Şəkil göndər",
                                    "callback_data" => "send_picture_for_task"
                                ]
                            ],
                            [
                                [
                                    "text" => "Tapşırığı ləğv et",
                                    "callback_data" => "cancel_task"
                                ]
                            ],
                            [
                                [
                                    "text" => "Tapşırığı izlə",
                                    'callback_data' => "view_task"
                                ]
                            ],
                            [
                                [
                                    "text" => "Tapşırıq qəbul / ləğv et",
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
                    $userWorkTypes = json_decode($this->redis->get($this->chatId."_login"), true)['work_types'];
                    if(strpos($userWorkTypes, $workType) === false)
                    {
                        throw new Webhook_Exception('1019');
                    }
                    $data = $this->redis->get($this->chatId."_data");
                    $data = json_decode($data, true);
                    $data['work_type'] = $workType;
                    $data['confirm']['work_type'] = $this->getWorkTypes($workType);
                    if(!isset($data['location_code']))
                    {
                        $this->next('2');
                    }
                    elseif(!isset($data['scope']))
                    {
                        $this->next('4');
                    }
                    else
                    {
                        $this->next('5');
                    }
                    $data = json_encode($data);
                    return $this->redis->set($this->chatId."_data", $data, ['EX' => 900]);
                    ")";
                    break;

                case "selected_scope":
                    "(";
                    $scope = str_replace("selected_scope_", "", $messageText);
                    $userScope = json_decode($this->redis->get($this->chatId."_login"), true)['scope'];
                    if(strpos($userScope, $scope) === false)
                    {
                        throw new Webhook_Exception('1020');
                    }
                    $data = $this->redis->get($this->chatId."_data");
                    $data = json_decode($data, true);
                    $data['scope'] = $scope;
                    $data['confirm']['scope'] = $this->getScopeList($scope);
                    if(!isset($data['location_code']))
                    {
                        $this->next('2');
                    }
                    elseif(!isset($data['work_type']))
                    {
                        $this->next('3');
                    }
                    else
                    {
                        $this->next('5');
                    }

                    $data = json_encode($data);
                    return $this->redis->set($this->chatId."_data", $data, ['EX' => 900]);
                    ")";
                    break;

                case "confirm_request_yes":
                    "(";
                    $data = $this->redis->get($this->chatId."_data");
                    $data = json_decode($data, true);
                    if(isset($data['location_code']) && isset($data['scope']) && isset($data['work_type']) && isset($data['description']))
                    {
                        $uid = uniqid();
                        $phone = json_decode($this->redis->get($this->chatId."_login"), true)['phone'];

                        $this->DBrequest_push("insert", "INSERT INTO u_tasks SET
                            uid = '".$uid."',
                            Location_Code = '".$data['location_code']."',
                            Scope  = '".$data['scope']."',
                            Description = '".$data['description']."',
                            Date_Time = '".date('Y-m-d H:i:s')."',
                            Author = '".$phone."',
                            Work_Type = '".$data['work_type']."'
                        ");
                        $this->DBrequest_push("insert", "INSERT INTO u_tasks_manager SET
                            uid = '".uniqid()."',
                            Location_Code = '".$data['location_code']."',
                            Scope  = '".$data['scope']."',
                            Description = '".$data['description']."',
                            Date_Time = '".date('Y-m-d H:i:s')."',
                            Author = '".$phone."',
                            Work_Type = '".$data['work_type']."',
                            Task_Uid = '".$uid."'
                        ");
                        $result = $this->DBrequest_commit("insert");
                        if($result[0] !== 'ok')
                        {
                            throw new Webhook_Exception('1013', ['admin' => ['{database}' => $result[2]]]);
                        }
                        $docNo = $this->dbRequestSingleRow("SELECT id FROM u_tasks WHERE uid = '".$uid."'");
                        $this->redis->del($this->chatId."_data");
                        $this->redis->set($this->chatId."_data", json_encode(['task_id' => $docNo['id'], 'task_uid' => $uid], true), ['EX' => 900]);
                        $this->sendMessage([
                            'text' => 'Sorğunuz yaradıldı. Sorğu nömrəsi: <code>'.$docNo['id'].'</code>',
                            'parse_mode' => 'HTML'
                        ]);
                        return $this->next('7');
                    }
                    throw new Webhook_Exception('1005');
                    ")";
                    break;

                case "confirm_request_no":
                    "(";
                    $this->redis->del($this->chatId."_data");
                    $this->redis->del($this->chatId."_process");
                    $this->redis->del($this->chatId."_photoProcess");
                    return $this->sendMessage([
                        'text' => 'Əməliyyat ləğv olundu. Tapşırıq yaratmaq və ya izləmək üçün menyudan seçim edin'
                    ]);
                    ")";
                    break;

                case "view_task":
                    "(";
                    $this->redis->set($this->chatId."_do", "view_task", ["EX" => 900]);
                    $this->redis->del($this->chatId."_photoProcess");
                    return $this->next("8");
                    ")";
                    break;

                case "cancel_task":
                    "(";
                    $this->redis->del($this->chatId."_photoProcess");
                    $this->redis->set($this->chatId."_do", "cancel_task", ["EX" => 900]);
                    return $this->next("8");
                    ")";
                    break;

                case "accept_task":
                    "(";
                    $this->redis->del($this->chatId."_photoProcess");
                    $this->redis->set($this->chatId."_do", "accept_task", ["EX" => 900]);
                    return $this->next("8");
                    ")";
                    break;

                case "show_all_active_tasks":
                    "(";
                    $phone = json_decode($this->redis->get($this->chatId."_login"), true)['phone'];
                    $allActiveTasks = $this->dbRequestArray("SELECT t.id, t.Date_Time, t.Description, scope.Description as Scope_Description, w.Description as Work_Type_Description FROM u_tasks as t LEFT JOIN u_scope_list as scope ON t.Scope = scope.uid LEFT JOIN u_work_types as w ON t.Work_Type = w.uid WHERE t.Author = '".$phone."' AND t.Customer_Status NOT IN('DONE', 'REJECT', 'REMOVED')");
                    $sendString = "";
                    $i = 0;
                    while(true)
                    {
                        if(!isset($allActiveTasks[$i])) break;
                        $sendString .=
                            "&#x1F517; Tapşırıq nömrəsi: <code>".sprintf("%05d", $allActiveTasks[$i]['id'])."</code>\n&#x1F5D3; ".Date_To_String($allActiveTasks[$i]['Date_Time'], "\n&#x1F550; ")."\n&#x1F4DD; ".$allActiveTasks[$i]['Description']."\n&#x1F527; ".$allActiveTasks[$i]['Scope_Description']."\n&#x231B; ".$allActiveTasks[$i]['Work_Type_Description']."\n".str_repeat('-', 20)."\n";
                        $i++;
                    }
                    if($i == 0)
                    {
                        throw new Webhook_Exception(1022);
                    }
                    return $this->sendMessage([
                        'text' => $sendString,
                        'parse_mode' => 'HTML'
                    ]);
                    ")";
                    break;

                case "send_picture_for_task":
                    "(";
                    $this->redis->del($this->chatId."_photoProcess");
                    $this->redis->set($this->chatId."_do", "send_picture", ["EX" => 900]);
                    return $this->next("8");
                    ")";
                    break;

                case "confirm_task_yes":
                    "(";
                    $taskId = $this->redis->get($this->chatId."_data");
                    $taskId = json_decode($taskId, true)['task_id'];
                    if($taskId == NULL)
                    {
                        throw new Webhook_Exception('1005');
                    }
                    $uid = $this->dbRequestSingleRow("SELECT uid FROM u_tasks WHERE id = '".$taskId."'")['uid'];
                    DBrequest_push("change", "UPDATE u_tasks SET
                        Customer_Status = 'DONE'
                        WHERE id = '".$taskId."'
                    ");
                    DBrequest_push("change", "UPDATE u_tasks_manager SET
                        Customer_Status = 'DONE'
                        WHERE Task_Uid = '".$uid."'
                    ");
                    DBrequest_commit("change");
                    return $this->clearCache()->sendMessage([
                        'text' => $taskId.' nömrəli tapşırıq təsdiqləndi',
                        'reply_markup' => json_encode(['remove_keyboard' => true])
                    ]);
                    ")";
                    break;

                case "confirm_task_no_get_description":
                    "(";
                    $taskId = $this->redis->get($this->chatId."_data");
                    $taskId = json_decode($taskId, true)['task_id'];
                    if($taskId == NULL)
                    {
                        throw new Webhook_Exception('1005');
                    }
                    $keyboard = json_encode([
                        "inline_keyboard" => [
                            [
                                [
                                    "text" => "Səhv seçdim, geri qayıt",
                                    "callback_data" => "confirm_task_no_back"
                                ]
                            ]
                        ]
                    ], true);
                    $this->redis->set($this->chatId."_process", "type_no_confirm_description", ["EX" => 900]);
                    return $this->sendMessage([
                        'text' => 'Razı qalmama səbəbini zəhmət olmasa yazın. 15 dəqiqə ərzində heç bir səbəb göstərmədiyiniz təqdirdə tapşırıqda heç bir əməliyyat aparılmayacaq.',
                        'reply_markup' => $keyboard
                    ]);
                    ")";
                    break;

                case "confirm_task_no_back":
                    "(";
                    $this->clearCache()->sendMessage([
                        'text' => 'Tapşırıq ilə bağlı heç bir əməliyyat aparılmadı.'
                    ]);
                    ")";
                    break;

                default:
                    "(";
                    throw new Webhook_Exception('1006');
                    ")";
                    break;
            }
        }

        public function process($data = [])
        {
            if($this->redis->exists($this->chatId."_photoProcess"))
            {
                throw new Webhook_Exception(1010);
            }
            $messageText = $data['message']['text'];
            $fromCache = $this->redis->get($this->chatId."_process");
            switch($fromCache)
            {
                case "enter_location_code":
                    "(";
                    $checkLocation = $this->dbRequestSingleRow("SELECT location.Code, location.Description FROM u_locations as location INNER JOIN u_companies as company ON location.Company = company.uid WHERE location.Code = '".$messageText."' AND location.Status = 'ACTIVE' AND company.Status = 'ACTIVE'");
                    if($checkLocation['Code'] != NULL)
                    {
                        $userLocations = json_decode($this->redis->get($this->chatId."_login"), true)['locations'];
                        if(strpos($userLocations, $checkLocation['Code']) === false)
                        {
                            throw new Webhook_Exception(1021);
                        }
                        $data = $this->redis->get($this->chatId."_data");
                        $data = json_decode($data, true);
                        if(!isset($data['work_type']))
                        {
                            $this->next('3');
                        }
                        elseif(isset($data['scope']))
                        {
                            $this->next('5');
                        }
                        else
                        {
                            $this->next('4');
                        }
                        $data['location_code'] = $checkLocation['Code'];
                        $data['location_description'] = $checkLocation['Description'];
                        $data['confirm']['location_code'] = $checkLocation['Code'];
                        $data = json_encode($data, true);
                        return $this->redis->set($this->chatId."_data", $data, ['EX' => 900]);
                    }
                    throw new Webhook_Exception(1009);
                    ")";
                    break;

                case "describe_problem":
                    "(";
                    $data = $this->redis->get($this->chatId."_data");
                    $data = json_decode($data, true);
                    $data['description'] = $messageText;
                    $data = json_encode($data, true);
                    $this->redis->set($this->chatId."_data", $data, ['EX' => 900]);
                    return $this->next('6');
                    ")";
                    break;

                case "enter_task_number":
                    "(";
                    if(!is_numeric($messageText))
                    {
                        throw new Webhook_Exception(1014);
                    }
                    switch($this->redis->get($this->chatId."_do"))
                    {
                        case "view_task":
                            "(";
                            $phone = json_decode($this->redis->get($this->chatId."_login"), true)['phone'];
                            $search = dbRequestSingleRow("SELECT t.id, t.Author, t.Location_Code, loc.Description as Location_Description, scope.Description as Scope, t.Description, work_type.Description as Work_Type FROM u_tasks as t LEFT JOIN u_scope_list as scope ON t.Scope = scope.uid LEFT JOIN u_work_types as work_type ON t.Work_Type = work_type.uid LEFT JOIN u_locations as loc ON t.Location_Code = loc.Code WHERE t.id = '".$messageText."'", "", "1");
                            if($search['id'] == NULL || $search['Author'] !== $phone)
                            {
                                throw new Webhook_Exception('1015', ['user' => ['{task_id}' => $messageText]]);
                            }
                            $text = "Tapşırıq nömrəsi: ".$search['id']."\nLocation code: ".$search['Location_Code']." (".$search['Location_Description'].")\nScope: ".$search['Scope']."\nWork type: ".$search['Work_Type'];
                            $this->redis->del($this->chatId."_process");
                            $this->redis->del($this->chatId."_do");
                            return $this->sendMessage([
                                'text' => $text,
                                'reply_markup' => json_encode(['remove_keyboard' => true])
                            ]);
                            ")";
                            break;

                        case "cancel_task":
                            "(";
                            $phone = json_decode($this->redis->get($this->chatId."_login"), true)['phone'];
                            $taskUid = $this->dbRequestSingleRow("SELECT uid, Photo, Customer_Status, Supervisor_Status, Manager_Status, Author FROM u_tasks WHERE id = '".$messageText."'");
                            if($taskUid['Customer_Status'] !== "NEW" && $taskUid['Supervisor_Status'] !== 'NEW' && $taskUid['Manager_Status'] !== 'NEW' && $taskUid['Author'] !== $phone)
                            {
                                throw new Webhook_Exception('1015', ['user' => ['{task_id}' => $messageText]]);
                            }
                            /*$this->deletePhoto($taskUid['Photo']);
                            $this->DBrequest_push("delete", "DELETE FROM u_tasks WHERE id = '".$messageText."'");
                            $this->DBrequest_push("delete", "DELETE FROM u_tasks_manager WHERE Task_Uid = '".$taskUid['uid']."'");
                            $this->DBrequest_push("delete", "DELETE FROM u_tasks_supervisor WHERE Task_Uid = '".$taskUid['uid']."'");
                            $result = $this->DBrequest_commit("delete");*/
                            $this->DBrequest_push("update", "UPDATE u_tasks SET
                                Customer_Status = 'REMOVED'
                                WHERE id = '".$messageText."'
                            ");
                            $this->DBrequest_push("update", "UPDATE u_tasks_manager SET
                                Archive = '1',
                                Customer_Status = 'REMOVED'
                                WHERE Task_Uid = '".$taskUid['uid']."'
                            ");
                            $result = $this->DBrequest_commit("update");
                            if($result[0] !== 'ok')
                            {
                                throw new Webhook_Exception('1013', ['admin' => ['{database}' => $result[2]]]);
                            }
                            $this->redis->del($this->chatId."_process");
                            $this->redis->del($this->chatId."_do");
                            return $this->sendMessage([
                                'text' => $messageText." nömrəli tapşırığı ləğv etdiniz.",
                                'reply_markup' => json_encode(['remove_keyboard' => true])
                            ]);
                            ")";
                            break;

                        case "send_picture":
                            "(";
                            $phone = json_decode($this->redis->get($this->chatId."_login"), true)['phone'];
                            $task = $this->dbRequestSingleRow("SELECT id, Author, Customer_Status FROM u_tasks WHERE id = '".$messageText."'");
                            if($task['Customer_Status'] !== 'NEW' || $task['Author'] !== $phone)
                            {
                                throw new Webhook_Exception('1015', ['user' => ['{task_id}' => $messageText]]);
                            }
                            $this->redis->set($this->chatId."_data", json_encode(['task_id' => $task['id']], true), ["EX" => 900]);
                            return $this->next("7");
                            ")";
                            break;

                        case "accept_task":
                            "(";
                            $phone = json_decode($this->redis->get($this->chatId."_login"), true)['phone'];
                            $this->redis->set($this->chatId."_data", json_encode(['task_id' => addslashes($messageText)]), ['EX' => 900]);
                            $task = dbRequestSingleRow("SELECT Manager_Status, Supervisor_Status, Customer_Status, Author FROM u_tasks WHERE id = '".addslashes($messageText)."'", "", "1");
                            #if($task['Author'] !== $phone || !($task['Manager_Status'] == 'DONE' && $task['Supervisor_Status'] == 'DONE' && ($task['Customer_Status'] == 'WAITING' || $task['RETURN'])))
                            #{
                            #throw new Webhook_Exception('1018');
                            # }
                            $keyboard = json_encode([
                                "inline_keyboard" => [
                                    [
                                        [
                                            "text" => "Bəli razı qaldım",
                                            "callback_data" => "confirm_task_yes"
                                        ]
                                    ],
                                    [
                                        [
                                            "text" => "Xeyr razı qalmadım",
                                            "callback_data" => "confirm_task_no_get_description"
                                        ]
                                    ]
                                ]
                            ], true);
                            $this->redis->del($this->chatId."_process");
                            return $this->sendMessage([
                                'text' => "Müracəti təsdiq edirsinizsə bəli, əgər yenidən baxılmasını istəyirsinizsə xeyr düyməsini seçin",
                                'reply_markup' => $keyboard
                            ]);
                            ")";
                            break;
                    }
                    ")";
                    break;

                case "type_no_confirm_description":
                    "(";
                    $messageText = addslashes($messageText);
                    $taskId = $this->redis->get($this->chatId."_data");
                    $taskId = json_decode($taskId, true)['task_id'];
                    $task = dbRequestSingleRow("SELECT * FROM u_tasks WHERE id =  '".$taskId."'", "", "1");
                    $taskReference = $task['uid'];
                    if($task['Task_Reference'] != NULL)
                    {
                        $taskReference = $task['Task_Reference'];
                    }
                    $newTaskUid = uniqid();
                    DBrequest_push("change", "UPDATE u_tasks SET
                        Customer_Status = 'REJECT'
                        WHERE id = '".$taskId."'
                    ");
                    DBrequest_push("change", "INSERT INTO  u_tasks SET
                        uid = '".$newTaskUid."',
                        Task_Reference = '".$taskReference."',
                        Location_Code = '".$task['Location_Code']."',
                        Scope = '".$task['Scope']."',
                        Description = '".$messageText."',
                        Author = '".$task['Author']."',
                        Customer_Status = 'RETURN',
                        Date_Time = '".date('Y-m-d H:i:s')."',
                        Work_Type = '".$task['Work_Type']."',
                        Priority = '".$task['Priority']."'
                    ");
                    DBrequest_push("change", "UPDATE u_tasks_manager SET
                        Customer_Status = 'REJECT',
                        Archive = '1',
                        Task_Reference = '".$taskReference."'
                        WHERE Task_Uid = '".$task['uid']."'
                    ");
                    DBrequest_push("change", "INSERT INTO  u_tasks_manager SET
                        uid = '".uniqid()."',
                        Task_Reference = '".$taskReference."',
                        Location_Code = '".$task['Location_Code']."',
                        Customer_Status = 'RETURN',
                        Scope = '".$task['Scope']."',
                        Description = '".$messageText."',
                        Author = '".$task['Author']."',
                        Date_Time = '".date('Y-m-d H:i:s')."',
                        Work_Type = '".$task['Work_Type']."',
                        Task_Uid = '".$newTaskUid."',
                        Priority = '".$task['Priority']."'
                    ");
                    $result = DBrequest_commit("change");
                    if($result[0] === 'error')
                    {
                        throw new Webhook_Exception('1013', ['admin' => ['{database}' => $result[2]]]);
                    }
                    $newTaskId = dbRequestSingleRow("SELECT id FROM u_tasks WHERE uid = '".$newTaskUid."'", "", "1")['id'];
                    $this->redis->set($this->chatId."_photoProcess", "get_task_photo", ['EX' => 900]);
                    $this->redis->set($this->chatId."_data", json_encode(['task_id' => $newTaskId], true), ['EX' => 900]);
                    $this->redis->del($this->chatId."_process");
                    return $this->sendMessage([
                        'text' => '<code>'.$newTaskId.'</code> nömrəli yeni tapşırıq yarandı. Razı qalmadığınız məqamla bağlı şəkil göndərmək istəyirsinizsə 15 dəqiqə ərzində göndərə bilərsiniz. 15 dəqiqə keçdikdən sonra göndərmək istəsəniz menyudan aktiv tapşırıqlar seçin, şəkil göndər seçin, tapşırıq nömrəsinə '.$newTaskId.' yazıb göndərə bilərsiniz',
                        'parse_mode' => 'HTML'
                    ]);
                    ")";
                    break;
                default:
                    "(";
                    throw new Webhook_Exception('1005');
                    ")";
                    break;
            }
        }

        public function photoProcess($data = [])
        {
            $fromCache = $this->redis->get($this->chatId."_photoProcess");
            switch($fromCache)
            {
                case "get_task_photo":
                    $photoUid = $this->getFile();
                    $data = $this->redis->get($this->chatId."_data");
                    $data = json_decode($data, true);
                    $result = $this->DBrequest("UPDATE u_tasks SET Photo = CONCAT(if(Photo is null, '', Photo), '|', '".$photoUid."') WHERE id = '".$data['task_id']."'", "returnErrors");
                    if($result !== "true")
                    {
                        throw new Webhook_Exception(1013, ['admin' => ['{database}' => $result]]);
                    }
                    return $result;
                    break;
                default:
                    throw new Webhook_Exception(1005);
                    break;
            }
        }

        public function getWorkTypes($uid = NULL)
        {
            if($this->redis->exists('all_work_types'))
            {
                if($uid != NULL)
                {
                    foreach(json_decode($this->redis->get('all_work_types'), true) as $key => $value)
                    {
                        if($value['uid'] == $uid)
                        {
                            return $value;
                        }
                    }
                    return [];
                }
                return json_decode($this->redis->get('all_work_types'), true);
            }
            $workTypes = $this->dbRequestArray("SELECT uid, Description FROM u_work_types WHERE Status = 'ACTIVE'");
            $this->redis->set('all_work_types', json_encode($workTypes, true));
            if($uid != NULL)
            {
                foreach($workTypes as $key => $value)
                {
                    if($value['uid'] == $uid)
                    {
                        return $value;
                    }
                }
                return [];
            }
            return $workTypes;
        }

        public function getScopeList($uid = NULL)
        {
            if($this->redis->exists('all_scope_list'))
            {
                if($uid != NULL)
                {
                    foreach(json_decode($this->redis->get('all_scope_list'), true) as $key => $value)
                    {
                        if($value['uid'] == $uid)
                        {
                            return $value;
                        }
                    }
                    throw new Webhook_Exception(1007);
                }
                return json_decode($this->redis->get('all_scope_list'), true);
            }
            $scopeList = $this->dbRequestArray("SELECT uid, Description FROM u_scope_list WHERE Status = 'ACTIVE'");
            $this->redis->set('all_scope_list', json_encode($scopeList, true));
            if($uid != NULL)
            {
                foreach($scopeList as $key => $value)
                {
                    if($value['uid'] == $uid)
                    {
                        return $value;
                    }
                }
                throw new Webhook_Exception(1008);
            }

        }

    }
}
else
{
    $telegram = new Telegram_Webhook();
    try
    {
        $data = $telegram->getData();
    }
    catch(Webhook_Exception $e)
    {
        return $telegram->sendMessage([
            'text' => $e->getMessage(),
            'reply_markup' => json_encode(['remove_keyboard' => true])
        ]);
    }
    if($telegram->redis !== false)
    {
        if(isset($data['message']['contact']['phone_number']))
        {
            try
            {
                return $telegram->login($data);
            }
            catch(Webhook_Exception $e)
            {
                return $telegram->sendMessage([
                    'text' => $e->getMessage(),
                    'reply_markup' => json_encode(['remove_keyboard' => true])
                ]);
            }
        }
        if(isset($data['callback_query']['data']))
        {
            try
            {
                return $telegram->callBackQuery($data);
            }
            catch(Webhook_Exception $e)
            {
                return $telegram->sendMessage([
                    'text' => $e->getMessage(),
                    'reply_markup' => json_encode(['remove_keyboard' => true])
                ]);
            }

        }
        if(isset($data['message']['photo']))
        {
            try
            {
                return $telegram->photoProcess($data);
            }
            catch(Webhook_Exception $e)
            {
                return $telegram->sendMessage([
                    'text' => $e->getMessage(),
                    'reply_to_message_id' => $telegram->messageId,
                    'reply_markup' => json_encode(['remove_keyboard' => true])
                ]);
            }
        }
        switch($data['message']['text'])
        {
            case "/start":
                "(";
                $telegram->redis->del($telegram->chatId."_process");
                $telegram->redis->del($telegram->chatId."_data");
                if($telegram->redis->exists($telegram->chatId."_login"))
                {
                    return $telegram->sendMessage([
                        'text' => 'Tapşırıq yaratmaq və ya izləmək üçün menyudan seçim edin',
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
                $telegram->redis->del($telegram->chatId."_data");
                $telegram->redis->del($telegram->chatId."_photoProcess");
                $telegram->redis->del($telegram->chatId."_process");
                $telegram->redis->del($telegram->chatId."_do");
                return $telegram->next('2');
                ")";
                break;

            case "/cancel":
                "(";
                return $telegram->clearCache()->sendMessage([
                    'text' => 'Əməliyyat ləğv olundu. Tapşırıq yaratmaq və ya izləmək üçün menyudan seçim edin',
                    'reply_markup' => json_encode(['remove_keyboard' => true])
                ]);
                ")";
                break;

            case "/active_tasks":
                "(";
                $telegram->redis->del($telegram->chatId."_process");
                $telegram->redis->del($telegram->chatId."_photoProcess");
                $telegram->redis->del($telegram->chatId."_data");
                $keyboard = json_encode([
                    "inline_keyboard" => [
                        [
                            [
                                'text' => 'Bütün aktiv tapşırıqlar',
                                'callback_data' => 'show_all_active_tasks'
                            ]
                        ],
                        [
                            [
                                "text" => "Aktiv tapşırığa şəkil göndər",
                                "callback_data" => "send_picture_for_task"
                            ]
                        ],
                        [
                            [
                                "text" => "Tapşırığı ləğv et",
                                "callback_data" => "cancel_task"
                            ]
                        ],
                        [
                            [
                                "text" => "Tapşırığı izlə",
                                'callback_data' => "view_task"
                            ]
                        ],
                        [
                            [
                                "text" => "Tapşırıq qəbul / ləğv et",
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
                return $telegram->clearCache(true)->sendMessage([
                    'text' => 'Çıxış verdiniz',
                    'reply_markup' => json_encode(['remove_keyboard' => true])
                ]);
                ")";
                break;

            case "/info":
                return $telegram->sendMessage([
                    'text' => $telegram->redis->get($telegram->chatId."_login")
                ]);
                break;

            default:
                "(";
                try
                {
                    return $telegram->process($data);
                }
                catch(Webhook_Exception $e)
                {
                    return $telegram->sendMessage([
                        'text' => $e->getMessage(),
                        'parse_mode' => 'HTML',
                        'reply_to_message_id' => $telegram->messageId,
                        'reply_markup' => json_encode(['remove_keyboard' => true]),
                        'disable_notification' => true
                    ]);
                }
                ")";
                break;
        }
    }
    else
    {
        throw new Webhook_Exception('1004');
    }
}
