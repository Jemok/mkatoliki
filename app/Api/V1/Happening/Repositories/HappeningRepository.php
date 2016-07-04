<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/4/16
 * Time: 11:08 AM
 */

namespace App\Api\V1\Happening\Repositories;
use App\Api\V1\Happening\Models\Happening_event;
use App\Api\V1\Station\Models\Station;


class HappeningRepository {

    /**
     * The Happening_event model
     * @var
     */
    protected $model;

    /**
     * Objects Initializer
     * @param Happening_event $happening_event
     */
    public function __construct(Happening_event $happening_event){
        $this->model = $happening_event;
    }

    /**
     * Store a happening_event to the database
     * @param $request
     */
    public function store($request){

        return \Auth::user()->happenings()->create([

            'event_title' => $request->event_title,
            'event_body'  => $request->event_body,
            'event_excerpt' => $request->event_excerpt,
            'event_date'    => $request->event_date,
            'location'      => $request->event_location,
            'station_id'    => Station::where('user_id', \Auth::user()->id)->first()->id

        ]);

    }

} 