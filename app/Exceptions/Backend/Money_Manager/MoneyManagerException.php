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
            $message = $this->errorCodeMessage($message);
        }
        parent::__construct($message, $statusCode);
    }

    protected function errorCodeMessage($message = NULL) : String
    {
        $codes = [
            '4000' => 'Ulduzlu xanalar boş buraxıla bilməz',
            '4001' => 'Qiymət 0-dan böyük olmalıdır',
            '4002' => 'Vergi 0-dan kiçik ola bilməz',
            '4003' => 'Məhsul əlavə olunmadı. Zəhmət olmasa yenidən cəhd edin',
            '4004' => 'Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin'
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
            '4003'
        ];
        if(isset($codes[$this->code]))
        {
            return $codes[$this->code];
        }
        return "";
    }
}
