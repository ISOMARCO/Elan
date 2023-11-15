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
            $table->enum('Is_Active', ['ACTIVE', 'BAN'])->default('ACTIVE');
            $table->string('Password', 255)->nullable();
            $table->string('Phone', 25)->nullable();
            $table->timestamps();
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
