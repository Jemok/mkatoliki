<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/6/16
 * Time: 6:12 PM
 */

namespace App\Api\V1\Search;


use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider  {

    public function register(){

        $this->app->bind('search', Search::class);
    }
} 