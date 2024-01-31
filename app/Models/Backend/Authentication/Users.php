<?php

namespace App\Models\Backend\Authentication;

use App\Exceptions\Backend\Authentication\Authentication;

class Users
{
    use HasFactory;
    public function login($email, $password)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            throw new Authentication('Email yanlış yazdınız', 1000 );
        }
        return true;
    }
}
