<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create course_types table
        Schema::create('course_types', function (Blueprint $table) {
            $table->id();
            $table->string('course_name');
            $table->timestamps();
        });

        // First schema change: Rename the 'type' column to 'course_type_id'
        Schema::table('subject_records', function (Blueprint $table) {
            if (Schema::hasColumn('subject_records', 'type')) {
                $table->renameColumn('type', 'course_type_id');
            }
        });

        // Rename 'startdate' to 'start_date' and 'enddate' to 'end_date'
        Schema::table('subject_records', function (Blueprint $table) {
            $table->renameColumn('startdate', 'start_date');
            $table->renameColumn('enddate', 'end_date');
        });

        // Second schema change: Change column type to unsignedBigInteger and add foreign key
        Schema::table('subject_records', function (Blueprint $table) {
            $table->unsignedBigInteger('course_type_id')->nullable()->change(); // Change to unsignedBigInteger
            $table->foreign('course_type_id')->nullable()->references('id')->on('course_types')->onDelete('SET NULL');
        });
    }

    public function down()
    {
        Schema::table('subject_records', function (Blueprint $table) {
            $table->dropForeign(['course_type_id']); // Drop the foreign key
        });

        // Revert column type back to string
        Schema::table('subject_records', function (Blueprint $table) {
            $table->string('course_type_id')->nullable()->change(); // Change back to string
            $table->renameColumn('course_type_id', 'type'); // Rename column back to 'type'
        });

        // Rename 'start_date' back to 'startdate' and 'end_date' back to 'enddate'
        Schema::table('subject_records', function (Blueprint $table) {
            $table->renameColumn('start_date', 'startdate');
            $table->renameColumn('end_date', 'enddate');
        });

        // Drop course_types table
        Schema::dropIfExists('course_types');
    }
};
