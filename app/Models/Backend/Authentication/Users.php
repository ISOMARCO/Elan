<?php

namespace App\Models\Backend\Authentication;

class Users
{
    use HasFactory;
    public function login($email, $password) : Array
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return [false, 'undefined_email_or_phone'];
        }
        return [];
    }
}
