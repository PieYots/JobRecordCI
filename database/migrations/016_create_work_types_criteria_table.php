<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {

        Schema::create('work_type_criterias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_type_id')->constrained()->onDelete('SET NULL');
            $table->string('name'); // Criteria name
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('work_type_criterias');
    }
};
