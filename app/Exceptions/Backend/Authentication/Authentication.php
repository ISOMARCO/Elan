<?php

namespace App\Exceptions\Backend\Authentication;

use Exception;

class Authentication extends Exception
{
    public $code = 500;
    public function __construct($statusCode = NULL, $message = NULL)
    {
        $this->code = $statusCode;
        if($message == NULL)
        {
            $message = $this->errorCodes();
        }
        parent::__construct($message, $statusCode);
    }

    protected function errorCodes() : String
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
        return "tapmadim";
    }

    public function reportErrorCodes() : String
    {
        $codes = [

        ];
        if(isset($codes[$this->code]))
        {
            return $codes[$code];
        }
        return "";
    }
}
