<?php

namespace App\Models\Backend\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Users extends Model
{
    use HasFactory;
    protected $table = 'Users';
    public function allUsers()
    {
        return DB::table($this->table)->get();
    }
}
