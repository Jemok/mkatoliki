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
            // The primary key of this table
            $table->increments('id');

            // The dates when the reading is for
            $table->dateTime('reading_date');
            $table->dateTime('reading_day');

            //First Reading titile
            $table->string('first_reading_title');
            // Verse from where the first reading comes from
            $table->string('first_reading_book');
            // The body of the first reading
            $table->text('first_reading_body');

            // The second reading title
            $table->string('second_reading_title');
            // The verse from where the second reading comes
            $table->string('second_reading_book');
            // The body of the second reading
            $table->text('second_reading_body');

            // The title of the responsorial psalm
            $table->string('responsorial_title');
            // The responsorial psalm reading verse
            $table->string('responsorial_book');
            // The response psalm reading body
            $table->text('responsorial_body_one');
            // The response verse
            $table->string('responsorial_body_one_verse');
            // The response
            $table->text('responsorial_body_two');

            //The gospel field
            $table->string('gospel_title');
            // The gospel verse
            $table->text('gospel_book');
            // The gospel itself
            $table->text('gospel_body');

            //The id of the user who created the entry
            $table->integer('user_id')->unsigned();

            //The created_at and updated_at fields
            $table->timestamps();

            // The user who created the reading
            // Should be the administrator of the app
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
