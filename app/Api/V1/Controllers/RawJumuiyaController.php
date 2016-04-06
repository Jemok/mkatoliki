<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Raw_jumuiya;
use Dingo\Api\Routing\Helpers;

class RawJumuiyaController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the raw_jumuiya resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Raw_jumuiya::all()
            ->toArray();
    }


    /**
     * Store a newly created raw_jumuiya resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $raw_jumuiya = new Raw_jumuiya;

        $raw_jumuiya->jumuiya_name = $request->get('jumuiya_name');
        $raw_jumuiya->jumuiya_image_link = $request->get('jumuiya_image_link');

        if($this->currentUser()->raw_jumuiya()->save($raw_jumuiya))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_raw_jumuiya', 500);
    }

    /**
     * Display the specified raw_jumuiya resource.
     * @param $id
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function show($id)
    {
        $raw_jumuiya = $this->currentUser()->raw_jumuiya()->find($id);

        if(!$raw_jumuiya)
            throw new NotFoundHttpException;
        return $raw_jumuiya;
    }


    /**
     * Update the specified raw_jumuiya resource in storage.
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function update(Request $request, $id)
    {
        $raw_jumuiya = $this->currentUser()->raw_jumuiya()->find($id);

        if(!$raw_jumuiya)
            throw new NotFoundHttpException;

        $raw_jumuiya->fill($request->all());

        if($raw_jumuiya->save())
            return $this->response->noContent();
        else
            return $this->response->error('Could_not_update_raw_jumuiya', 500);
    }

    /**
     * Remove the specified raw_jumuiya resource from storage.
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function destroy($id)
    {
        $raw_jumuiya = $this->currentUser()->raw_jumuiya()->find($id);

        if(!$raw_jumuiya)
            throw new NotFoundHttpException;

        if($raw_jumuiya->delete())
            return $this->response->noContent();
        else
            return $this->response->error('Could_not_delete_raw_jumuiya', 500);

    }

    /**
     * Returns the currently logged in user
     * @return mixed
     */
    public function currentUser(){

        return JWTAuth::parseToken()->authenticate();
    }
}
