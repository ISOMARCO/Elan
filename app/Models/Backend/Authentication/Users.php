<?php

namespace App\Models\Backend\Authentication;

use App\Exceptions\Backend\Authentication\Authentication;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    public function login($email = NULL, $password = NULL)
    {
        if(empty($email) || empty($password))
        {
            throw new Authentication(1001);
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            throw new Authentication(1000);
        }
        $password = hash('sha256', md5($password));
        return true;
    }
}
