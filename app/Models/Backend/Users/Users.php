<?php

namespace App\Models\Backend\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Backend\Users\Users as UsersException;
class Users extends Model
{
    use HasFactory;
    protected $table = 'Users';
    public function allUsers()
    {
        return DB::table($this->table)->get();
    }

    public function changeUser($data = [])
    {
        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
        {
            throw new UsersException(2000);
        }
        return true;
    }
}
