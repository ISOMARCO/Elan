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
    protected $table = 'Roles';
    public function up(): void
    {
        if(!Schema::hasTable($this->table))
        {
            Schema::create($this->table, function (Blueprint $table) {
                $table->uuid('Id')->default(DB::raw('gen_random_uuid()'));
                $table->string('Code', 50)->unique();
                $table->longText('Description')->nullable();
                $table->string('Status', 30)->default('ACTIVE');
                $table->timestamp('Created_Date');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop($this->table);
    }
};
