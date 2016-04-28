<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/28/16
 * Time: 10:52 AM
 */

namespace App\Api\V1\Repositories;
use App\Phone_token;
use Illuminate\Http\Request;


class PhoneTokenRepository {

    /**
     * The Phone_token model
     * @var \App\Phone_token
     */
    protected $model;

    /**
     * This class phone objects initializer
     * @param Phone_token $phone_token
     */
    public function __construct(Phone_token $phone_token){

        $this->model = $phone_token;
    }

    /**
     * Persist a phone token to the apps db
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