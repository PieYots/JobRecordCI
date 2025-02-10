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
            $table->timestamps();

            $table->foreign('e_training_id')->references('id')->on('e_trainings')->onDelete('set null');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('opls');
    }
};
