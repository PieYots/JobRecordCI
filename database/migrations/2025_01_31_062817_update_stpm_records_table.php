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
            $table->unsignedBigInteger('team_id')->nullable(false)->change();
            $table->unsignedBigInteger('machine_id')->nullable(false)->change();
            $table->unsignedBigInteger('job_id')->nullable(false)->change();
            $table->unsignedBigInteger('e_training_id')->nullable(false)->change();
            $table->unsignedBigInteger('record_by')->nullable(false)->change();
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
            $table->unsignedBigInteger('team_id')->nullable()->change();
            $table->unsignedBigInteger('machine_id')->nullable()->change();
            $table->unsignedBigInteger('job_id')->nullable()->change();
            $table->unsignedBigInteger('e_training_id')->nullable()->change();
            $table->unsignedBigInteger('record_by')->nullable()->change();
            $table->string('file_ref')->nullable(false)->change();
        });
    }
}
