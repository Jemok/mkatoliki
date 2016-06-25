<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Creates the users table and adds its fields structure
     * This table holds the users in the application (every type
     * of user)
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            //The unique identifier field, used as foreign key
            //in other related tables
            $table->increments('id');

            //Holds the name of the user.
            $table->string('name');

            //Holds the email of users
            //used as login field in the web application
            //also used for other notifications, its unique for every user
            $table->string('email')->unique();

            //The phone number of the user
            //used as the login field in mobile applications
            $table->string('phone_number');

            //The security password.
            $table->string('password', 60);

            //This is removed in another migration
            $table->string('phone_notification_token');

            //This is also removed in another migration
            $table->integer('parish_id')->unsigned()->nullable();

            // This is also removed in another migration
            $table->integer('station_id')->unsigned()->nullable();

            $table->rememberToken();

            // Records of created_at and updated at of the user
            $table->timestamps();
        });
    }

    /**
     * Removes the table when the migration is rolled back
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
