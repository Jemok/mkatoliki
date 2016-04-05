<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/4/16
 * Time: 11:30 PM
 */

namespace App\Api\V1\Transformers;


abstract class Transformer {

    public function transformCollection(array $items){

        return array_map([$this,'transform'], $items);

    }

    abstract public function transform($item);

} 