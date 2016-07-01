<?php

namespace App\Api\V1\Prayer_Type\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use App\Api\V1\Prayer_Type\Models\Prayer_types;

class PrayerTypeController extends Controller
{
    /**
     * Display a listing of the prayer_type resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Prayer_types::all()
            ->toArray();
    }


    /**
     * Store a newly created prayer resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prayer_type = new Prayer_types;

        $prayer_type->prayer_type_name = $request->get('prayer_type_name');
        $prayer_type->prayer_type_description = $request->get('prayer_type_description');

        if($this->currentUser()->prayer_types()->save($prayer_type))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_prayer_type', 500);
    }

    /**
     * Display the specified prayer resource.
     * @param $id
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function show($id)
    {
        $prayer = $this->currentUser()->prayers()->find($id);

        if(!$prayer)
            throw new NotFoundHttpException;
        return $prayer;
    }


    /**
     * Update the specified prayer resource in storage.
     * @param Request $request
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function update(Request $request, $id)
    {
        $prayer = $this->currentUser()->prayers()->find($id);

        if(!$prayer)
            throw new NotFoundHttpException;

        $prayer->fill($request->all());

        if($prayer->save())
            return $this->response->noContent();
        else
            return $this->response->error('Could_not_update_prayer', 500);
    }

    /**
     * Remove the specified prayer resource from storage.
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function destroy($id)
    {
        $prayer = $this->currentUser()->prayers()->find($id);

        if(!$prayer)
            throw new NotFoundHttpException;

        if($prayer->delete())
            return $this->response->noContent();
        else
            return $this->response->error('Could_not_delete_prayer', 500);
    }
}
