<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Reflection;
use Dingo\Api\Routing\Helpers;

class ReflectionController extends Controller
{

    use Helpers;
    /**
     * Display a listing of the reflection resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Reflection::all()
            ->toArray();
    }


    /**
     * Store a newly created reflection resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reflection = new Reflection;

        $reflection->reflection_body = $request->get('reflection_body');
        $reflection->reflaction_date = $request->get('reflection_date');

        if($this->currentUser()->reflections()->save($reflection))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_jumuiya', 500);
    }

    /**
     * Display the specified reflection resource.
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function show($id)
    {
        $reflection = $this->currentUser()->reflections()->find($id);

        if(!$reflection)
            throw new NotFoundHttpException;
        return $reflection;
    }


    /**
     * Update the specified reflection resource in storage.
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws NotFoundHttpException
     */
    public function update(Request $request, $id)
    {
        $reflection = $this->currentUser()->reflections()->find($id);

        if(!$reflection)
            throw new NotFoundHttpException;

        $reflection->fill($request->all());

        if($reflection->save())
            return $this->response->noContent();
        else
            return $this->response->error('Could_not_update_jumuiya', 500);
    }

    /**
     * Remove the specified reflection resource from storage.
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws NotFoundHttpException
     */
    public function destroy($id)
    {
        $reflection = $this->currentUser()->reflections()->find($id);

        if(!$reflection)
            throw new NotFoundHttpException;

        if($reflection->delete())
            return $this->response->noContent();
        else
            return $this->response->error('Could_not_delete_jumuiya', 500);
    }

    /**
     * Returns the currently logged in user
     * @return mixed
     */
    public function currentUser(){

        return JWTAuth::parseToken()->authenticate();
    }
}
