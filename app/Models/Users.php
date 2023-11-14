<?php

namespace App\Models;
class Users
{
    use HasFactory;
    protected  $table = "Users";
    public $timestamps = false;
    protected $guarded = ['Id'];

}
