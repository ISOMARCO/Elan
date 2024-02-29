<?php

namespace App\Exceptions\Backend\Users;

use Exception;

class UsersException extends Exception
{
    protected $code = 500;
    public function __construct(int $statusCode = NULL, string|Array|NULL $message = NULL)
    {
        $this->code = $statusCode;
        if(is_array($message)  || empty($message))
        {
            $message = $this->errorCodeMessage($message);
        }
        parent::__construct($message, $statusCode);
    }

    protected function errorCodeMessage($msg = []) : String|NULL
    {
        $codes = [
            '2000' => 'Email adresi düzgün yazın',
            '2001' => 'Ulduzlu xanaları doldurmalısınız',
            '2002' => 'Email sistemdə mövcuddur',
            '2003' => 'İstifadəçini dəyişdirə bilmədik. Zəhmət olmasa yenidən cəhd edin',
            '2004' => 'İstifadəçi statusunu dəyişdirə bilmədik. Zəhmət olmasa yenidən cəhd edin ',
            '2005' => 'Yanlış əməliyyat',
            '2006' => 'Şifrə ilə şifrə təkrarı eyni olmalıdır',
            '2007' => 'İstifadəçini əlavə edə bilmədik. Zəhmət olmasa yenidən cəhd edin'
        ];
        if(isset($codes[$this->code]))
        {
            return $codes[$this->code];
        }
        return NULL;
    }

    protected function reportErrorCodes() : String|NULL
    {
        $codes = [
            '2003',
            '2004',
            '2005',
            '2007'
        ];
        if(isset($codes[$this->code]))
        {
            return $codes[$this->code];
        }
        return NULL;
    }
}
