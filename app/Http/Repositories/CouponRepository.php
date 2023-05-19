<?php

namespace App\Http\Repositories;


use App\Models\Order\Coupon;
use Illuminate\Support\Facades\DB;

class CouponRepository
{

    public function __construct()
    {
        $this->coupon = new Coupon();
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
        $_coupon = $this->coupon->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_coupon->paginate($paginate);
        }
        return $_coupon->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->coupon->create($data)->fresh();
        });
    }

    /**
     * @param $coupon
     * @param $data
     * @return mixed
     */
    public function update($coupon, $data): mixed
    {
        return DB::transaction(static function () use ($coupon, $data) {
            return $coupon->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->coupon->findOrFail($id);
    }

    /**
     * @param Coupon $coupon
     * @return mixed
     */
    public function delete(Coupon $coupon): mixed
    {
        return DB::transaction(static function () use ($coupon) {
            return $coupon->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->coupon->where('status', 'active')->pluck('name', 'id');
    }

    public function getByCampaignCode($campaign_code): mixed
    {
        return $this->coupon->where('status', 'active')->where('campaign_code', $campaign_code)->first();
    }
}
