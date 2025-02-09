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
            $table->unsignedBigInteger('stpm_record_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->string('work_type')->nullable(); // Kurakuri + other (Kaizen) or other (OE)
            $table->string('work_type_criteria')->nullable(); // Null if Kurakuri
            $table->string('file_ref')->nullable(); // File reference
            $table->longText('result')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('competitive_records');
    }
};
