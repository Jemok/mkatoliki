<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGcmPushesMigrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcm_pushes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message_id');
            $table->integer('gcm_push_type_id')->unsigned()->index();
            $table->string('multicast_id')->nullable();
            $table->integer('success')->nullable();
            $table->integer('failure')->nullable();
            $table->string('conical_ids')->nullable();
            $table->foreign('gcm_push_type_id')
                  ->references('id')
                  ->on('gcm_push_types');
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
        Schema::drop('gcm_pushes');
    }
}
