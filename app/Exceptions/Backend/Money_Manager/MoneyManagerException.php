<?php

namespace App\Exceptions\Backend\Money_Manager;

use Exception;

class MoneyManagerException extends Exception
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
            '4000'
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
