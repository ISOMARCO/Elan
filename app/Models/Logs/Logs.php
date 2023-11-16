<?php

namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Logs extends Model
{
    use HasFactory;
    public function insertTelegramBotLog($text, $line = 1)
    {
        DB::table('Logs')->insert([
            'Text' => $text,
            'Line' => $line
        ]);
    }
}
