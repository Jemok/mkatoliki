<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 5/1/16
 * Time: 5:08 PM
 */

namespace App\Api\V1\GCM\Controllers;


use App\Api\V1\GCM\Models\GcmPushType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;

class GcmPushTypeController extends Controller {

    use Helpers;

    /**
     * Handle storing of a new gcm push type to db
     * @param Request $request
     * @return \Dingo\Api\Http\Response|void
     */
    public function store(Request $request){

        $gcm_push_type = new GcmPushType;

        $gcm_push_type->type_name = $request->get('type_name');
        $gcm_push_type->type_code = $request->get('type_code');

        if($this->currentUser()->gcm_push_types()->save($gcm_push_type))
            return $this->response->created();
        else
            return $this->response->error('Could_not_create_gcm_push_type', 500);
    }

} 