<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dingo\Api\Routing\Helpers;
use App\Station;
use App\Parish;

class StationController extends Controller
{
    use Helpers;
    /**
     * Display a listing of the station resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Station::all()
            ->toArray();
    }


    /**
     * Store a newly created station resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $station = new Station;

        $station->station_name = $request->get('station_name');
        $station->parish_id    = $request->get('parish_id');

        if($this->currentUser()->stations()->save($station))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_station', 500);
    }

    /**
     * Display the specified station resource.
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function show($id)
    {
        $station = $this->currentUser()->stations()->find($id);

        if(!$station)
            throw new NotFoundHttpException;
        return $station;
    }


    /**
     * Update the specified station resource in storage.
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws NotFoundHttpException
     */
    public function update(Request $request, $id)
    {
        $station = $this->currentUser()->stations()->find($id);

        if(!$station)
            throw new NotFoundHttpException;

        $station->fill($request->all());

        if($station->save())
            return $this->response->noContent();
        else
            return $this->response->error('Could_not_update_station', 500);
    }

    /**
     * Remove the specified station resource from storage.
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws NotFoundHttpException
     */
    public function destroy($id)
    {
        $station = $this->currentUser()->stations()->find($id);

        if(!$station)
            throw new NotFoundHttpException;

        if($station->delete())
            return $this->response->noContent();
        else
            return $this->response->error('Could_not_delete_station', 500);
    }

    /**
     * Returns the currently logged in user
     * @return mixed
     */
    public function currentUser(){

        return JWTAuth::parseToken()->authenticate();
    }

    public function store_parish(Request $request)
    {
        $parish = new Parish;

        $parish->parish_name = $request->get('parish_name');

        if($this->currentUser()->parishes()->save($parish))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_parish', 500);
    }
}
