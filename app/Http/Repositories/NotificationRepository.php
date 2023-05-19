<?php

namespace App\Http\Repositories;

use App\Models\Notification\Notification;
use Illuminate\Support\Facades\DB;

class NotificationRepository
{

    public function __construct()
    {
        $this->notification = new Notification();
    }

    /**
     * @param array $select
     * @param string $orderBy
     * @param string $orderByType
     * @param bool $is_paginate
     * @param int $paginate
     * @return mixed
     */
    public function findALl(array $select = ['*'], string $orderBy = 'id', string $orderByType = 'desc', bool $is_paginate = true, int $paginate = 10): mixed
    {
        $_notification = $this->notification->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_notification->paginate($paginate);
        }
        return $_notification->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->notification->create($data)->fresh();
        });
    }

    /**
     * @param $notification
     * @param $data
     * @return mixed
     */
    public function update($notification, $data): mixed
    {
        return DB::transaction(static function () use ($notification, $data) {
            return $notification->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->notification->findOrFail($id);
    }

    public function getNotificationByCustomerList($customer_id)
    {
        return $this->notification->where('customer_id', $customer_id)->orderBy('id', 'desc')->get();
    }

    public function deleteNotification($customer_id)
    {
        return $this->notification->where('customer_id', $customer_id)->delete();
    }

    /**
     * @param Notification $notification
     * @return mixed
     */
    public function delete(Notification $notification): mixed
    {
        return DB::transaction(static function () use ($notification) {
            return $notification->delete();
        });
    }

    public function getNotificationByCustomer($customer_id, $per_page)
    {
        return $this->notification->where('customer_id', $customer_id)->orderBy('id', 'desc')->paginate($per_page);
    }

    public function findNotificationByCustomer($customer_id, $notification_id)
    {
        return $this->notification->where('customer_id', $customer_id)->where('id', $notification_id)->first();
    }

}
