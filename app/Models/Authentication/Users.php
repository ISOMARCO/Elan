<?php

namespace App\Models\Authentication;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    use HasFactory;
    public function registerUser($data = [], $encrypt_password = true) : bool
    {
        $password = $data['password'];
        if($encrypt_password === true)
        {
            $password = hash('sha256', md5($data['password']));
        }
        $phone = preg_replace("/[^0-9]/", "", $data['phone_number']);
        if(strlen($phone) == 9) {
            $phone = "994".$phone;
        }
        return DB::table('Users')->insert([
            'Name' => $data['name'],
            'Surname' => $data['surname'],
            'Phone_Number' => $phone,
            'Email' => $data['email'],
            'Password' => $password,
            'Gender' => $data['gender']
        ]);
    }
}
