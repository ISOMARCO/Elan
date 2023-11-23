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
            $table->string('Email', 100)->nullable()->unique();
            $table->string('Is_Active', 6)->default('ACTIVE')->comment('Enum: ACTIVE, BAN');
            $table->string('Password', 255)->nullable();
            $table->string('Phone_Number', 25)->nullable();
            $table->string('Default_Language', 5)->default('az');
            $table->timestamp('Last_Login_Date')->nullable();
            $table->string('Gender', 6)->default('MALE')->comment('Enum: MALE, FEMALE');
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
