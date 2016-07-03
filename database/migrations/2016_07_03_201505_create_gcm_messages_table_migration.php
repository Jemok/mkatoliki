<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGcmMessagesTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcm_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message_id');
            $table->integer('gcm_push_id')->index()->unsigned();

            $table->foreign('gcm_push_id')
                  ->references('id')
                  ->on('gcm_pushes');

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
        Schema::drop('gcm_messages');
    }
}
