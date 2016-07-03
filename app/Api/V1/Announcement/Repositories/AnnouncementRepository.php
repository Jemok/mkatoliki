<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/3/16
 * Time: 8:15 AM
 */

namespace App\Api\V1\Announcement\Repositories;
use App\Api\V1\Announcement\Models\Announcement;
use App\Api\V1\Station\Models\Station;


class AnnouncementRepository {

    /**
     * The Announcement model
     * @var
     */
    protected $model;

    /**
     * Objects Instantiation
     * @param Announcement $announcement
     */
    public function __construct(Announcement $announcement){
        $this->model = $announcement;
    }

    /**
     * Store an announcement
     * @param $request
     * @return mixed
     */
    public function store($request){

        return \Auth::user()->announcements()->create([
           'title' => $request->title,
           'announcement' => $request->announcement,
           'date'         => $request->date,
           'station_id' => Station::where('user_id', \Auth::user()->id)->first()->id
        ]);
    }
} 