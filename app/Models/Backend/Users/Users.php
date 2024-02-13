<?php

namespace App\Models\Backend\Users;

use Couchbase\QueryException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Backend\Users\Users as UsersException;
class Users extends Model
{
    use HasFactory;
    protected $id = NULL;
    protected $table = 'Users';
    protected $email = NULL;
    protected $name = NULL;
    protected $surname = NULL;
    protected $phone = NULL;
    public function __call($method, $args = [])
    {
        switch($method)
        {
            case "email":
                $this->email = $args[0];
                break;
            case "name":
                $this->name = $args[0];
                break;
            case "surname":
                $this->surname = $args[0];
                break;
            case "id":
                $this->id = $args[0];
                break;
        }
        return $this;
    }
    public function allUsers()
    {
        return DB::table($this->table)->get();
    }

    public function changeUser()
    {
        if($this->name == NULL || $this->surname == NULL || $this->email == NULL)
        {
            throw new UsersException(2001);
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
        {
            throw new UsersException(2000);
        }
        try
        {
            DB::table($this->table)->where('Id', $this->id)->update(['Name' => $this->name, 'Surname' => $this->surname, 'Email' => $this->email]);
        }
        catch(QueryException $e)
        {

        }

    }
}
