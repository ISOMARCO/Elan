<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Users extends Model
{
    protected  $table = "Users";
    public $timestamps = false;
    protected $guarded = ['Id'];

}
