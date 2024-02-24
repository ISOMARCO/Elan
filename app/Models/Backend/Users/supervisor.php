<?php
if(!class_exists("Supervisor_Telegram_Webhook"))
{
    class Supervisor_Telegram_Webhook extends Telegram_Webhook
    {
        const TELEGRAM_TOKEN = '7150879294:AAFaXVwdTJhzFUdwnyMqSS3HETjYDP1C7EA';
        const IN_USE = FALSE;
        public $chatId = NULL;
        protected $userId = NULL;
        protected $file_path = NULL;
        protected $file_id = NULL;
        protected  $callBackQueryId = NULL;
        public $messageId = NULL;
        public $redis = FALSE;
        public $imagePath = NULL;
        protected $imageQuality = [
            'very_low' => 0,
            'low' => 1,
            'medium' => 2,
            'high' => 3,
            'very_high' => 4
        ];
        protected $selectedQuality = 'medium';

        public function __construct()
        {
            parent::__construct(self::TELEGRAM_TOKEN);
            $this->imagePath = "../../".$GLOBALS['userFolder']."/images/upld/";
            $this->connectRedis();
        }

        public function login($data = [])
        {
            $phone = $data['message']['contact']['phone_number'];
            $check = $this->dbRequestSingleRow("SELECT uid, Status, Chat_Id, Phone, Work_Types, Scope, Locations FROM u_customers WHERE Phone = '".$phone."' AND Role = 'SUPERVISOR'");
            if($check['uid'] != NULL)
            {
                if($check['Status'] == 'ACTIVE')
                {
                    $this->redis->set($this->chatId."_login", json_encode([ 'uid' => $check['uid'], 'phone' => $check['Phone'] ]));
                    if($check['Chat_Id'] == NULL)
                    {
                        $res = $this->DBrequest("UPDATE u_customers SET Chat_Id = '".$this->chatId."' WHERE Phone = '".$phone."'", "returnErrors");
                        if($res !== "true")
                        {
                            throw new Webhook_Exception(1013, ['admin' => ['{database}' => $res]]);
                        }
                    }
                    return $this->sendMessage([
                        'text' => 'Giriş etdiniz. Menyudan seçim edə bilərsiniz',
                        'reply_markup' => json_encode(['remove_keyboard' => true])
                    ]);
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
                case "enter_task_number":
                    "(";
                    if(!is_numeric($messageText))
                    {
                        throw new Webhook_Exception(1014);
                    }
                    $user = json_decode($this->redis->get($this->chatId."_login"), true);
                    switch($this->redis->get($this->chatId."_do"))
                    {
                        case "start_task":
                            "(";
                            $task = dbRequestSingleRow("SELECT id, uid FROM u_tasks WHERE id = '".$messageText."'", "", "1");
                            $taskManager = dbRequestSingleRow("SELECT Supervisor_Status, Supervisor FROM u_tasks_manager WHERE Task_Uid = '".$task['uid']."'", "", "1");
                            if($taskManager['Supervisor'] != $user['uid'] || $task['id'] == NULL)
                            {
                                throw new Webhook_Exception(1015, ['user' => ['{task_id}' => $messageText]]);
                            }
                            if($taskManager['Supervisor_Status'] != 'NEW')
                            {
                                throw new Webhook_Exception(2001);
                            }
                            $startDate = date('Y-m-d H:i:s');
                            DBrequest_push("change", "UPDATE u_tasks SET
                                Supervisor_Status = 'IN_PROGRESS'
                                WHERE id = '".addslashes($messageText)."'
                            ");
                            DBrequest_push("change", "UPDATE u_tasks_manager SET
                                Supervisor_Status = 'IN_PROGRESS'
                                WHERE Task_Uid = '".$task['uid']."'
                            ");
                            DBrequest_push("change", "UPDATE u_tasks_supervisor SET
                                Active = '0'
                                WHERE Supervisor = '".$user['uid']."' AND Active = '1' AND Task_Uid = '".$task['uid']."'
                            ");
                            DBrequest_push("change", "INSERT INTO u_tasks_supervisor SET
                                uid = '".uniqid()."',
                                Supervisor_Status = 'IN_PROGRESS',
                                Date_Time = '".$startDate."',
                                Supervisor = '".$user['uid']."',
                                Task_Uid = '".$task['uid']."',
                                Active = '1'
                            ");
                            $result = DBrequest_commit("change", true);
                            if($result[0] !== 'ok')
                            {
                                throw new Webhook_Exception(1013, ['admin' => ['{database}' => $result[2]]]);
                            }
                            $this->redis->del($this->chatId."_process");
                            $this->redis->del($this->chatId."_do");
                            return $this->sendMessage([
                                'text' => "Siz ".$messageText." nömrəli tapşırıqda işə başladınız. İşə başlama vaxtı ".$startDate
                            ]);
                            ")";
                            break;

                        case "end_task":
                            "(";
                            $task = dbRequestSingleRow("SELECT id, uid FROM u_tasks WHERE id = '".$messageText."'", "", "1");
                            $taskManager = dbRequestSingleRow("SELECT Supervisor_Status, Supervisor, Scope, Author, Work_Type, Photo, Location_Code FROM u_tasks_manager WHERE Task_Uid = '".$task['uid']."'", "", "1");
                            if($taskManager['Supervisor'] != $user['uid'] || $task['id'] == NULL)
                            {
                                throw new Webhook_Exception(1015, ['user' => ['{task_id}' => $messageText]]);
                            }
                            if($taskManager['Supervisor_Status'] != 'IN_PROGRESS')
                            {
                                throw new Webhook_Exception(2002);
                            }
                            $endDate = date('Y-m-d H:i:s');
                            DBrequest_push("change", "UPDATE u_tasks_manager SET
                                Supervisor_Status = 'DONE',
                                Manager_Status = 'WAITING'
                                WHERE Task_Uid = '".$task['uid']."'
                            ");
                            DBrequest_push("change", "INSERT INTO u_tasks_supervisor SET
                                uid = '".uniqid()."',
                                Location_Code = '".$taskManager['Location_Code']."',
                                Supervisor_Status = 'DONE',
                                Scope = '".$taskManager['Scope']."',
                                Supervisor = '".$user['uid']."',
                                Description = '',
                                Author = '".$taskManager['Author']."',
                                Date_Time = '".$endDate."',
                                Work_Type = '".$taskManager['Work_Type']."',
                                Photo = '".$taskManager['Photo']."',
                                Task_Uid = '".$task['uid']."'
                            ");
                            $result = DBrequest_commit("change", true);
                            if($result[0] !== 'ok')
                            {
                                throw new Webhook_Exception(1013, ['admin' => ['{database}' => $result[2]]]);
                            }
                            $this->redis->del($this->chatId."_process");
                            $this->redis->del($this->chatId."_do");
                            return $this->sendMessage([
                                'text' => "Siz ".$messageText." nömrəli tapşırıqda işi bitirdiniz. Bitirmə vaxtı ".$endDate
                            ]);
                            ")";
                            break;
                        default:
                            throw new Webhook_Exception(1006);
                            break;
                    }
                    ")";
                    break;
                default:
                    throw new Webhook_Exception(2000);
                    break;
            }
        }

        public function next($which = '1')
        {
            switch($which)
            {
                case "1":
                    "(";
                    $this->redis->set($this->chatId."_process", "enter_task_number", ["EX" => 900]);
                    return $this->sendMessage([
                        'text' => 'Tapşırıq nömrəsini yazın',
                        'reply_markup' => json_encode(['remove_keyboard' => true])
                    ]);
                    ")";
                    break;
            }
        }

        public function callBackQuery($data = [])
        {
            $messageText = $data['callback_query']['data'];
            switch($messageText)
            {
                case "show_all_active_tasks":
                    "(";
                    $userUid = json_decode($this->redis->get($this->chatId."_login"), true)['uid'];
                    $tasks = dbRequestArray("SELECT t.id, t.Description, location.Description as Location_Description, t.Location_Code, company.Description as Company_Description, scope.Description as Scope_Description, workType.Description as Work_Type_Description FROM u_tasks_supervisor as supervisor INNER JOIN u_tasks as t ON supervisor.Task_Uid = t.uid LEFT JOIN u_locations as location ON t.Location_Code = location.Code LEFT JOIN u_companies as company ON location.Company = company.uid LEFT JOIN u_scope_list as scope ON t.Scope = scope.uid LEFT JOIN u_work_types as workType ON t.Work_Type = workType.uid WHERE supervisor.Active = '1' AND supervisor.Supervisor = '".$userUid."' ORDER BY workType.Priority ASC", "", "1");
                    $i = 0;
                    $sendString = NULL;
                    while(true)
                    {
                        if(!isset($tasks[$i]))
                        {
                            break;
                        }
                        $sendString .=
                            "&#x1F517; Tapşırıq nömrəsi: <code>".sprintf("%05d", $tasks[$i]['id'])."</code>\n&#x1F4CD; ".$tasks[$i]['Location_Code']." - ".$tasks[$i]['Company_Description']." ".$tasks[$i]['Location_Description']."\n&#x1F4DD; ".$tasks[$i]['Description']."\n&#x2699; ".$tasks[$i]['Scope_Description']."\n&#x231B; ".$tasks[$i]['Work_Type_Description']."\n".str_repeat('-', 20)."\n";
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

                case "start_task":
                    "(";
                    $this->redis->set($this->chatId."_do", "start_task", ['EX' => 900]);
                    return $this->next('1');
                    ")";
                    break;

                case "end_task":
                    "(";
                    $this->redis->set($this->chatId."_do", "end_task", ['EX' => 900]);
                    return $this->next('1');
                    ")";
                    break;
            }
        }
    }
}
else
{
    $telegram = new Supervisor_Telegram_Webhook();
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
                return $telegram->login($data, 'SUPERVISOR');
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
        switch($data['message']['text'])
        {
            case "/start":
                "(";
                $telegram->redis->del($telegram->chatId."_process");
                $telegram->redis->del($telegram->chatId."_data");
                if($telegram->redis->exists($telegram->chatId."_login"))
                {
                    return $telegram->sendMessage([
                        'text' => 'GiriÅŸ etmisiniz',
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
                    'text' => 'Zəhmətt olmasa nömrənizi paylaşın'
                ]);
                ")";
                break;

            case "/active_tasks":
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
                                "text" => "Tapışrığa başla",
                                "callback_data" => "start_task"
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
                                "text" => "Tapşırığı bitir",
                                "callback_data" => "end_task"
                            ]
                        ]
                    ]
                ], true);
                return $telegram->sendMessage([
                    'text' => 'SeÃ§im edin',
                    'reply_markup' => $keyboard
                ]);
                ")";
                break;

            case "/start_task":
                "(";
                $telegram->redis->set($telegram->chatId."_process", "enter_task_number", ['EX' => 900]);
                $telegram->redis->set($telegram->chatId."_do", "start_task", ['EX' => 900]);
                return $telegram->sendMessage([
                    'text' => 'Tapşırıq nömrəsini yazın'
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
        throw new Webhook_Exception(1004);
    }
}
