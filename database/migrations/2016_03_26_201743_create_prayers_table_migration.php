<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrayersTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prayers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prayer_title');
            $table->text('prayer_body');
            $table->string('prayer_type');
            $table->integer('user_id')->unsigned();

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
        Schema::drop('prayers');
    }
}
