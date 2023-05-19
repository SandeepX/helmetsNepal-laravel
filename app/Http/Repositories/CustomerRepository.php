<?php

namespace App\Http\Repositories;

use App\Models\Customer\Customer;
use Illuminate\Support\Facades\DB;

class CustomerRepository
{
    public function __construct()
    {
        $this->customer = new Customer();
    }

    /**
     * @param array $select
     * @param string $orderBy
     * @param string $orderByType
     * @param bool $is_paginate
     * @param int $paginate
     * @return mixed
     */
    public function findALl($user_type): mixed
    {
        return $this->customer->where('user_type', $user_type)->orderBy('id', 'desc')->paginate(10);
    }


    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->customer->create($data)->fresh();
        });
    }

    /**
     * @param $customer
     * @param $data
     * @return mixed
     */
    public function update($customer, $data): mixed
    {
        return DB::transaction(static function () use ($customer, $data) {
            return $customer->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->customer->findOrFail($id);
    }

    /**
     * @param Customer $customer
     * @return mixed
     */
    public function delete(Customer $customer): mixed
    {
        return DB::transaction(static function () use ($customer) {
            return $customer->delete();
        });
    }


    public function getCustomerByEmail($email)
    {
        return $this->customer->where('email', '=', $email)->first();
    }

    public function getCustomerBySocialId($social_id)
    {
        return $this->customer->where('social_id', '=', $social_id)->first();
    }

    public function getCustomerByFBId($fb_id)
    {
        return $this->customer->where('fb_id', '=', $fb_id)->first();
    }
}
