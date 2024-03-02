<?php

namespace App\Models\Backend\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Exceptions\Backend\Users\UsersException;
class User_Status_History extends Model
{
    use HasFactory;
    protected array $allStatus = ['ACTIVE', 'DEACTIVE', 'BAN'];
    protected $table = 'User_Status_History';
    protected int $id;
    protected string $fromStatus;
    protected string $toStatus;
    protected int|NULL $userId;
    protected string|NULL $reason;

    public function __call($method, $args = [])
    {
        switch($method)
        {
            case "fromStatus":
                if(in_array($args[0], $this->allStatus))
                {
                    $this->fromStatus = $args[0];
                }
                break;
            case "id":
                $this->id = $args[0];
                break;
            case "toStatus":
                if(in_array($args[0], $this->allStatus))
                {
                    $this->toStatus = $args[0];
                }
                break;
            case "userId":
                $this->userId = $args[0];
                break;
            case "reason":
                $this->reason = $args[0];
                break;
        }
        return $this;
    }
    public function changeStatus()
    {
        if($this->fromStatus == NULL || $this->toStatus == NULL)
        {
            throw new UsersException(2005);
        }
        if($this->fromStatus === $this->toStatus)
        {
            return true;
        }
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
