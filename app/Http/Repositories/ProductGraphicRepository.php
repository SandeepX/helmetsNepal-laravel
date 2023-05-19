<?php

namespace App\Http\Repositories;


use App\Models\Product\ProductGraphic;
use Illuminate\Support\Facades\DB;

class ProductGraphicRepository
{

    public function __construct()
    {
        $this->productGraphic = new ProductGraphic();
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
        $_productGraphic = $this->productGraphic->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_productGraphic->paginate($paginate);
        }
        return $_productGraphic->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->productGraphic->create($data)->fresh();
        });
    }

    /**
     * @param $productGraphic
     * @param $data
     * @return mixed
     */
    public function update($productGraphic, $data): mixed
    {
        return DB::transaction(static function () use ($productGraphic, $data) {
            return $productGraphic->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->productGraphic->findOrFail($id);
    }

    /**
     * @param ProductGraphic $productGraphic
     * @return mixed
     */
    public function delete(ProductGraphic $productGraphic): mixed
    {
        return DB::transaction(static function () use ($productGraphic) {
            return $productGraphic->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->productGraphic->where('status', 'active')->pluck('name', 'id');
    }

    public function getActiveList(): mixed
    {
        return $this->productGraphic->where('status', 'active')->orderBy('name','asc')->get();
    }
}
