<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Reading;
use Dingo\Api\Routing\Helpers;

class ReadingController extends Controller
{
    use Helpers;
    /**
     * Display a listing of the reading resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Reading::all()
                       ->toArray();
    }

    /**
     * Store a newly created reading resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reading = new Reading;

        $reading->first_reading    = $request->get('first_reading');
        $reading->second_reading   = $request->get('second_reading');
        $reading->responsorial     = $request->get('responsorial');
        $reading->gospel           = $request->get('gospel');
        $reading->mass_day           = $request->get('mass_day');


        if($this->currentUser()->readings()->save($reading))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_reading', 500);
    }

    /**
     * Display the specified reading resource.
     * @param $id
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */

    public function show($id)
    {
        $reading = $this->currentUser()->readings()->find($id);

        if(!$reading)
            throw new NotFoundHttpException;

        return $reading;
    }


    /**
     * Update the specified reading resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */

    public function update(Request $request, $id)
    {
        $reading = $this->currentUser()->readings()->find($id);

        if(!$reading)
            throw new NotFoundHttpException;

        $reading->fill($request->all());

        if($reading->save())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_update_reading', 500);
    }

    /**
     * Remove the specified reading resource from storage.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */

    public function destroy($id)
    {
        $reading = $this->currentUser()->readings()->find($id);

        if(!$reading)
            throw new NotFoundHttpException;

        if($reading->delete())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_delete_reading', 500);
    }

    /**
     * Grab the authenticated from the JWT token
     * @return mixed
     */
    public function currentUser(){
        return JWTAuth::parseToken()->authenticate();
    }
}
