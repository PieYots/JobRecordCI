<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('stpm_records', function (Blueprint $table) {
            $table->dateTime('startdate')->nullable();
            $table->dateTime('enddate')->nullable();
        });

        Schema::table('subject_records', function (Blueprint $table) {
            $table->dateTime('startdate')->nullable();
            $table->dateTime('enddate')->nullable();
        });

        Schema::create('e_training_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('e_training_id')->nullable()->constrained('e_trainings')->onDelete('SET NULL');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('stpm_records', function (Blueprint $table) {
            $table->dropColumn(['startdate', 'enddate']);
        });

        Schema::table('subject_records', function (Blueprint $table) {
            $table->dropColumn(['startdate', 'enddate']);
        });

        Schema::dropIfExists('e_training_user');
    }
};
