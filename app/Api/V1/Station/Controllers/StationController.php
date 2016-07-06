<?php

namespace App\Api\V1\Station\Controllers;

use App\Api\V1\Facades\Search;
use App\Api\V1\Search\ValidateSearch;
use App\Api\V1\Station\Transformers\StationTransformer;
use Illuminate\Http\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use App\Api\V1\Station\Models\Station;
use App\Api\V1\Parish\Models\Parish;

class StationController extends Controller
{
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

    public function search(Request $request, StationTransformer $stationTransformer, ValidateSearch $validateSearch){

            if($validateSearch->validateSearch($request->all())){

                $stations = Search::stations($request->get('query'));

                if(!$stations){
                    return response()->json(['message'=> 'no matching station found'], 404);
                }

                return $stationTransformer->transformCollection($stations);

            }


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
}
