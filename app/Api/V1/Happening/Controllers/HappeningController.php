<?php

namespace App\Api\V1\Happening\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Controllers\Controller;
use App\Api\V1\Happening\Models\Happening_event;
use Dingo\Api\Routing\Helpers;

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
        $happening->event_date = $request->get('event_date');

        if($this->currentUser()->happenings()->save($happening))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_happening', 500);
    }

    /**
     * Get a single happening event resource
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function show($id)
    {
        $happening = $this->currentUser()->happenings()->find($id);

        if(!$happening){
            throw new NotFoundHttpException;
        }
        return $happening;
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
        $happening = $this->currentUser()->happenings()->find($id);

        if(!$happening)
            throw new NotFoundHttpException;

        $happening->fill($request->all());

        if($happening->save())
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
        $happening = $this->currentUser()->happenings()->find($id);

        if(!$happening)
            throw new NotFoundHttpException;

        if($happening->delete())
            return $this->response->noContent();
        else
            return $this->response->error('Could_not_delete_happening', 500);
    }
}
