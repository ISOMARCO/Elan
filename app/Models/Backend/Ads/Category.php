<?php

namespace App\Models\Backend\Ads;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Category extends Model
{
    use HasFactory;
    protected $table = 'Category';
    protected int|NULL $id = NULL;
    protected string|NULL $name = NULL;
    protected int|NULL $parent = NULL;
    protected int|NULL $mainCategory = NULL;
    protected int $level = 1;
    protected string $status = 'ACTIVE';
    protected string|NULL $photo = NULL;
    protected string|NULL $createdDate = NULL;

    public function __call($method, $args=[]) : Category
    {
        $this->$method = $args[0];
        return $this;
    }

    public function allCategory() : Array
    {
        return DB::table($this->table)->where('Level', 1)->get();
    }

    public function createCategory() : bool
    {
        return true;
    }
}
