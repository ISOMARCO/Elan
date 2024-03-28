<?php

namespace App\Models\Backend\Money_Manager;

use App\Exceptions\Backend\Money_Manager\MoneyManagerException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Goods extends Model
{
    use HasFactory;
    protected string $table = 'Goods';
    protected string|NULL $name = NULL;
    protected string|NULL $barcode = NULL;
    protected double $price = 0;
    protected double $tax = 18;
    protected string $status = 'ACTIVE';
    public function __call($method, $args = []) : Goods
    {
        $this->$method = $args[0];
        return $this;
    }
    public function allGoods()
    {
    }

    public function createGoods() : object
    {
        if($this->name == NULL || $this->barcode == NULL || $this->price === NULL || $this->tax === NULL)
        {
            throw new MoneyManagerException(4000);
        }
        if($this->price <= 0)
        {
            throw new MoneyManagerException(4001);
        }
        if($this->tax < 0)
        {
            throw new MoneyManagerException(4002);
        }
        $insert = DB::table($this->table)->insert([
            'Name' => $this->name,
            'Barcode' => $this->barcode,
            'Price' => $this->price,
            'Tax' => $this->tax,
            #'User' => Session::get('id'),
            'Status' => $this->status,
            'Created_Date' => date('Y-m-d H:i:s')
        ]);
        if(!$insert)
        {
            throw new MoneyManagerException(4003);
        }
        return DB::table($this->table)->where('Barcode', '=', $this->barcode)->first();
    }
}
