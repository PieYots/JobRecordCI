<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('competitive_records', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Kaizen', 'OE']);
            $table->string('topic')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('work_type')->nullable(); // Karakuri + other (Kaizen) or other (OE)
            $table->string('work_type_criteria')->nullable(); // Null if Karakuri
            $table->string('file_ref')->nullable(); // File reference
            $table->double('result')->nullable();
            $table->unsignedBigInteger('reference_stpm_id')->nullable();
            $table->unsignedBigInteger('reference_course_id')->nullable();
            $table->unsignedBigInteger('reference_opls_id')->nullable();
            $table->unsignedBigInteger('reference_improvement_id')->nullable();
            $table->enum('status', ['waiting', 'pass', 'fail', 'ongoing', 'eliminated', 'qualify'])->default('waiting');
            $table->unsignedBigInteger('support_strategy_id')->nullable();
            $table->string('competitive_name')->nullable(); // File reference
            $table->double('score')->default(0);
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('reference_stpm_id')->references('id')->on('stpm_records')->onDelete('set null');
            $table->foreign('reference_course_id')->references('id')->on('subject_records')->onDelete('set null');
            $table->foreign('reference_opls_id')->references('id')->on('opls')->onDelete('set null');
            $table->foreign('reference_improvement_id')->references('id')->on('improvements')->onDelete('set null');
            $table->foreign('support_strategy_id')->references('id')->on('support_strategy')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('competitive_records');
    }
};
