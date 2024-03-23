<?php

namespace App\Exceptions\Backend\Ads;

use Exception;

class AdsException extends Exception
{
    protected $code = 500;
    public function __construct(int $statusCode = 500, Array $message = [])
    {
        $this->code = $statusCode;
        if(is_array($message)  || empty($message))
        {
            $message = $this->errorCodeMessage($message);
        }
        parent::__construct($message, $statusCode);
    }

    protected function errorCodeMessage(Array $msg = []) : String|NULL
    {
        $codes = [
            '3000' => 'Ulduzlu xanalar boş buraxıla bilməz'
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

        ];
        if(isset($codes[$this->code]))
        {
            return $codes[$this->code];
        }
        return NULL;
    }
}
