<?php

namespace App\Http\Controllers\Backend\Users;

use App\Http\Controllers\Controller;
use App\Models\Backend\Users\Users;
class UsersController extends Controller
{
    public function main()
    {
        $date = explode(" ", '2024-02-10 16:07:21');
        $dateFormat = explode('-', $date[0]);
        $months = [
            '01' => 'Yanvar',
            '02' => 'Fevral',
            '03' => 'Mart',
            '04' => 'Aprel',
            '05' => 'May',
            '06' => 'İyun',
            '07' => 'İyul',
            '08' => 'Avqust',
            '09' => 'Sentyabr',
            '10' => 'Oktyabr',
            '11' => 'Noyabr',
            '12' => 'Dekabr'
        ];
        echo $dateFormat[2]." ".$months[$dateFormat[1]]." ".$dateFormat[0]." ".$date[1];
        $users = new Users();
        $userList = $users->allUsers();
        return view('Backend.Users.main', compact('userList'));
    }
}
