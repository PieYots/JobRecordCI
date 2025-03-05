<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {

        Schema::create('e_training_employee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('e_training_id')->nullable()->constrained('e_trainings')->onDelete('SET NULL');
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    public function down(): void
    {

        Schema::dropIfExists('e_training_employee');
    }
};
