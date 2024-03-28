<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $table = 'Goods';
    public function up(): void
    {
        if(!Schema::hasTable($this->table))
        {
            Schema::create($this->table, function (Blueprint $table) {
                $table->uuid('Id')->default('gen_random_uuid()');
                $table->string('Name', 50);
                $table->string('Barcode', 100)->nullable();
                $table->decimal('Price', 8, 2)->default(0);
                $table->decimal('Tax', 8, 2)->default(18);
                $table->integer('User');
                $table->string('Status', 30)->default('ACTIVE');
                $table->timestamp('Created_Date')->default("to_char(now(), 'YYYY-MM-DD HH24:MI:SS')");
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
