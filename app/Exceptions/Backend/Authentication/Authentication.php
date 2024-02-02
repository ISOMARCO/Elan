<?php

namespace App\Exceptions\Backend\Authentication;

use Exception;

class Authentication extends Exception
{
    //protected $code = 500;
    public function __construct($statusCode = NULL, $message = NULL)
    {
        //$this->code = $statusCode;
        if($message == NULL)
        {
            $message = $this->errorCodeMessage($statusCode);
        }
        parent::__construct($message, $statusCode);
    }

    protected function errorCodeMessage($code) : String
    {
        $codes = [
            '1000' => 'Email adresi düzgün yazın',
            '1001' => 'Bütün xanaları doldurmalısınız',
            '1002' => 'Email və ya şifrə yanlışdır'
        ];
        if(isset($codes[$code]))
        {
            return $codes[$code];
        }
        return "ERROR";
    }

    public function reportErrorCodes() : String
    {
        $codes = [

        ];
        if(isset($codes[$this->code]))
        {
            return $codes[$this->code];
        }
        return "";
    }
}
