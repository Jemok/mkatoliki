<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddsLocationAndStationIdFieldsToHappeningEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('happening_events', function (Blueprint $table) {

            $table->string('location');

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $table->integer('station_id')->index()->unsigned()->foreign('station_id')
                  ->references('id')
                  ->on('stations');
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('happening_events', function (Blueprint $table) {

            $table->dropColumn('location');
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $table->dropColumn('station_id');
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        });
    }
}
