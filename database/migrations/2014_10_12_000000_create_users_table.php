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
            $table->id();
            $table->string('user_id')->unique();
            $table->string('user_name',50);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('gender',30);
            $table->string('user_type',30);
            $table->string('nrc',50)->nullable();
            $table->timestamp('admission_date')->nullable();
            $table->string('father_name',50)->nullable();
            $table->string('mother_name',50)->nullable();
            $table->integer('phone_number')->nullable();
            $table->string('address',100)->nullable();
            $table->string('former_school',100)->nullable();
            $table->timestamps();
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
