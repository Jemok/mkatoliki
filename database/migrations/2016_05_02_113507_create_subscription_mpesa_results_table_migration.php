<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionMpesaResultsTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_mpesa_results', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone_number');
            $table->double('transaction_amount');
            $table->dateTime('transaction_date');
            $table->string('mpesa_transaction_id');
            $table->string('transaction_status');
            $table->string('return_code');
            $table->text('description');
            $table->string('transaction_id');
            $table->integer('mpesa_confirmation_id')->unsigned()->index();
            $table->integer('subscription_id')->unsigned()->index();


            $table->foreign('mpesa_confirmation_id')
                    ->references('id')
                    ->on('subscription_mpesa_confirmations');

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
        Schema::drop('subscription_mpesa_results');
    }
}
