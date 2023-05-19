<?php

namespace App\Http\Controllers\api\front;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Services\RiderStoryServices;
use App\Http\Services\TestimonialServices;
use Illuminate\Http\JsonResponse;
use Throwable;

class StoryController extends Controller
{
    public function __construct()
    {
        $this->testimonialServices = new TestimonialServices();
        $this->riderStoryServices = new RiderStoryServices();
    }

    public function getRiderStoryList(): JsonResponse
    {
        try {
            $_riderStory = $this->riderStoryServices->getRiderStoryList();
            return Helper::successResponseAPI('Success', $_riderStory);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function riderStoryDetails($id): JsonResponse
    {
        try {
            $_riderStory = $this->riderStoryServices->getRiderStoryDetails($id);
            return Helper::successResponseAPI('Success', $_riderStory);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }


    public function getTestimonialList(): JsonResponse
    {
        try {
            $_riderStory = $this->testimonialServices->getTestimonialList();
            return Helper::successResponseAPI('Success', $_riderStory);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }


}
