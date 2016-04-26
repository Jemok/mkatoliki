<?php
	
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    /**------
     *
     * Authentication, user, logout, recovery api routes
     *
     *
     *
     */

    $api->group(['middleware' => 'cors'], function ($api) {

        /**
         * Login routes
         */
        $api->post('auth/login', 'App\Api\V1\Controllers\AuthController@loginDefault');
        $api->post('auth/login-phone/', 'App\Api\V1\Controllers\AuthControllerPhone@loginPhone');

        /**
         * Signup route
         */

        $api->post('auth/signup', 'App\Api\V1\Controllers\AuthController@signup');

        /**
         * Account recovery routes
         */
        $api->post('auth/recovery', 'App\Api\V1\Controllers\AuthController@recovery');
        $api->post('auth/reset', 'App\Api\V1\Controllers\AuthController@reset');

        /**
         * Logut route
         */
        $api->get('auth/logout', 'App\Api\V1\Controllers\AuthControllerPhone@logout');

        /**
         * User routes
         */
        $api->get('auth/user', 'App\Api\V1\Controllers\AuthController@getAuthenticatedUser');
        $api->post('auth/user/parish-station', 'App\Api\V1\Controllers\AuthControllerPhone@setParishAndStation');

    });

    /**------
     *
     * Readings api routes
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
     * Parish api routes
     *
     *
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){
        $api->post('parishes', 'App\Api\V1\Controllers\StationController@store_parish');
        $api->get('parishes', 'App\Api\V1\Controllers\ParishController@index');
        $api->get('parishes/{id}', 'App\Api\V1\Controllers\ParishController@show');
        $api->put('parishes/{id}', 'App\Api\V1\Controllers\ParishController@update');
        $api->delete('parishes/{id}', 'App\Api\V1\Controllers\ParishController@destroy');
    });

    /**------
     *
     * Station api routes
     *
     *
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){
        $api->post('stations', 'App\Api\V1\Controllers\StationController@store');
        $api->get('stations', 'App\Api\V1\Controllers\StationController@index');
        $api->get('stations/{id}', 'App\Api\V1\Controllers\StationController@show');
        $api->put('stations/{id}', 'App\Api\V1\Controllers\StationController@update');
        $api->delete('stations/{id}', 'App\Api\V1\Controllers\StationController@destroy');
    });

    /**------
     *
     * Raw Jumuiya api routes
     *
     *
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){
        $api->post('raw-jumuiyas', 'App\Api\V1\Controllers\RawJumuiyaController@store');
        $api->get('raw-jumuiyas', 'App\Api\V1\Controllers\RawJumuiyaController@index');
        $api->get('raw-jumuiyas/{id}', 'App\Api\V1\Controllers\RawJumuiyaController@show');
        $api->put('raw-jumuiyas/{id}', 'App\Api\V1\Controllers\RawJumuiyaController@update');
        $api->delete('raw-jumuiyas/{id}', 'App\Api\V1\Controllers\RawJumuiyaController@destroy');
    });

    /**------
     *
     * Prayer Type api routes
     *
     *
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){
        $api->post('prayer-type', 'App\Api\V1\Controllers\PrayerTypeController@store');
        $api->get('prayer-type', 'App\Api\V1\Controllers\PrayerTypeController@index');
        $api->get('raw-jumuiyas/{id}', 'App\Api\V1\Controllers\RawJumuiyaController@show');
        $api->put('raw-jumuiyas/{id}', 'App\Api\V1\Controllers\RawJumuiyaController@update');
        $api->delete('raw-jumuiyas/{id}', 'App\Api\V1\Controllers\RawJumuiyaController@destroy');
    });

    /**------
     *
     * Parish cum Out-stations route
     *
     *
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){

        $api->get('parishes-outstations', 'App\Api\V1\Controllers\ParishOutStationController@index');

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
