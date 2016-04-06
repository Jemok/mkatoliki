<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Transformers\HappeningTransformer;
use App\Api\V1\Transformers\JumuiyaTransformer;
use App\Api\V1\Transformers\ParishTransformer;
use App\Api\V1\Transformers\PrayerTransformer;
use App\Api\V1\Transformers\RawJumuiyaTransformer;
use App\Api\V1\Transformers\ReflectionTransformer;
use App\Api\V1\Transformers\StationTransformer;
use App\Happening_event;
use App\Jumuiya;
use App\Parish;
use App\Prayer;
use App\Raw_jumuiya;
use App\Reflection;
use App\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Api\V1\Transformers\ReadingTransformer;
use App\Reading;

class NewDataController extends Controller
{
    /**
     * @var \App\Api\V1\Transformers\ReadingTransformer
     */
    protected  $readingTransformer;

    protected $prayerTransformer;

    protected $jumuiyaTransformer;

    protected $reflectionTransformer;

    protected $happeningTransformer;

    protected $rawJumuiyaTransformer;

    protected $parishesTransformer;

    protected $stationTransformer;

   public function __construct(ReadingTransformer $readingTransformer,
                               PrayerTransformer $prayerTransformer,
                               JumuiyaTransformer $jumuiyaTransformer,
                               ReflectionTransformer $reflectionTransformer,
                               HappeningTransformer $happeningTransformer,
                               RawJumuiyaTransformer $rawJumuiyaTransformer,
                               ParishTransformer $parishTransformer,
                               StationTransformer $stationTransformer


    ){

       $this->readingTransformer = $readingTransformer;

       $this->prayerTransformer = $prayerTransformer;

       $this->jumuiyaTransformer = $jumuiyaTransformer;

       $this->reflectionTransformer = $reflectionTransformer;

       $this->happeningTransformer = $happeningTransformer;

       $this->rawJumuiyaTransformer = $rawJumuiyaTransformer;

       $this->parishesTransformer = $parishTransformer;

       $this->stationTransformer = $stationTransformer;
   }

   public function index($client_date){

        return $this->respond([

            'data' => [

            'readings' => $this->readingTransformer->transformCollection($this->getNewReadings($client_date)),
            'prayers'  => $this->prayerTransformer->transformCollection($this->getNewPrayers($client_date)),
            'reflections' =>  $this->reflectionTransformer->transformCollection($this->getNewReflections($client_date)),
            'happenings'  => $this->happeningTransformer->transformCollection($this->getNewHappenings($client_date)),
            'raw_jumuiyas'  => $this->rawJumuiyaTransformer->transformCollection($this->getNewRawJumuiyas($client_date)),
            'jumuiya_events'  => $this->jumuiyaTransformer->transformCollection($this->getNewJumuiya($client_date)),
            'parishes'       =>  $this->parishesTransformer->transformCollection($this->getNewParishes($client_date)),
             'out-stations'       =>  $this->stationTransformer->transformCollection($this->getNewStations($client_date)),





            ]
        ]);

   }

   public function getNewReadings($date){

       return Reading::where('updated_at', '<', $date)->get()->toArray();

   }

   public function getNewPrayers($date){

        return Prayer::where('updated_at', '<', $date)->get()->toArray();

   }

   public function getNewJumuiya($date){

        return Jumuiya::where('updated_at', '<', $date)->get()->toArray();

   }

   public function getNewReflections($date){

        return Reflection::where('updated_at', '<', $date)->get()->toArray();

   }

   public function getNewHappenings($date){

        return Happening_event::where('updated_at', '<', $date)->get()->toArray();

   }

    public function getNewRawJumuiyas($date){

        return Raw_jumuiya::where('updated_at', '<', $date)->get()->toArray();

    }

    public function getNewParishes($date){

        return Parish::where('updated_at', '<', $date)->get()->toArray();

    }

    public function getNewStations($date){

        return Station::where('updated_at', '<', $date)->get()->toArray();

    }

    public function respond($data, $headers = [])
    {
        return Response::json($data, '200', $headers);
    }
}
