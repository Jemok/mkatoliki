<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJumuiyasTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jumuiyas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('location');
            $table->timestamp('happening_on');
            $table->integer('user_id')->unsigned();
            $table->integer('raw_jumuiya_id')->unsigned();
            $table->text('more_details');
            $table->string('day_event_name');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jumuiyas');
    }
}
