<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Users', function (Blueprint $table) {
            $table->bigIncrements('Id');
            $table->string('Name', 50)->nullable();
            $table->string('Surname', 50)->nullable();
            $table->string('Email', 100)->nullable();
            $table->string('Is_Active', 10)->default('ACTIVE')->comment('Enum: ACTIVE, BAN');
            $table->string('Password', 255)->nullable();
            $table->string('Phone', 25)->nullable();
            $table->timestamp('Last_Login_Date')->nullable();
            $table->enum('Gender', ['MALE', 'FEMALE'])->default('MALE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('Users');
    }
};
