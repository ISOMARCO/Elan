<?php

namespace App\Models\Backend\Authentication;

use App\Exceptions\Backend\Authentication\Authentication;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Users extends Model
{
    use HasFactory;
    protected $table = 'Users';
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
        $user = DB::table($this->table)->where('Password', '=', $password)->where('Email', '=', $email)->where('Role', 'ADMIN');
        if($user->count() == 0)
        {
            throw new Authentication(1002);
        }
        $row = $user->first();
        Session::put('id', $row->Id);
        Cache::store('redis')->put('userInfo_'.$row->Id, json_encode($row, true), 360);
        return true;
    }
}
