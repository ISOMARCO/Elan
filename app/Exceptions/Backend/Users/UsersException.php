<?php

namespace App\Exceptions\Backend\Users;

use Exception;

class UsersException extends Exception
{
    protected $code = 500;
    public function __construct($statusCode = NULL, $message = NULL)
    {
        $this->code = $statusCode;
        if(is_array($message)  || empty($message))
        {
            $message = $this->errorCodeMessage($message);
        }
        parent::__construct($message, $statusCode);
    }

    protected function errorCodeMessage($msg = []) : String
    {
        $codes = [
            '2000' => 'Email adresi düzgün yazın',
            '2001' => 'Ulduzlu xanaları doldurmalısınız',
            '2002' => 'Email sistemdə mövcuddur',
            '2003' => 'İstifadəçini dəyişdirə bilmədik. Zəhmət olmasa yenidən cəhd edin',
            '2004' => 'İstifadəçi statusunu dəyişdirə bilmədik. Zəhmət olmasa yenidən cəhd edin '
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
            '2003',
            '2004'
        ];
        if(isset($codes[$this->code]))
        {
            return $codes[$this->code];
        }
        return "";
    }
}
