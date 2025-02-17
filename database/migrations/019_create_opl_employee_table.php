<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('opl_employee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opl_id')->nullable()->constrained('opls')->onDelete('set null'); // Foreign key to OPL
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null'); // Foreign key to Employee
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('opl_employee');
    }
};
