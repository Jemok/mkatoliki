<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionMpesaConfirmationsTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_mpesa_confirmations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trasnsaction_id');
            $table->string('return_code');
            $table->text('description');
            $table->string('merchant_transaction_id');
            $table->integer('subscription_id')->unsigned()->integer();

            $table->foreign('subscription_id')
                    ->references('id')
                    ->on('subscriptions');
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
        Schema::drop('subscription_mpesa_confirmations');
    }
}
