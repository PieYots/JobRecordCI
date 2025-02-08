<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ojt_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->enum('type', ['learner', 'instructor']);
            $table->string('topic')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('hour')->nullable();
            $table->longText('detail')->nullable();
            $table->string('file_ref')->nullable();
            $table->string('instructor_name')->nullable();  // Only for Learner type
            $table->string('external_institution')->nullable();  // Only for Learner type
            $table->string('learner_name')->nullable();  // Only for Instructor type
            $table->longText('comment')->nullable();  // Only for Instructor type
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ojt_records');
    }
};
