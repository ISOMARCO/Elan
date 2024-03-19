<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $table = 'Category';
    public function up(): void
    {
        if(!Schema::hasTable($this->table))
        {
            Schema::create($this->table, function (Blueprint $table) {
                $table->bigIncrements('Id');
                $table->string('Name', 200)->nullable();
                $table->integer('Parent')->nullable();
                $table->integer('Main_Category')->nullable();
                $table->smallInteger('Level')->default('1');
                $table->string('Status', 10)->default('ACTIVE');
                $table->timestamp('Created_Date')->nullable();
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
