<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $table = 'User_Status_History';
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('Id');
            $table->integer('User_Id')->nullable();
            $table->string('From_Status', 6)->nullable();
            $table->string('To_Status', 6)->nullable();
            $table->longText('Reason');
            $table->timestamp('Date')->nullable();
            $table->integer('Updated_By')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
