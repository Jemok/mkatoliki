<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadingsMigrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('readings', function (Blueprint $table) {
            $table->increments('id');

            //The first reading field
            $table->text('first_reading');

            //The secong reading field
            $table->text('second_reading');

            //The responsorial psalm field
            $table->text('responsorial');

            //The gospel field
            $table->text('gospel');

            $table->dateTime('mass_day');

            //The id of the user who created the entry
            $table->integer('user_id')->unsigned();

            //The created_at and updated_at fields
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('readings');
    }
}
