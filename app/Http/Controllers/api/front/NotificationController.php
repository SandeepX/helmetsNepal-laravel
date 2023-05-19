<?php

namespace App\Http\Controllers\api\front;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Services\NotificationServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->notificationServices = new NotificationServices();
    }

    public function getNotification(Request $request): JsonResponse
    {
        try {
            return $this->notificationServices->getNotificationList($request);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function deleteNotification(Request $request): JsonResponse
    {
        try {
            return $this->notificationServices->deleteNotification($request);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function clearNotification(Request $request): ?JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->notificationServices->clearNotification($request);
            DB::commit();
            return Helper::successResponseAPI('Notification has been cleared');
        } catch (Throwable $t) {
            DB::rollBack();
            return Helper::errorResponseAPI($t->getMessage());
        }
    }
}
