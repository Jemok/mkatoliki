<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Parish;
use Dingo\Api\Routing\Helpers;

class ParishController extends Controller
{
    /**
     * Display a listing of the parish resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Parish::all()
            ->toArray();
    }


    /**
     * Store a newly created parish resource in storage.
     * @param Request $request
     * @return mixed
     */



    /**
     * Display the specified parish resource.
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function show($id)
    {
        $parish = $this->currentUser()->parishes()->find($id);

        if(!$parish)
            throw new NotFoundHttpException;
        return $parish;
    }


    /**
     * Update the specified parish resource in storage.
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws NotFoundHttpException
     */
    public function update(Request $request, $id)
    {
        $parish = $this->currentUser()->parishes()->find($id);

        if(!$parish)
            throw new NotFoundHttpException;

        $parish->fill($request->all());

        if($parish->save())
            return $this->response->noContent();
        else
            return $this->response->error('Could_not_update_parish', 500);
    }

    /**
     * Remove the specified parish resource from storage.
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws NotFoundHttpException
     */
    public function destroy($id)
    {
        $parish = $this->currentUser()->parishes()->find($id);

        if(!$parish)
            throw new NotFoundHttpException;

        if($parish->delete())
            return $this->response->noContent();
        else
            return $this->response->error('Could_not_delete_parish', 500);
    }

    /**
     * Returns the currently logged in user
     * @return mixed
     */
    public function currentUser(){

        return JWTAuth::parseToken()->authenticate();
    }
}
