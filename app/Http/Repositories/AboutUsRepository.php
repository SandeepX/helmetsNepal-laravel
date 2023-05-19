<?php

namespace App\Http\Repositories;

use App\Models\AboutUS\AboutUs;
use Illuminate\Support\Facades\DB;

class AboutUsRepository
{

    public function __construct()
    {
        $this->aboutUs = new AboutUs();
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
        $_aboutUs = $this->aboutUs->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_aboutUs->paginate($paginate);
        }
        return $_aboutUs->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->aboutUs->create($data)->fresh();
        });
    }

    /**
     * @param $aboutUs
     * @param $data
     * @return mixed
     */
    public function update($aboutUs, $data): mixed
    {
        return DB::transaction(static function () use ($aboutUs, $data) {
            return $aboutUs->update($data);
        });
    }

    /**
     * @return mixed
     */
    public function find(): mixed
    {
        return $this->aboutUs->find(1);
    }

    /**
     * @param AboutUs $aboutUs
     * @return mixed
     */
    public function delete(AboutUs $aboutUs): mixed
    {
        return DB::transaction(static function () use ($aboutUs) {
            return $aboutUs->delete();
        });
    }
}
