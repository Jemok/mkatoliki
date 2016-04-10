<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Reading;
use Dingo\Api\Routing\Helpers;

class ReadingController extends Controller
{
    use Helpers;
    /**
     * Display a listing of the reading resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Reading::all()
                       ->toArray();
    }

    /**
     * Store a newly created reading resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reading = new Reading;

        $reading->reading_date    = $request->get('reading_date');
        $reading->reading_day    = $request->get('reading_date');

        $reading->first_reading_title    = $request->get('first_reading_title');
        $reading->first_reading_book    = $request->get('first_reading_book');
        $reading->first_reading_body    = $request->get('first_reading_body');

        $reading->second_reading_title   = $request->get('second_reading_title');
        $reading->second_reading_book   = $request->get('second_reading_book');
        $reading->second_reading_body   = $request->get('second_reading_body');

        $reading->responsorial_title     = $request->get('responsorial_title');
        $reading->responsorial_book     = $request->get('responsorial_book');
        $reading->responsorial_body_one     = $request->get('responsorial_body_one');
        $reading->responsorial_body_two     = $request->get('responsorial_body_two');
        $reading->responsorial_body_one_verse = $request->get('responsorial_body_one_verse');

        $reading->gospel_title           = $request->get('gospel_title');
        $reading->gospel_book           = $request->get('gospel_book');
        $reading->gospel_body           = $request->get('gospel_body');

        if($this->currentUser()->readings()->save($reading))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_reading', 500);
    }

    /**
     * Display the specified reading resource.
     * @param $id
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */

    public function show($id)
    {
        $reading = Reading::find($id);

        if(!$reading)
            throw new NotFoundHttpException;

        return $reading;
    }


    /**
     * Update the specified reading resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */

    public function update(Request $request, $id)
    {
        $reading = $this->currentUser()->readings()->find($id);

        if(!$reading)
            throw new NotFoundHttpException;

        $reading->fill($request->all());

        if($reading->save())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_update_reading', 500);
    }

    /**
     * Remove the specified reading resource from storage.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */

    public function destroy($id)
    {
        $reading = $this->currentUser()->readings()->find($id);

        if(!$reading)
            throw new NotFoundHttpException;

        if($reading->delete())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_delete_reading', 500);
    }

    /**
     * Grab the authenticated from the JWT token
     * @return mixed
     */
    public function currentUser(){
        return JWTAuth::parseToken()->authenticate();
    }
}
