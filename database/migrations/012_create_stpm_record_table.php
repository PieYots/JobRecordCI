<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/2025_01_30_000009_create_stpm_records_table.php
    public function up()
    {
        Schema::create('stpm_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->boolean('is_team');
            $table->unsignedBigInteger('machine_id')->nullable();
            $table->unsignedBigInteger('job_id')->nullable();
            $table->string('file_ref')->nullable();
            $table->boolean('is_finish');
            $table->integer('progress')->default(0);
            $table->unsignedBigInteger('recorded_by')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->enum('status', ['waiting', 'pass', 'fail'])->default('waiting');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');

            // Foreign key constraints
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('SET NULL');
            $table->foreign('machine_id')->references('id')->on('machines')->onDelete('SET NULL');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('SET NULL');
            $table->foreign('recorded_by')->references('id')->on('employees')->onDelete('SET NULL');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stpm_records');
    }
};
