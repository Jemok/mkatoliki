<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Transformers\HappeningTransformer;
use App\Api\V1\Transformers\JumuiyaTransformer;
use App\Api\V1\Transformers\PrayerTransformer;
use App\Api\V1\Transformers\ReflectionTransformer;
use App\Happening_event;
use App\Jumuiya;
use App\Reflection;
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

   public function __construct(ReadingTransformer $readingTransformer,
                               PrayerTransformer $prayerTransformer,
                               JumuiyaTransformer $jumuiyaTransformer,
                               ReflectionTransformer $reflectionTransformer,
                               HappeningTransformer $happeningTransformer

    ){

       $this->readingTransformer = $readingTransformer;

       $this->prayerTransformer = $prayerTransformer;

       $this->jumuiyaTransformer = $jumuiyaTransformer;

       $this->reflectionTransformer = $reflectionTransformer;

       $this->happeningTransformer = $happeningTransformer;
   }

   public function index($client_date){

        return $this->respond([

            'readings' => $this->readingTransformer->transformCollection($this->getNewReadings($client_date)),
            'prayers'  => $this->prayerTransformer->transformCollection($this->getNewPrayers($client_date)),
            'jumuiya'  => $this->jumuiyaTransformer->transformCollection($this->getNewJumuiya($client_date)),
            'reflections' =>  $this->reflectionTransformer->transformCollection($this->getNewReflections($client_date)),
            'happenings'  => $this->happeningTransformer->transformCollection($this->getNewHappenings($client_date))
        ]);

   }

   public function getNewReadings($date){

       return Reading::where('updated_at', '<', $date)->get()->toArray();

   }

   public function getNewPrayers($date){

        return Reflection::where('updated_at', '<', $date)->get()->toArray();

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

    public function respond($data, $headers = [])
    {
        return Response::json($data, '200', $headers);
    }
}
