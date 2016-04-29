<?php

namespace App\Api\V1\Prayer\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Api\V1\Prayer\Models\Prayer;
use Dingo\Api\Routing\Helpers;

class PrayerController extends Controller
{

    use Helpers;
    /**
     * Display a listing of the prayer resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Prayer::all()
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
        $prayer = new Prayer;

        $prayer->prayer_title = $request->get('prayer_title');
        $prayer->prayer_body = $request->get('prayer_body');
        $prayer->prayer_type_id = $request->get('prayer_type');

        if($this->currentUser()->prayers()->save($prayer))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_prayer', 500);
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
