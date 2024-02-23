<?php

namespace App\Exceptions\Backend\Authentication;

use Exception;

class AuthenticationException extends Exception
{
    protected $code = 500;
    public function __construct(int $statusCode = NULL, string $message = NULL)
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
            '1002' => 'Email və ya şifrə yanlışdır',
            '1003' => 'Hesabınız banlanıb',
            '1004' => 'Hesabınız deaktiv edilib'
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






