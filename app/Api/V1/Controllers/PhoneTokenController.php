<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Phone_token;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;



class PhoneTokenController extends Controller
{
    use Helpers;

    /**
     * Handle storing of a new gcm token to the database
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request){

        $phone_token = new Phone_token;

        $phone_token->token = $request->get('token');

        if($this->currentUser()->phone_token()->save($phone_token))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_prayer', 500);

    }

}
