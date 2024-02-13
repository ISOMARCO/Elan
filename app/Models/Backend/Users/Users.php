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
    protected $table = 'Users';
    protected $email = NULL;
    protected $name = NULL;
    protected $surname = NULL;
    protected $phone = NULL;
    public function __construct(...$vars)
    {

    }
    public function allUsers()
    {
        return DB::table($this->table)->get();
    }

    public function changeUser($data = [])
    {
        if($data['name'] == NULL || $data['surname'] == NULL || $data['email'] == NULL)
        {
            throw new UsersException(2001);
        }
        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
        {
            throw new UsersException(2000);
        }
        try
        {
            DB::table($this->table)->where('Id', $data['id'])->update(['Name' => $data['name'], 'Surname' => $data['surname'], 'Email' => $data['email']]);
        }
        catch(QueryException $e)
        {

        }

    }
}
