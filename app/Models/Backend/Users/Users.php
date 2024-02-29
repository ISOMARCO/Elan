<?php

namespace App\Models\Backend\Users;

use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Backend\Users\UsersException;
class Users extends Model
{
    use HasFactory;
    protected int|null $id = NULL;
    protected $table = 'Users';
    protected string|null $email = NULL;
    protected string|null $name = NULL;
    protected string|null $surname = NULL;
    protected int|null $phone = NULL;
    protected string|null $password = NULL;
    protected string|null $passwordRepeat = NULL;

    /**
     * @param $method
     * @param $args
     * @return $this
     */
    public function __call($method, $args = []) : Users
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
            case "password":
                $this->password = $args[0];
                break;
            case "password_repeat":
                $this->passwordRepeat = $args[0];
                break;
        }
        return $this;
    }
    public function allUsers(bool $active = true) : object
    {
        if($active)
        {
            return DB::table($this->table)->where('Status', '=', 'ACTIVE')->get();
        }
        return DB::table($this->table)->where('Status', '!=', 'ACTIVE')->get();
    }

    /**
     * @return bool
     * @throws UsersException
     */
    public function changeUser() : bool
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
            return true;
        }
        catch(QueryException $e)
        {
            if($e->getCode() == '23505') #duplicate error for postgresql
            {
                if(strpos($e->getMessage(), 'email_unique') !== false)
                {
                    throw new UsersException(2002);
                }
            }
            throw new UsersException(2003);
        }
    }

    public function createUser() : Object
    {
        if($this->name == NULL || $this->surname == NULL || $this->email == NULL || $this->password == NULL || $this->passwordRepeat == NULL)
        {
            throw new UsersException(2001);
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
        {
            throw new UsersException(2000);
        }
        if($this->password !== $this->passwordRepeat)
        {
            throw new UsersException(2006);
        }
        try
        {
            $this->password = hash('sha256', md5($this->password));
            DB::table($this->table)->insert([
                'Name' => $this->name,
                'Surname' => $this->surname,
                'Email' => $this->email,
                'Password' => $this->password,
                'Registration_Date' => date('Y-m-d H:i:s')
            ]);
            return DB::table($this->table)->select(['Id', 'Gender', 'Email', 'Name', 'Surname', 'Status', 'Phone_Number', 'Role'])->where('Email', $this->email)->get();
        }
        catch(QueryException $e)
        {
            if($e->getCode() == '23505') #duplicate error for postgresql
            {
                throw new UsersException(2002);
            }
            throw new UsersException(2007);
        }
    }
}
