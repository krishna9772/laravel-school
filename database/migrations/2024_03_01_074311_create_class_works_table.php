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
        Schema::create('class_works', function (Blueprint $table) {
            $table->bigInteger('grade_id')->unsigned()->primary();
            $table->bigInteger('class_id')->unsigned();
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->bigInteger('curriculum_id')->unsigned();
            $table->foreign('curriculum_id')->references('id')->on('curricula')->onDelete('cascade');
            $table->string('topic_name', 100);
            $table->string('file_type', 50);
            $table->string('source_title', 100);
            $table->string('url');
            $table->string('file');
            $table->timestamp('created_date')->nullable();
            $table->timestamp('updated_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_works');
    }
};
