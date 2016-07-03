<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementsTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('announcement');
            $table->dateTime('date');
            $table->integer('user_id');
            $table->integer('station_id');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
            $table->foreign('station_id')
                  ->references('id')
                  ->on('stations');
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
        Schema::drop('announcements');
    }
}
