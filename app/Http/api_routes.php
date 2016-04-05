<?php
	
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    /**------
     *
     * Authentication api routes
     *
     *
     *
     */

    $api->group(['middleware' => 'cors'], function ($api) {
        $api->post('auth/login', 'App\Api\V1\Controllers\AuthController@login');
        $api->post('auth/signup', 'App\Api\V1\Controllers\AuthController@signup');
        $api->post('auth/recovery', 'App\Api\V1\Controllers\AuthController@recovery');
        $api->post('auth/reset', 'App\Api\V1\Controllers\AuthController@reset');
    });



	// example of protected route
	$api->get('protected', ['middleware' => ['api.auth'], function () {		
		return \App\User::all();
    }]);

	// example of free route
	$api->get('free', function() {
		return \App\User::all();
	});

    /**------
     *
     * Readings api routes
     *
     *
     *
     */
    $api->group(['middleware' => ['api.auth', 'cors']], function ($api) {
        $api->post('readings', 'App\Api\V1\Controllers\ReadingController@store');
        $api->get('readings', 'App\Api\V1\Controllers\ReadingController@index');
        $api->get('readings/{id}', 'App\Api\V1\Controllers\ReadingController@show');
        $api->put('readings/{id}', 'App\Api\V1\Controllers\ReadingController@update');
        $api->delete('readings/{id}', 'App\Api\V1\Controllers\ReadingController@destroy');
    });

    /**------
     *
     * Prayers api routes
     *
     *
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){
       $api->post('prayers', 'App\Api\V1\Controllers\PrayerController@store');
       $api->get('prayers', 'App\Api\V1\Controllers\PrayerController@index');
       $api->get('prayers/{id}', 'App\Api\V1\Controllers\PrayerController@show');
       $api->put('prayers/{id}', 'App\Api\V1\Controllers\PrayerController@update');
       $api->delete('prayers/{id}', 'App\Api\V1\Controllers\PrayerController@destroy');
    });

    /**------
     *
     * Jumuiyas api routes
     *
     *
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){
        $api->post('jumuiyas', 'App\Api\V1\Controllers\JumuiyaController@store');
        $api->get('jumuiyas', 'App\Api\V1\Controllers\JumuiyaController@index');
        $api->get('jumuiyas/{id}', 'App\Api\V1\Controllers\JumuiyaController@show');
        $api->put('jumuiyas/{id}', 'App\Api\V1\Controllers\JumuiyaController@update');
        $api->delete('jumuiyas/{id}', 'App\Api\V1\Controllers\JumuiyaController@destroy');
    });

    /**------
     *
     * Reflections api routes
     *
     *
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){
        $api->post('reflections', 'App\Api\V1\Controllers\ReflectionController@store');
        $api->get('reflections', 'App\Api\V1\Controllers\ReflectionController@index');
        $api->get('reflections/{id}', 'App\Api\V1\Controllers\ReflectionController@show');
        $api->put('reflections/{id}', 'App\Api\V1\Controllers\ReflectionController@update');
        $api->delete('reflections/{id}', 'App\Api\V1\Controllers\ReflectionController@destroy');
    });

    /**------
     *
     * Happening Events api routes
     *
     *
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){
        $api->post('happenings', 'App\Api\V1\Controllers\HappeningController@store');
        $api->get('happenings', 'App\Api\V1\Controllers\HappeningController@index');
        $api->get('happenings/{id}', 'App\Api\V1\Controllers\HappeningController@show');
        $api->put('happenings/{id}', 'App\Api\V1\Controllers\HappeningController@update');
        $api->delete('happenings/{id}', 'App\Api\V1\Controllers\HappeningController@destroy');
    });

    /**------
     *
     * All new resources single api route
     *
     *
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){

        $api->get('new-data/{client_date}', 'App\Api\V1\Controllers\NewDataController@index');

    });


});
