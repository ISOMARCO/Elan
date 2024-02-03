<?php

namespace App\Models\Backend\Authentication;

use App\Exceptions\Backend\Authentication\Authentication;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    use HasFactory;
    protected $table = 'Users';
    public function login($email = NULL, $password = NULL)
    {
        return true;
        if(empty($email) || empty($password))
        {
            throw new Authentication(1001);
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            throw new Authentication(1000);
        }
        #$password = hash('sha256', md5($password));
        //$user = DB::table($this->table)->where('Password', '=', $password)->where('Email', '=', $email);
//        if($user->count() == 0)
//        {
//            throw new Authentication(1002);
//        }
        return true;
    }
}
