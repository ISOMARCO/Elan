<?php

namespace App\Models;
class Users extends Model
{
    protected  $table = "Users";
    public $timestamps = false;
    protected $guarded = ['Id'];

}
