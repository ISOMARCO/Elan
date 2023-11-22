<?php

namespace App\Models\Authentication;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

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

    public function login($email_or_phone, $password, $encryptPassword = true) : Array
    {
        if($encryptPassword === true)
        {
            $password = hash('sha256', md5($password));
        }
        if(filter_var($email_or_phone, FILTER_VALIDATE_EMAIL))
        {
            $user = DB::table('Users')->whereRaw("Email = ? and Password = ?", [$email_or_phone, $password]);
            if($user->count() == 0)
            {
                return [false];
            }
            return $user->get();
        }
        return [true];
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
}
