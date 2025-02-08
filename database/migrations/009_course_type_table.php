<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create course_types table
        Schema::create('course_types', function (Blueprint $table) {
            $table->id();
            $table->string('course_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        // Drop course_types table
        Schema::dropIfExists('course_types');
    }
};
