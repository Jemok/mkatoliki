<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/1/16
 * Time: 10:23 AM
 */

namespace App\Api\V1\Feedback\Repositories;
use App\Api\V1\Feedback\Models\Feedback;

class FeedbackRepository {

    /**
     * Feedback Model
     * @var
     */
    protected $model;

    /**
     * @param Feedback $feedback
     */
    public function __construct(Feedback $feedback){
        $this->model = $feedback;
    }

    /**
     * Store a feedback
     * @param $request
     * @return mixed
     */
    public function store($request){
       return \Auth::user()->feedbacks()->create([
            $request->all()
        ]);
    }
} 