<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('azure_ad_object_id'); // Azure AD Object ID
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('SET NULL'); // Foreign key to employees table
            $table->string('username'); // Username column
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('SET NULL'); // Role reference column
            $table->enum('status', ['active', 'inactive', 'suspended']); // Enum for status
            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('SET NULL');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
