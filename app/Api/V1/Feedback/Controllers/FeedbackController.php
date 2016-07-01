<?php

namespace App\Api\V1\Feedback\Controllers;

use App\Api\V1\Feedback\Repositories\FeedbackRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Api\V1\Feedback\Validators\ValidateFeedback;
use Illuminate\Support\Facades\Response;

class FeedbackController extends Controller
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
     * Store a newly created resource in storage.
     * @param Request $request
     * @param ValidateFeedback $validateFeedback
     * @param FeedbackRepository $feedbackRepository
     * @return \Dingo\Api\Http\Response|void
     */
    public function store(Request $request, ValidateFeedback $validateFeedback, FeedbackRepository $feedbackRepository)
    {
        $validateFeedback->validateFeedback($request->all());

        if($feedbackRepository->store($request))
            return response()->json(['Feedback successfully created'], 201);
        return $this->response->error('could not create feedback', 500);
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
