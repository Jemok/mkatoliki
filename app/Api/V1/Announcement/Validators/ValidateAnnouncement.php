<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/3/16
 * Time: 8:16 AM
 */

namespace App\Api\V1\Announcement\Validators;


use App\Api\V1\Validator\ApiValidator;
use Validator;

class ValidateAnnouncement extends ApiValidator {

    /**
     * Validate the incoming announcement data
     * @param $announcementData
     * @return mixed
     */
    public function validateAnnouncement($announcementData){

        $validator = Validator::make($announcementData, [

            'title' => 'required',
            'announcement' => 'required',
            'date'         => 'required|date'
        ]);

        return $this->validate($validator);
    }

} 