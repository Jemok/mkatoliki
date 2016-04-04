<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Happening_event;
use Dingo\Api\Routing\Helpers;
use Tymon\JWTAuth\Facades\JWTAuth;

class HappeningController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the Happening resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Happening_event::all()
            ->toArray();
    }


    /**
     * Store a newly created happening resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $happening = new Happening_event;

        $happening->event_title = $request->get('event_title');
        $happening->event_body = $request->get('event_body');
        $happening->event_excerpt = $request->get('event_excerpt');


        if($this->currentUser()->happenings()->save($happening))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_happening', 500);
    }

    /**
     * Get a single happening resource from storage
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function show($id)
    {
        $jumuiya = $this->currentUser()->happenings()->find($id);

        if(!$jumuiya)
            throw new NotFoundHttpException;
        return $jumuiya;
    }


    /**
     * Update the specified happening resource in storage.
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws NotFoundHttpException
     */
    public function update(Request $request, $id)
    {
        $jumuiya = $this->currentUser()->happenings()->find($id);

        if(!$jumuiya)
            throw new NotFoundHttpException;

        $jumuiya->fill($request->all());

        if($jumuiya->save())
            return $this->response->noContent();
        else
            return $this->response->error('Could_not_update_happening', 500);
    }

    /**
     * Remove the specified happening resource from storage.
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws NotFoundHttpException
     */
    public function destroy($id)
    {
        $jumuiya = $this->currentUser()->happenings()->find($id);

        if(!$jumuiya)
            throw new NotFoundHttpException;

        if($jumuiya->delete())
            return $this->response->noContent();
        else
            return $this->response->error('Could_not_delete_happening', 500);
    }

    /**
     * Returns the currently logged in user
     * @return mixed
     */
    public function currentUser(){

        return JWTAuth::parseToken()->authenticate();
    }

}
