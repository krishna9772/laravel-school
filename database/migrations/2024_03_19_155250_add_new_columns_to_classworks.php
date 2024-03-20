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
        Schema::table('class_works', function (Blueprint $table) {
            $table->bigIncrements('id')->first();
            $table->enum('status', [0, 1])->nullable()->default(1);
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class_works', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropColumn('status');
            $table->dropColumn('deleted_at');
        });
    }
};
