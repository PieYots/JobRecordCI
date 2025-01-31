<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/2025_01_30_000001_create_tokens_table.php
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('access_token');
            $table->string('refresh_token');
            $table->timestamp('access_created_at');
            $table->timestamp('refresh_created_at');
            $table->timestamp('access_expire_at');
            $table->timestamp('refresh_expire_at');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tokens');
    }
};
