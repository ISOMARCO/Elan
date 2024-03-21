<?php

namespace App\Models\Backend\Ads;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Category extends Model
{
    use HasFactory;
    protected $table = 'Category';

    public function allCategory()
    {
        return DB::table($this->table)->where('Level', 1)->get();
    }
}
