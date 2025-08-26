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
       Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id');                 // primary per requirement
            $table->string('user_name');
            $table->string('user_email')->unique();
            $table->string('password');
            $table->string('user_mobile_no')->nullable();
            $table->enum('user_type', ['admin','user','employee','sub_user'])->default('user');
            $table->enum('user_status', ['inactive','active','blocked'])->default('inactive');
            $table->string('activation_token', 64)->nullable();
            $table->unsignedBigInteger('parent_id')->nullable(); // sub-user parent
            $table->rememberToken(); 
            $table->timestamps();

            $table->foreign('parent_id')->references('user_id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
