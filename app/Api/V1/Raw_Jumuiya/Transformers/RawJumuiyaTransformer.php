<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/6/16
 * Time: 11:59 AM
 */

namespace App\Api\V1\Raw_Jumuiya\Transformers;
use App\Api\V1\Raw_Jumuiya\Models\Raw_jumuiya;
use App\Api\V1\Transformers\Transformer;


class RawJumuiyaTransformer extends Transformer {

    public function transform($raw_jumuiya)
    {
        return [
            'id'       => $raw_jumuiya['id'],
            'jumuiya_name' => $raw_jumuiya['jumuiya_name'],
            'jumuiya_image_link'  => $raw_jumuiya['jumuiya_image_link']
        ];
    }
} 