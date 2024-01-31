<?php

namespace App\Models\Backend\Authentication;

use App\Exceptions\Backend\Authentication\Authentication;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    public function login($email, $password)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            throw new Authentication('error', 1000);
        }
        return true;
    }
}
