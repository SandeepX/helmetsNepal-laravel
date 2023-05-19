<?php

namespace App\Http\Controllers\api\front;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Services\NewsLetterSubscriptionServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class NewsLetterSubscriptionController extends Controller
{
    public function __construct()
    {
        $this->newsLetterSubscriptionServices = new NewsLetterSubscriptionServices();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveNewsLetterSubscription(Request $request)
    {
        try {
            return $this->newsLetterSubscriptionServices->saveNewsLetterSubscription($request);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }
}
