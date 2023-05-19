<?php

namespace App\Http\Controllers\api\front;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Services\ReviewServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ReviewController extends Controller
{
    private ReviewServices $reviewServices;

    public function __construct()
    {
        $this->reviewServices = new ReviewServices();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveReview(Request $request): JsonResponse
    {
        try {
            return $this->reviewServices->saveReview($request);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }
}
