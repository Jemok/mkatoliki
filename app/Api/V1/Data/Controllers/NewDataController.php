<?php

namespace App\Api\V1\Data\Controllers;

use App\Api\V1\Announcement\Models\Announcement;
use App\Api\V1\Happening\Transformers\HappeningTransformer;
use App\Api\V1\Jumuiya\Transformers\JumuiyaTransformer;
use App\Api\V1\Parish\Transformers\ParishTransformer;
use App\Api\V1\Prayer\Transformers\PrayerTransformer;
use App\Api\V1\Prayer_Type\Transformers\PrayerTypeTransformer;
use App\Api\V1\Raw_Jumuiya\Transformers\RawJumuiyaTransformer;
use App\Api\V1\Reflection\Transformers\ReflectionTransformer;
use App\Api\V1\Station\Transformers\StationTransformer;
use App\Api\V1\Reading\Transformers\ReadingTransformer;
use App\Api\V1\Subscription\Transformers\SubscriptionTransformer;
use App\Api\V1\Announcement\Transformers\AnnouncementTransformer;
use App\Api\V1\Happening\Models\Happening_event;
use App\Api\V1\Jumuiya\Models\Jumuiya;
use App\Api\V1\Account\Models\User;
use App\Api\V1\Parish\Models\Parish;
use App\Api\V1\Prayer\Models\Prayer;
use App\Api\V1\Raw_Jumuiya\Models\Raw_jumuiya;
use App\Api\V1\Reflection\Models\Reflection;
use App\Api\V1\Station\Models\Station;
use App\Api\V1\Reading\Models\Reading;
use App\Api\V1\Prayer_Type\Models\Prayer_types;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
    protected $prayerTypeTransformer;
    protected $userParishesTransformer;
    protected $userOutstationsTransformer;
    protected $subscriptionTransformer;
    protected $announcementTransformer;

   public function __construct(ReadingTransformer $readingTransformer,
                               PrayerTransformer $prayerTransformer,
                               JumuiyaTransformer $jumuiyaTransformer,
                               ReflectionTransformer $reflectionTransformer,
                               HappeningTransformer $happeningTransformer,
                               RawJumuiyaTransformer $rawJumuiyaTransformer,
                               ParishTransformer $parishTransformer,
                               StationTransformer $stationTransformer,
                               PrayerTypeTransformer $prayerTypeTransformer,
                               SubscriptionTransformer $subscriptionTransformer,
                               AnnouncementTransformer $announcementTransformer


    ){

       $this->readingTransformer = $readingTransformer;
       $this->prayerTransformer = $prayerTransformer;
       $this->jumuiyaTransformer = $jumuiyaTransformer;
       $this->reflectionTransformer = $reflectionTransformer;
       $this->happeningTransformer = $happeningTransformer;
       $this->rawJumuiyaTransformer = $rawJumuiyaTransformer;
       $this->parishesTransformer = $parishTransformer;
       $this->stationTransformer = $stationTransformer;
       $this->prayerTypeTransformer = $prayerTypeTransformer;
       $this->subscriptionTransformer = $subscriptionTransformer;
       $this->announcementTransformer = $announcementTransformer;
   }

   public function index($client_date){



       if($client_date == "0000-00-00 00:00:00"){

           return $this->respond([

               'data' => [
                   'readings' => $this->readingTransformer->transformCollection($this->getAllReadings()),
                   'prayers'  => $this->prayerTransformer->transformCollection($this->getAllPrayers()),
                   'reflections' =>  $this->reflectionTransformer->transformCollection($this->getAllReflections()),
                   'happenings'  => $this->happeningTransformer->transformCollection($this->getAllHappenings()),
                   'raw_jumuiyas'  => $this->rawJumuiyaTransformer->transformCollection($this->getAllRawJumuiyas()),
                   'jumuiya_events'  => $this->jumuiyaTransformer->transformCollection($this->getAllJumuiya()),
                   //'parishes'       =>  $this->parishesTransformer->transformCollection($this->getAllParishes()),
                   'user_churches'       =>  $this->stationTransformer->transformCollection($this->getAllStations()),
                   'prayer_types'     => $this->prayerTypeTransformer->transformCollection($this->getAllPrayerTypes()),
                   'subscriptions'    => $this->subscriptionTransformer->transformCollection($this->getAllSubscriptions()),
                   'announcements'    => $this->announcementTransformer->transformCollection($this->getAllAnnouncementsForUser())
               ],
               'meta' => [
                    'to_server_last_date'  => new \DateTime()
                ]
           ]);

       }else{
        return $this->respond([

            'data' => [

            'readings' => $this->readingTransformer->transformCollection($this->getNewReadings($client_date)),
            'prayers'  => $this->prayerTransformer->transformCollection($this->getNewPrayers($client_date)),
            'reflections' =>  $this->reflectionTransformer->transformCollection($this->getNewReflections($client_date)),
            'happenings'  => $this->happeningTransformer->transformCollection($this->getNewHappenings($client_date)),
            'raw_jumuiyas'  => $this->rawJumuiyaTransformer->transformCollection($this->getNewRawJumuiyas($client_date)),
            'jumuiya_events'  => $this->jumuiyaTransformer->transformCollection($this->getNewJumuiya($client_date)),
            //'parishes'       =>  $this->parishesTransformer->transformCollection($this->getNewParishes($client_date)),
            'user_churches'       =>  $this->stationTransformer->transformCollection($this->getNewStations($client_date)),
            'prayer_types'    =>   $this->prayerTypeTransformer->transformCollection($this->getNewPrayerTypes($client_date)),
            'subscriptions'   => $this->subscriptionTransformer->transformCollection($this->getNewSubscriptions($client_date)),
            'announcements'   => $this->announcementTransformer->transformCollection($this->getNewAnnouncementsForUser($client_date))
            ],
            'meta' => [
               'to_server_last_date'  => new \DateTime()
           ]
        ]);

       }

   }

   public function getNewReadings($date){

       return Reading::where('updated_at', '>', $date)->get()->toArray();

   }

    public function getNewPrayerTypes($date){

        return Prayer_types::where('updated_at', '>', $date)->get()->toArray();

    }

   public function getNewPrayers($date){

        return Prayer::where('updated_at', '>', $date)->get()->toArray();

   }

   public function getNewJumuiya($date){

        return Jumuiya::where('updated_at', '>', $date)->get()->toArray();

   }

   public function getNewReflections($date){

        return Reflection::where('updated_at', '>', $date)->get()->toArray();

   }

   public function getNewHappenings($date){

        return Happening_event::where('updated_at', '>', $date)->get()->toArray();

   }

    public function getNewRawJumuiyas($date){

        return Raw_jumuiya::where('updated_at', '>', $date)->get()->toArray();

    }

    public function getNewParishes($date){

        return Parish::where('updated_at', '>', $date)->get()->toArray();

    }

    public function getNewStations($date){

        $user_station_ids = \Auth::user()->user_stations()->get(['station_id']);

        return Station::whereIn('id', $user_station_ids)->where('updated_at', '>', $date)->get()->toArray();

    }

    public function getNewSubscriptions($date){

       // return  User::where('id', \Auth::user()->id)->where('updated_at', '>', $date)->where('id', '>', 20)->get()->toArray();

        return  User::where('id', \Auth::user()->id)->get()->toArray();
    }

    public function getNewAnnouncementsForUser($date){

        $user_station_id = \Auth::user()->user_stations()->first()->station_id;

        return Announcement::where('updated_at', '>', $date)
                            ->where('station_id', $user_station_id)
                            ->get()->toArray();
    }

    public function respond($data, $headers = [])
    {
        return Response::json($data, '200', $headers);
    }

    /************************************************************************************************/

    public function getAllReadings(){

        return Reading::all()->toArray();

    }

    public function getAllPrayerTypes(){

        return Prayer_types::all()->toArray();

    }

    public function getAllPrayers(){

        return Prayer::all()->toArray();

    }

    public function getAllJumuiya(){

        return Jumuiya::all()->toArray();

    }

    public function getAllReflections(){

        return Reflection::all()->toArray();

    }

    public function getAllHappenings(){

        return Happening_event::all()->toArray();

    }

    public function getAllRawJumuiyas(){

        return Raw_jumuiya::all()->toArray();

    }

    public function getAllParishes(){

        return Parish::all()->toArray();

    }

    public function getAllStations(){

        $user_station_ids = \Auth::user()->user_stations()->get(['station_id']);

        return Station::whereIn('id', $user_station_ids)->get()->toArray();
    }

    public function getAllAnnouncementsForUser(){

        $user_station_id = \Auth::user()->user_stations()->first()->station_id;

        return Announcement::where('station_id', $user_station_id)->get()->toArray();
    }

    public function getAllSubscriptions(){

       // return  $users =  User::where('id', '=', \Auth::user()->id)->where('id', '>', 20)->get()->toArray();

        return  $users =  User::where('id', '=', \Auth::user()->id)->get()->toArray();
    }
}
