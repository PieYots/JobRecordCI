<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('subject_records', function (Blueprint $table) {
            $table->string('topic')->nullable()->change();
            $table->string('reference')->nullable()->change();
            $table->string('process')->nullable()->change();
            $table->string('result')->nullable()->change();
            $table->string('file_ref')->nullable()->change();
            $table->integer('rating')->nullable()->change();
            $table->string('additional_learning')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('subject_records', function (Blueprint $table) {
            $table->string('topic')->nullable(false)->change();
            $table->string('reference')->nullable(false)->change();
            $table->string('process')->nullable(false)->change();
            $table->string('result')->nullable(false)->change();
            $table->string('file_ref')->nullable(false)->change();
            $table->integer('rating')->nullable(false)->change();
            $table->string('additional_learning')->nullable(false)->change();
        });
    }
};
