<?php

namespace App\Api\V1\Jumuiya\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use App\Api\V1\Jumuiya\Models\Jumuiya;

class JumuiyaController extends Controller
{
    /**
     * Display a listing of the jumuiya resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Jumuiya::all()
            ->toArray();
    }

    /**
     * Store a newly created jumuiya resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jumuiya = new Jumuiya;

        $jumuiya->location = $request->get('location');
        $jumuiya->happening_on = $request->get('happening_on');
        $jumuiya->raw_jumuiya_id = $request->get('raw_jumuiya_id');
        $jumuiya->more_details = $request->get('more_details');
       // $jumuiya->mass  = $request->get('mass');

        if($this->currentUser()->jumuiyas()->save($jumuiya))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_jumuiya', 500);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function show($id)
    {
        $jumuiya = $this->currentUser()->jumuiyas()->find($id);

        if(!$jumuiya)
            throw new NotFoundHttpException;
        return $jumuiya;
    }


    /**
     * Update the specified jumuiya resource in storage.
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws NotFoundHttpException
     */
    public function update(Request $request, $id)
    {
        $jumuiya = $this->currentUser()->jumuiyas()->find($id);

        if(!$jumuiya)
            throw new NotFoundHttpException;

        $jumuiya->fill($request->all());

        if($jumuiya->save())
            return $this->response->noContent();
        else
            return $this->response->error('Could_not_update_jumuiya', 500);
    }

    /**
     * Remove the specified jumuiya resource from storage.
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws NotFoundHttpException
     */
    public function destroy($id)
    {
        $jumuiya = $this->currentUser()->jumuiyas()->find($id);

        if(!$jumuiya)
            throw new NotFoundHttpException;

        if($jumuiya->delete())
            return $this->response->noContent();
        else
            return $this->response->error('Could_not_delete_jumuiya', 500);
    }
}
