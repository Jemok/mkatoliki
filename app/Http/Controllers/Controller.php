<?php

namespace App\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Tymon\JWTAuth\Facades\JWTAuth;


abstract class Controller extends BaseController
{
    /**
     * The dingo API package routing helper
     */
    use Helpers;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Returns the currently logged in user
     * @return mixed
     */
    public function currentUser(){

        return JWTAuth::parseToken()->authenticate();
    }
}
