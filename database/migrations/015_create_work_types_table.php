<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('work_types', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['Kaizen', 'OE']);
            $table->string('name'); // Work type name
            $table->boolean('has_criteria')->default(false); // Determines if Kaizen work type needs criteria
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('work_types');
    }
};
