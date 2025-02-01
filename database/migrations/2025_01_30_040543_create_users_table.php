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
            $table->foreignId('employee_id')->constrained('employees')->onDelete('RESTRICT'); // Foreign key to employees table
            $table->string('username'); // Username column
            $table->foreignId('role_id')->constrained('roles')->onDelete('RESTRICT'); // Role reference column
            $table->enum('status', ['active', 'inactive', 'suspended']); // Enum for status
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
