<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('improvements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();  // Recorder (employee)
            $table->enum('type', ['paper', 'video'])->nullable();
            $table->string('topic')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->longText('previous_working')->nullable();
            $table->longText('new_working')->nullable();
            $table->string('file_ref')->nullable();
            $table->enum('target_improvement', ['speed', 'accuracy', 'efficiency'])->nullable();  // Mock enum for target improvement
            $table->longText('result')->nullable();
            $table->integer('ctl_reduction')->nullable();
            $table->enum('department_effect', ['HR', 'Engineering', 'Marketing', 'Sales', 'Customer Support'])->nullable();;  // Updated enum values for department_effect
            $table->integer('rating')->nullable(); // 1-5
            $table->string('additional_learning')->nullable();
            $table->unsignedBigInteger('e_training_id')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('e_training_id')->references('id')->on('e_trainings')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('improvements');
    }
};
