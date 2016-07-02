<?php

namespace App\Api\V1\Feedback\Controllers;

use App\Api\V1\Feedback\Repositories\FeedbackRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Api\V1\Feedback\Validators\ValidateFeedback;

class FeedbackController extends Controller
{
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
}
