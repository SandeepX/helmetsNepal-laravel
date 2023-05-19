<?php

namespace App\Http\Repositories;

use App\Models\Order\DeliveryCharge;
use Illuminate\Support\Facades\DB;

class DeliveryChargeRepository
{

    public function __construct()
    {
        $this->deliveryCharge = new DeliveryCharge();
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
        $_deliveryCharge = $this->deliveryCharge->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_deliveryCharge->paginate($paginate);
        }
        return $_deliveryCharge->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->deliveryCharge->create($data)->fresh();
        });
    }

    /**
     * @param $deliveryCharge
     * @param $data
     * @return mixed
     */
    public function update($deliveryCharge, $data): mixed
    {
        return DB::transaction(static function () use ($deliveryCharge, $data) {
            return $deliveryCharge->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->deliveryCharge->findOrFail($id);
    }

    /**
     * @param DeliveryCharge $deliveryCharge
     * @return mixed
     */
    public function delete(DeliveryCharge $deliveryCharge): mixed
    {
        return DB::transaction(static function () use ($deliveryCharge) {
            return $deliveryCharge->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->deliveryCharge->where('status', 'active')->pluck('name', 'id');
    }
}
