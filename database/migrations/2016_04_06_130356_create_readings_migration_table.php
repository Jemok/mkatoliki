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
            $table->dateTime('reading_date');

            //First Reading
            $table->string('first_reading_title');
            $table->string('first_reading_book');
            $table->text('first_reading_body');

            //Second Readings
            $table->string('second_reading_title');
            $table->string('second_reading_book');
            $table->text('second_reading_body');

            //Responsorial
            $table->string('responsorial_title');
            $table->string('responsorial_book');
            $table->text('responsorial_body_one');
            $table->string('responsorial_body_one_verse');
            $table->text('responsorial_body_two');

            //The gospel field
            $table->string('gospel_title');
            $table->text('gospel_book');
            $table->text('gospel_body');


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
