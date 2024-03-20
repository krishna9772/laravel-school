<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('class_works', function (Blueprint $table) {
            // Modifying existing columns
            $table->string('file_type', 50)->nullable()->change();
            $table->string('source_title', 100)->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('file')->nullable()->change();

            // Adding new column
            $table->string('sub_topic_name',100)->nullable();

            // Modifying primary key
            $table->dropPrimary('class_works_grade_id_primary');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('class_works', function (Blueprint $table) {
            // Dropping added column
            $table->dropColumn('sub_topic_name',100);

            $table->string('file_type', 50)->change();
            $table->string('source_title', 100)->change();
            $table->string('url')->change();
            $table->string('file')->change();


            $table->primary('id');
            $table->dropForeign(['grade_id']);
        });
    }
};
