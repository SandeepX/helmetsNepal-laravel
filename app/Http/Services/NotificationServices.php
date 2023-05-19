<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Repositories\NotificationRepository;
use App\Http\Resources\NotificationResources;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\ArrayShape;

class NotificationServices
{
    private string $notFoundMessage = "Sorry! Notification not found";


    public function __construct()
    {
        $this->notificationRepository = new NotificationRepository();
    }

    public function getList(): mixed
    {
        return $this->notificationRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function getNotification($notification_id): mixed
    {
        $_notification = $this->notificationRepository->find($notification_id);
        if ($_notification) {
            return $_notification;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_notification = $this->notificationRepository->find($user_id);
        if ($_notification) {
            $this->notificationRepository->update($_notification, ['is_read_status' => !$_notification->is_read_status]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function getNotificationList($request)
    {

        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            $customer_id = $_customer->id;
            $per_page = 10;
            if ($request->has('per_page')) {
                $per_page = $request->per_page;
            }
            $_notification = $this->notificationRepository->getNotificationByCustomer($customer_id, $per_page);
            $page_details = $_notification->toArray();
            unset($page_details['data']);
            return Helper::successResponseAPI('Success', ['page_details' => $page_details, 'notification' => NotificationResources::collection($_notification)]);
        }
        throw new SMException("Must login");
    }

    /**
     * @throws SMException
     */
    public function clearNotification($request)
    {
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            $customer_id = $_customer->id;
            return $this->notificationRepository->deleteNotification($customer_id);
        }
        throw new SMException("Must login");
    }

    /**
     * @throws SMException
     */
    public function deleteNotification($request)
    {
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            $customer_id = $_customer->id;
            $notification_id = $request->notification_id;
            $notification = $this->notificationRepository->findNotificationByCustomer($customer_id, $notification_id);
            if ($notification) {
                $this->notificationRepository->delete($notification);
                return Helper::successResponseAPI('Notification has been deleted');
            }
            throw new SMException("Notification not found");
        }
        throw new SMException("Must login");
    }


}
