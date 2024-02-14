<?php

namespace App\Models\Backend\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Exceptions\Backend\Users\Users as UsersException;
class User_Status_History extends Model
{
    use HasFactory;
    protected $table = 'User_Status_History';
    protected $id = NULL;
    protected $fromStatus = NULL;
    protected $toStatus = NULL;
    protected $userId = NULL;
    protected $reason = NULL;
    public function __call($method, $args = [])
    {

    }

    public function changeStatus() :  bool
    {
        DB::beginTransaction();
        try
        {
            DB::table('Users')->where('Id', $this->userId)->update([
                'Status' => $this->toStatus
            ]);
            DB::table($this->table)->insert([
                'User_Id' => $this->userId,
                'From_Status' => $this->fromStatus,
                'To_Status' => $this->toStatus,
                'Reason' => $this->reason,
                'Date' => date('Y-m-d H:i:s'),
                'Updated_By' => Session::get('id')
            ]);
            DB::commit();
            return true;
        }
        catch(QueryException $e)
        {
            DB::rollBack();
            throw new UsersException(2004);
        }
    }
}
