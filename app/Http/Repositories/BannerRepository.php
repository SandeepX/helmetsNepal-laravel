<?php

namespace App\Http\Repositories;

use App\Models\Slider\Banner;
use Illuminate\Support\Facades\DB;

class BannerRepository
{

    public function __construct()
    {
        $this->banner = new Banner();
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
        $_banner = $this->banner->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_banner->paginate($paginate);
        }
        return $_banner->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->banner->create($data)->fresh();
        });
    }

    /**
     * @param $banner
     * @param $data
     * @return mixed
     */
    public function update($banner, $data): mixed
    {
        return DB::transaction(static function () use ($banner, $data) {
            return $banner->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->banner->findOrFail($id);
    }

    /**
     * @param Banner $banner
     * @return mixed
     */
    public function delete(Banner $banner): mixed
    {
        return DB::transaction(static function () use ($banner) {
            return $banner->delete();
        });
    }

    public function getActiveList(): mixed
    {
        return $this->banner->select('title', 'sub_title', 'image', 'description' , 'link')->where('status', 'active')->orderBy('feature_status' , 'desc')->get();
    }
}
