<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stpm_records', function (Blueprint $table) {
            $table->integer('progress')->default(0);
        });
    }

    public function down()
    {
        Schema::table('stpm_records', function (Blueprint $table) {
            $table->dropColumn('progress');
        });
    }
};
