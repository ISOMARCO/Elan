<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $table = 'User_Status_History';
    public function up(): void
    {
        if(!Schema::hasTable($this->table))
        {
            Schema::create($this->table, function (Blueprint $table) {
                $table->uuid('Id')->default(DB::raw('gen_random_uuid()'));
                $table->integer('User_Id')->nullable();
                $table->string('From_Status', 10)->nullable();
                $table->string('To_Status', 10)->nullable();
                $table->longText('Reason')->nullable();
                $table->timestamp('Date')->nullable();
                $table->integer('Updated_By')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
