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
            $table->string('topic');
            $table->enum('type', ['type1', 'type2', 'type3']);  // Replace 'type1', etc. with real types
            $table->string('reference');
            $table->string('process');
            $table->string('result');
            $table->string('file_ref');
            $table->enum('rating', ['excellent', 'good', 'average', 'poor']);  // Add more ratings if needed
            $table->string('additional_learning');
            $table->unsignedBigInteger('e_training_id');
            $table->timestamp('create_at');
            $table->unsignedBigInteger('record_by');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('e_training_id')->references('id')->on('e_trainings')->onDelete('cascade');
            $table->foreign('record_by')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subject_records');
    }
};
