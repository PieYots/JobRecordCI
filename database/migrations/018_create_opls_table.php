<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('opls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->enum('type', ['paper', 'video']);
            $table->string('topic');
            $table->longText('description')->nullable();
            $table->string('file_ref')->nullable();
            $table->longText('result')->nullable();
            $table->unsignedBigInteger('e_training_id')->nullable();
            $table->unsignedBigInteger('reference_stpm_id')->nullable();
            $table->unsignedBigInteger('reference_course_id')->nullable();
            $table->enum('status', ['waiting', 'pass', 'fail'])->default('waiting');
            $table->timestamps();

            $table->foreign('e_training_id')->references('id')->on('e_trainings')->onDelete('set null');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('reference_stpm_id')->references('id')->on('stpm_records')->onDelete('set null');
            $table->foreign('reference_course_id')->references('id')->on('subject_records')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('opls');
    }
};
