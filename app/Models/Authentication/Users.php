<?php

namespace App\Models\Authentication;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Users extends Model
{
    use HasFactory;
    public function RegisterUser($data = [], $encrypt_password = true) : Array
    {
        $password = $data['password'];
        if($encrypt_password === true)
        {
            $password = hash('sha256', md5($data['password']));
        }
        $phone = preg_replace("/[^0-9]/", "", $data['phone_number']);
        if(strlen($phone) == 9) {
            $phone = "994".$phone;
        }elseif(strlen($phone) == 10)
        {
            $phone = "994".ltrim($phone, '0');
        }
        try
        {
            DB::table('Users')->insert([
                'Name' => $data['name'],
                'Surname' => $data['surname'],
                'Phone_Number' => $phone,
                'Email' => $data['email'],
                'Password' => $password,
                'Gender' => $data['gender']
            ]);
            return [true];
        }
        catch(QueryException $e)
        {
            if($e->getCode() == '23505') #duplicate error for postgresql
            {
                if(strpos($e->getMessage(), 'email_unique') !== false)
                {
                    return [false, ['key' => 'email', 'type' => 'duplicate']];
                }
            }
            return [false];
        }
    }

    public function login($email_or_phone, $password, $remember_me, $encryptPassword = true) : Array
    {
        if($encryptPassword === true)
        {
            $password = hash('sha256', md5($password));
        }
        $user = DB::table('Users')->where('Password', '=', $password);
        if(filter_var($email_or_phone, FILTER_VALIDATE_EMAIL))
        {
            $user->where('Email', '=', $email_or_phone);
        }
        elseif(is_numeric($email_or_phone))
        {
            $user->where('Phone_Number', '=', $email_or_phone);
        }
        else
        {
            return [false, 'undefined_email_or_phone'];
        }
        try
        {
            if($user->count() == 0)
            {
                return [false, 'no_user'];
            }
            $result = $user->first();
            if($remember_me)
            {
                $rememberToken = hash('sha256', uniqid());
                DB::table('Users')->where('Id', $result->Id)->update([
                    'Last_Login_Date' => date('Y-m-d H:i:s'),
                    'Remember_Token' => $rememberToken
                ]);
                Cookie::queue(Cookie::make('Remember_Me', $rememberToken, (60*24*365)));
            }
            else
            {
                DB::table('Users')->where('Id', $result->Id)->update([
                    'Last_Login_Date' => date('Y-m-d H:i:s')
                ]);
            }
            return [true, $result];
        }
        catch(QueryException $e)
        {
            return [false, $e->getMessage()];
        }

    }

    public function String_Replace($string) : String
    {
        $string = strpos($string, ':') === 0 ? $string : ':' . $string;
        $fields = [
            ':name' => 'Ad',
            ':surname' => 'Soyad',
            ':email' => 'Email',
            ':phone_number' => 'Telefon nömrəsi',
            ':gender' => 'Cins',
            ':password' => 'Şifrə',
            ':repeat_password' => 'Şifrə təkrarı',
            ':email_or_phone' => 'Email və ya telefon nömrəsi'
        ];
        #return str_replace(array_keys($fields), array_values($fields), $string);
        return $fields[$string];
    }

    public function Login_With_Token($token = NULL) : Bool
    {
        if($token === NULL)
        {
            $token = Cookie::get('Remember_Me');
        }
        $user = DB::table('Users')->where('Remember_Token', '=', $token);
        echo $token;
        if($user->count() == 0)
        {
            return false;
        }
        $result = $user->first();
        Session::put('id', $result->Id);
        DB::table('Users')->where('Id', $result->Id)->update([
            'Last_Login_Date' => date('Y-m-d H:i:s')
        ]);
        return true;
    }
}
