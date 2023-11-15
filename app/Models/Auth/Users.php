<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    use HasFactory;
    public function insertUser() : void
    {
        DB::table('Users')->insert([
            'Name' => 'Ismayil',
            'Surname' => 'Nagiyev'
        ]);
    }
}
