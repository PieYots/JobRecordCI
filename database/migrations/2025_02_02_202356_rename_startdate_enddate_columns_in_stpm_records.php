<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('stpm_records', function (Blueprint $table) {
            $table->renameColumn('startdate', 'start_date');
            $table->renameColumn('enddate', 'end_date');
        });
    }

    public function down()
    {
        Schema::table('stpm_records', function (Blueprint $table) {
            $table->renameColumn('start_date', 'startdate');
            $table->renameColumn('end_date', 'enddate');
        });
    }
};
