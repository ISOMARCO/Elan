<?php

namespace App\Models\Backend\Authentication;

use App\Exceptions\Backend\Authentication\AuthenticationException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Users extends Model
{
    use HasFactory;
    protected $table = 'Users';
    public function login(string $email = NULL, string $password = NULL)
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
        $user = DB::table($this->table)->where('Password', '=', $password)->where('Email', '=', $email)->where('Role', 'ADMIN');
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
        Cache::store('redis')->put('userInfo_'.$row->Id, json_encode($row, true), (60*60*24*365));
        return true;
    }

    public function logout() : bool
    {
        Cache::store('redis')->forget('userInfo_'.Session::get('id'));
        Session::flush();
        return true;
    }
}
