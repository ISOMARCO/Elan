<?php

namespace App\Exceptions\Backend\Users;

use Exception;

class Users extends Exception
{
    protected $code = 500;
    public function __construct($statusCode = NULL, $message = NULL)
    {
        $this->code = $statusCode;
        if(is_array($message)  || $message == NULL)
        {
            $message = $this->errorCodeMessage($message);
        }
        parent::__construct($message, $statusCode);
    }

    protected function errorCodeMessage($msg = NULL) : String
    {
        $codes = [
            '2000' => 'Email adresi düzgün yazın',
            '2001' => 'Ulduzlu xanaları doldurmalısınız',
            '2002' => $msg['email'].' sistemdə mövcuddur',
            '2003' => 'İstifadəçini dəyişdirə bilmədik. Zəhmət olmasa yenidən cəhd edin'
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
            '2003'
        ];
        if(isset($codes[$this->code]))
        {
            return $codes[$this->code];
        }
        return "";
    }
}
