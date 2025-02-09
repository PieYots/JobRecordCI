<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('stpm_employee_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stpm_record_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('SET NULL');
            $table->foreignId('ojt_record_id')->nullable()->constrained('ojt_records')->onDelete('SET NULL');
            $table->foreignId('e_training_id')->nullable()->constrained('e_trainings')->onDelete('SET NULL');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stpm_employee_records');
    }
};
