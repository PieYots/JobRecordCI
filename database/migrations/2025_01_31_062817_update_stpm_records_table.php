<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStpmRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stpm_records', function (Blueprint $table) {
            // Modify your fields here to make them non-nullable
            $table->string('file_ref')->nullable()->change();
            // You can also modify other columns or add new ones
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stpm_records', function (Blueprint $table) {
            // You can rollback the changes if necessary
            $table->string('file_ref')->nullable(false)->change();
        });
    }
}
