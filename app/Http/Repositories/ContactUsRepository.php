<?php

namespace App\Http\Repositories;

use App\Models\Setting\ContactUs;
use Illuminate\Support\Facades\DB;

class ContactUsRepository
{

    public function __construct()
    {
        $this->contactUs = new ContactUs();
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
        $_contactUs = $this->contactUs->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_contactUs->paginate($paginate);
        }
        return $_contactUs->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->contactUs->create($data)->fresh();
        });
    }

    /**
     * @param $contactUs
     * @param $data
     * @return mixed
     */
    public function update($contactUs, $data): mixed
    {
        return DB::transaction(static function () use ($contactUs, $data) {
            return $contactUs->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->contactUs->findOrFail($id);
    }

    /**
     * @param ContactUs $contactUs
     * @return mixed
     */
    public function delete(ContactUs $contactUs): mixed
    {
        return DB::transaction(static function () use ($contactUs) {
            return $contactUs->delete();
        });
    }

}
