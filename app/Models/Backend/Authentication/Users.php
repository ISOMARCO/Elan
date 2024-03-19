<?php

namespace App\Models\Backend\Authentication;

use App\Exceptions\Backend\Authentication\AuthenticationException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Users extends Model implements JWTSubject
{
    use HasFactory;
    protected $table = 'Users';

    public function login(string|NULL $email = NULL, string|NULL $password = NULL) :  object
    {
        if(empty($email) || empty($password))
        {
            throw new AuthenticationException(1001);
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            throw new AuthenticationException(1000);
        }
        $password = hash('sha256', md5($password));
        $user = DB::table($this->table)->select(['Id', 'Name', 'Surname', 'Default_Language', 'Role', 'Phone_Number', 'Last_Login_Date', 'Registration_Date', 'Status', 'Email'])->where('Password', '=', $password)->where('Email', '=', $email)->where('Role', 'ADMIN');
        if($user->count() == 0)
        {
            throw new AuthenticationException(1002);
        }
        $row = $user->first();
        if($row->Status === 'BAN')
        {
            throw new AuthenticationException(1003);
        }
        if($row->Status === 'DEACTIVE')
        {
            throw new AuthenticationException(1004);
        }
        Session::put('id', $row->Id);
        Session::put('admin', 1);
        return $row;
    }

    public function logout() : bool
    {
        Cookie::queue(Cookie::forget('Remember_Me'));
        Session::flush();
        return true;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
