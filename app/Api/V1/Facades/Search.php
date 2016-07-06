<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/6/16
 * Time: 6:04 PM
 */

namespace App\Api\V1\Facades;


use Illuminate\Support\Facades\Facade;

class Search extends Facade {

    protected static  function getFacadeAccessor(){

        return 'search';

    }

} 