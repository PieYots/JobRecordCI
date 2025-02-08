<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stpm_record_employee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stpm_record_id')->nullable()->constrained('stpm_records')->onDelete('SET NULL');
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stpm_record_employee');
    }
};
