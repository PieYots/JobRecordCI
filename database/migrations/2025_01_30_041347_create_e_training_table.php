<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/2025_01_30_000008_create_e_trainings_table.php
    public function up()
    {
        Schema::create('e_trainings', function (Blueprint $table) {
            $table->id();
            $table->string('e_training_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('e_trainings');
    }
};
