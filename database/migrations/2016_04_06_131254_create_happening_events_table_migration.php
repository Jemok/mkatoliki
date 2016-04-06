<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHappeningEventsTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('happening_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('event_title');
            $table->text('event_body');
            $table->string('event_excerpt');
            $table->dateTime('event_date');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('happening_events');
    }
}
