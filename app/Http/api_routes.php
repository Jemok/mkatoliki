
<?php

//All the api endpoints are defined here
	
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    /**-------------------------------------------------------------------------------------------------
     *
     * Authentication, user, logout, account recovery api routes
     *
     */

    //NB:: Use the cors middleware to allow for cross-origin resource sharing when hitting these routes
    // These routes do not require an authentication
    $api->group(['middleware' => 'cors'], function ($api) {

        /**----------------------------------------------------------------------------------------------
         * Account Login routes
         */
        // Login in a user from the web using an email field
        $api->post('auth/login',       'App\Api\V1\Auth\Controllers\AuthController@loginDefault');
        // Login in a user from a mobile phone using a phone_number field
        $api->post('auth/login-phone', 'App\Api\V1\Auth\Controllers\AuthControllerPhone@loginPhone');

        /**----------------------------------------------------------------------------------------------
         * Signup route
         */

        // Registering an admin from either a mobile app client or the web client
        $api->post('auth/signup-mkatoliki-admin', 'App\Api\V1\Auth\Controllers\AuthController@signup');

        // Registering a paeish admin from either a mobile app client or the web client
        $api->post('auth/signup-parish-admin',  'App\Api\V1\Auth\Controllers\AuthController@signup');

        // Registering an outstation admin from either a mobile app client or the web client
        $api->post('auth/signup-outstation-admin', 'App\Api\V1\Auth\Controllers\AuthController@signup');

        // Registering a priest from either a mobile app client or the web client
        $api->post('auth/signup-priest', 'App\Api\V1\Auth\Controllers\AuthController@signup');

        // Registering an app user from either a mobile app client or the web client
        $api->post('auth/signup', 'App\Api\V1\Auth\Controllers\AuthController@signup');

        /**----------------------------------------------------------------------------------------------
         * Account recovery and reset routes
         */
        $api->post('auth/recovery',  'App\Api\V1\Auth\Controllers\AuthController@recovery');
        $api->post('auth/reset',  'App\Api\V1\Auth\Controllers\AuthController@reset');
    });

    // These routes handle user activities
    // Requires an authentication token
    $api->group(['middleware' => ['api.auth', 'cors']], function ($api) {
        /**----------------------------------------------------------------------------------------------
         * Start login out a user, must provide an access token
         * Logout route
         */
        // Start the logout process
        // Requires authentication
        // Requires the token to be invalidated as a parameter
        $api->post('auth/logout', 'App\Api\V1\Auth\Controllers\AuthControllerPhone@logout');

        /**----------------------------------------------------------------------------------------------
         * User routes
         */
        // Gets the details of the authenticated user
        $api->get('auth/user', 'App\Api\V1\Auth\Controllers\AuthController@getAuthenticatedUser');

        // Set the parish and outstation of a user
        $api->post('auth/user/parish-station', 'App\Api\V1\Auth\Controllers\AuthControllerPhone@setParishAndStation');
    });

    /**--------------------------------------------------------------------------------------------------
     *
     * GCM phone token routes
     *
     */
    $api->group(['middleware' => ['api.auth', 'cors']], function ($api) {

        $api->post('gcm/tokens', 'App\Api\V1\GCM\Controllers\PhoneTokenController@store');
        $api->post('gcm/push-types', 'App\Api\V1\GCM\Controllers\GcmPushTypeController@store');
    });

    /**-------------------------------------------------------------------------------------------------
     *
     * Readings api routes
     *
     */
    $api->group(['middleware' => ['api.auth', 'cors']], function ($api) {
        $api->get('readings', 'App\Api\V1\Reading\Controllers\ReadingController@index');
        $api->get('readings/all', 'App\Api\V1\Reading\Controllers\ReadingController@indexForReflections');
        $api->post('readings', 'App\Api\V1\Reading\Controllers\ReadingController@store');
        $api->get('readings/{id}', 'App\Api\V1\Reading\Controllers\ReadingController@show');
        $api->put('readings/{id}', 'App\Api\V1\Reading\Controllers\ReadingController@update');
        $api->delete('readings/{id}', 'App\Api\V1\Reading\Controllers\ReadingController@destroy');
    });

    /**-------------------------------------------------------------------------------------------------
     *
     * Prayers api routes
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){
       $api->post('prayers', 'App\Api\V1\Prayer\Controllers\PrayerController@store');
       $api->get('prayers', 'App\Api\V1\Prayer\Controllers\PrayerController@index');
       $api->get('prayers/{id}', 'App\Api\V1\Prayer\Controllers\PrayerController@show');
       $api->put('prayers/{id}', 'App\Api\V1\Prayer\Controllers\PrayerController@update');
       $api->delete('prayers/{id}', 'App\Api\V1\Prayer\Controllers\PrayerController@destroy');
    });

    /**--------------------------------------------------------------------------------------------------
     *
     * Jumuiyas api routes
     *
     *
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){
        $api->post('jumuiyas', 'App\Api\V1\Jumuiya\Controllers\JumuiyaController@store');
        $api->get('jumuiyas', 'App\Api\V1\Jumuiya\Controllers\JumuiyaController@index');
        $api->get('jumuiyas/{id}', 'App\Api\V1\Jumuiya\Controllers\JumuiyaController@show');
        $api->put('jumuiyas/{id}', 'App\Api\V1\Jumuiya\Controllers\JumuiyaController@update');
        $api->delete('jumuiyas/{id}', 'App\Api\V1\Jumuiya\Controllers\JumuiyaController@destroy');
    });

    /**---------------------------------------------------------------------------------------------------
     *
     * Reflections api routes
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){
        $api->get('reflections', 'App\Api\V1\Reflection\Controllers\ReflectionController@index');
        $api->post('reflections', 'App\Api\V1\Reflection\Controllers\ReflectionController@store');
        $api->get('reflections/{id}', 'App\Api\V1\Reflection\Controllers\ReflectionController@show');
        $api->put('reflections/{id}', 'App\Api\V1\Reflection\Controllers\ReflectionController@update');
        $api->delete('reflections/{id}', 'App\Api\V1\Reflection\Controllers\ReflectionController@destroy');
    });

    /**---------------------------------------------------------------------------------------------------
     *
     * Happening Events api routes
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){
        $api->post('happenings', 'App\Api\V1\Happening\Controllers\HappeningController@store');
        $api->get('happenings', 'App\Api\V1\Happening\Controllers\HappeningController@index');
        $api->get('happenings/{id}', 'App\Api\V1\Happening\Controllers\HappeningController@show');
        $api->put('happenings/{id}', 'App\Api\V1\Happening\Controllers\HappeningController@update');
        $api->delete('happenings/{id}', 'App\Api\V1\Happening\Controllers\HappeningController@destroy');
    });

    /**---------------------------------------------------------------------------------------------------
     *
     * Parish api routes
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){
        $api->post('parishes', 'App\Api\V1\Parish\Controllers\ParishController@store');
        $api->get('parishes', 'App\Api\V1\Parish\Controllers\ParishController@index');
        $api->get('parishes/{id}', 'App\Api\V1\Parish\Controllers\ParishController@show');
        $api->put('parishes/{id}', 'App\Api\V1\Parish\Controllers\ParishController@update');
        $api->delete('parishes/{id}', 'App\Api\V1\Parish\Controllers\ParishController@destroy');
    });

    /**------------------------------------------------------------------------------------------------------
     *
     * Station api routes
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){
        $api->post('stations', 'App\Api\V1\Station\Controllers\StationController@store');
        $api->get('stations', 'App\Api\V1\Station\Controllers\StationController@index');
        $api->get('stations/{id}', 'App\Api\V1\Station\Controllers\StationController@show');
        $api->put('stations/{id}', 'App\Api\V1\Station\Controllers\StationController@update');
        $api->delete('stations/{id}', 'App\Api\V1\Station\Controllers\StationController@destroy');
    });

    /**--------------------------------------------------------------------------------------------------------
     *
     * Raw Jumuiya api routes
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){
        $api->post('raw-jumuiyas', 'App\Api\V1\Raw_Jumuiya\Controllers\RawJumuiyaController@store');
        $api->get('raw-jumuiyas', 'App\Api\V1\Raw_Jumuiya\Controllers\RawJumuiyaController@index');
        $api->get('raw-jumuiyas/{id}', 'App\Api\V1\Raw_Jumuiya\Controllers\RawJumuiyaController@show');
        $api->put('raw-jumuiyas/{id}', 'App\Api\V1\Raw_Jumuiya\Controllers\RawJumuiyaController@update');
        $api->delete('raw-jumuiyas/{id}', 'App\Api\V1\Raw_Jumuiya\Controllers\RawJumuiyaController@destroy');
    });

    /**-------------------------------------------------------------------------------------------------------
     *
     * Prayer Type api routes
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){
        $api->post('prayer-type', 'App\Api\V1\Prayer_Type\Controllers\PrayerTypeController@store');
        $api->get('prayer-type', 'App\Api\V1\Prayer_Type\Controllers\PrayerTypeController@index');
        $api->get('raw-jumuiyas/{id}', 'App\Api\V1\Prayer_Type\Controllers\RawJumuiyaController@show');
        $api->put('raw-jumuiyas/{id}', 'App\Api\V1\Prayer_Type\Controllers\RawJumuiyaController@update');
        $api->delete('raw-jumuiyas/{id}', 'App\Api\V1\Prayer_Type\Controllers\RawJumuiyaController@destroy');
    });

    /**-------------------------------------------------------------------------------------------------------
     *
     * Feedback api routes
     *
     */
    $api->group(['middleware' => ['api.auth', 'cors']], function($api){
        $api->post('feedbacks', 'App\Api\V1\Feedback\Controllers\FeedbackController@store');
    });

    /**--------------------------------------------------------------------------------------------------------
     *
     * Parish cum Out-stations route
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){

        $api->get('parishes-outstations', 'App\Api\V1\Parish\Controllers\ParishOutStationController@index');

    });

    /**-------------------------------------------------------------------------------------------------------
     *
     * All new resources single api route
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){

        $api->get('new-data/{client_date}', 'App\Api\V1\Data\Controllers\NewDataController@index');

    });


    /**-------------------------------------------------------------------------------------------------------
     *
     * Subscription api routes
     *
     */

    $api->group(['middleware' => ['api.auth', 'cors']], function($api){

        $api->post('subscribe', 'App\Api\V1\Subscription\Controllers\SubscriptionCategoryController@subscribe');


        $api->get('subscriptions', 'App\Api\V1\Subscription\Controllers\SubscriptionCategoryController@getSubscriptions');


        $api->post('unsubscribe', 'App\Api\V1\Subscription\Controllers\SubscriptionCategoryController@unSubscribe');

        /**----------------------------------------------------------------------------------------------------
         * Subscription Categories
         */

        $api->post('subscriptions/categories', 'App\Api\V1\Subscription\Controllers\SubscriptionCategoryController@store');

        /**----------------------------------------------------------------------------------------------------
         * Subscription Status
         */

        $api->post('subscriptions/status', 'App\Api\V1\Subscription\Controllers\SubscriptionStatusController@store');

        /**----------------------------------------------------------------------------------------------------
         * Subscription
         */

        $api->post('subscriptions', 'App\Api\V1\Subscription\Controllers\SubscriptionController@store');

        $api->post('subscriptions/mpesa/query', 'App\Api\V1\Subscription\Controllers\SubscriptionController@queryMpesa');

        $api->post('subscriptions/mpesa/confirm', 'App\Api\V1\Subscription\Controllers\SubscriptionController@confirmTransaction');

        $api->post('subscriptions/mpesa/check', 'App\Api\V1\Subscription\Controllers\SubscriptionController@finishTransaction');

        $api->post('subscriptions/mpesa/cancel', 'App\Api\V1\Subscription\Controllers\SubscriptionController@cancelSubscription');

    });

    $api->post('subscriptions/mpesa/callback', 'App\Api\V1\Subscription\Controllers\SubscriptionController@saveMpesaResults');



});
