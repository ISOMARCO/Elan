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
    protected $table = 'Goods';
    public function up(): void
    {
        if(!Schema::hasTable($this->table))
        {
            Schema::create($this->table, function (Blueprint $table) {
                $table->uuid('Id')->default(DB::raw('gen_random_uuid()'));
                $table->string('Name', 50);
                $table->string('Barcode', 100)->nullable();
                $table->decimal('Price', 8, 2)->default(0);
                $table->decimal('Tax', 8, 2)->default(18);
                $table->uuid('User')->nullable();
                $table->string('Status', 30)->default('ACTIVE');
                $table->timestamp('Created_Date');
                $table->unique(['Barcode', 'Status']);
                $table->foreign('User')->references('Id')->on('Users');
                $table->index(['Barcode', 'User']);
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
