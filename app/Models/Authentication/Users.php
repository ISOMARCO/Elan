<?php

namespace App\Models\Authentication;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    use HasFactory;
    public function registerUser($data = [], $encrypt_password = true) : Array
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
}
