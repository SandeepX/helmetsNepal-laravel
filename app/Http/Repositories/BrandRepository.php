<?php

namespace App\Http\Repositories;

use App\Models\Product\Brand;
use Illuminate\Support\Facades\DB;

class BrandRepository
{

    public function __construct()
    {
        $this->brand = new Brand();
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
        $_brand = $this->brand->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_brand->paginate($paginate);
        }
        return $_brand->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->brand->create($data)->fresh();
        });
    }

    /**
     * @param $brand
     * @param $data
     * @return mixed
     */
    public function update($brand, $data): mixed
    {
        return DB::transaction(static function () use ($brand, $data) {
            return $brand->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->brand->findOrFail($id);
    }

    /**
     * @param Brand $brand
     * @return mixed
     */
    public function delete(Brand $brand): mixed
    {
        return DB::transaction(static function () use ($brand) {
            return $brand->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->brand->where('status', 'active')->pluck('title', 'id');
    }





    public function getActiveList($select = ['*']): mixed
    {
        return $this->brand->select($select)->where('status', 'active')->orderBy('title','asc')->get();
    }

    public function getDistinctActiveList($ids): mixed
    {
        return $this->brand->whereIn('id', $ids)->where('status', 'active')->orderBy('title','asc')->get();
    }
}
