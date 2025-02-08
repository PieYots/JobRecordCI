<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/2025_01_30_000010_create_subject_records_table.php
    public function up()
    {
        Schema::create('subject_records', function (Blueprint $table) {
            $table->id();
            $table->string('topic')->nullable();
            $table->unsignedBigInteger('course_type_id')->nullable();  // Replace 'type1', etc. with real types
            $table->longText('process')->nullable(); // Changed to longText
            $table->longText('result')->nullable();
            $table->string('file_ref')->nullable();
            $table->integer('rating')->nullable();  // Add more ratings if needed
            $table->string('additional_learning')->nullable();
            $table->unsignedBigInteger('ojt_record_id')->nullable();
            $table->unsignedBigInteger('e_training_id')->nullable();
            $table->unsignedBigInteger('recorded_by')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->enum('status', ['waiting', 'pass', 'fail'])->default('waiting');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');

            // Foreign key constraint
            $table->foreign('e_training_id')->references('id')->on('e_trainings')->onDelete('SET NULL');
            $table->foreign('recorded_by')->references('id')->on('employees')->onDelete('SET NULL');
            $table->foreign('course_type_id')->references('id')->on('course_types')->onDelete('SET NULL');
            $table->foreign('ojt_record_id')->references('id')->on('ojt_records')->onDelete('SET NULL');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subject_records');
    }
};
