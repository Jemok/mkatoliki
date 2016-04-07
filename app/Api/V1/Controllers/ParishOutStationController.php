<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Transformers\ParishTransformer;
use App\Api\V1\Transformers\StationTransformer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Parish;
use App\Station;


class ParishOutStationController extends Controller
{
    protected  $parishTransformer;

    protected $stationTransformer;

    public function __construct(ParishTransformer $parishTransformer, StationTransformer $stationTransformer){

        $this->parishTransformer = $parishTransformer;

        $this->stationTransformer = $stationTransformer;
    }



    public function index(){

            return $this->respond([

                'data' => [
                    'parishes'       =>  $this->parishTransformer->transformCollection($this->getAllParishes()),
                    'out-stations'       =>  $this->stationTransformer->transformCollection($this->getAllStations()),
                ]
            ]);
    }

    public function getAllParishes(){

        return Parish::all()->toArray();

    }

    public function getAllStations(){

        return Station::all()->toArray();

    }



    public function respond($data, $headers = [])
    {
        return Response::json($data, '200', $headers);
    }

}
