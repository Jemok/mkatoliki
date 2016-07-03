<?php

namespace App\Api\V1\Announcement\Controllers;

use App\Api\V1\Announcement\Repositories\AnnouncementRepository;
use App\Api\V1\Announcement\Validators\ValidateAnnouncement;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AnnouncementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Persist a new announcement to the database
     * @param Request $request
     * @param ValidateAnnouncement $validateAnnouncement
     * @param AnnouncementRepository $announcementRepository
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function store(Request $request, ValidateAnnouncement $validateAnnouncement, AnnouncementRepository $announcementRepository)
    {
        $validateAnnouncement->validateAnnouncement($request->all());

        if($announcementRepository->store($request))
            return response()->json(['Announcement successfully created'], 201);
        return $this->response->error('could not create Announcement', 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
