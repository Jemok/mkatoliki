<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddsDeletedAtFieldToUserOutstationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_outstations', function (Blueprint $table) {

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
        Schema::table('user_outstations', function (Blueprint $table) {

            $table->dropColumn('deleted_at');

        });
    }
}
