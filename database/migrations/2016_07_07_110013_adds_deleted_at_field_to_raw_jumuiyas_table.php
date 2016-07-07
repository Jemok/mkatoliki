<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddsDeletedAtFieldToRawJumuiyasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('raw_jumuiyas', function (Blueprint $table) {

            $table->dateTime('deleted_at');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('raw_jumuiyas', function (Blueprint $table) {

            $table->dropColumn('deleted_at');

        });
    }
}
