<?php

namespace App\Exceptions\Backend\Authentication;

use Exception;

class Authentication extends Exception
{
    public function __construct($statusCode = NULL, $message = NULL)
    {
        if($message == NULL)
        {
            $message = $this->errorCodes($statusCode);
        }
        parent::__construct($message, $statusCode);
    }

    public function errorCodes($code = 500) : String
    {
        $codes = [
            '1000' => 'Email adresi düzgün yazın',
            '1001' => 'Bütün xanaları doldurmalısınız'
        ];
        if(isset($codes[$code]))
        {
            return $codes[$code];
        }
        return "";
    }
}
