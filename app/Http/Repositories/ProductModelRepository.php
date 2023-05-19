<?php

namespace App\Http\Repositories;


use App\Models\Product\ProductModel;
use Illuminate\Support\Facades\DB;

class ProductModelRepository
{

    public function __construct()
    {
        $this->productModel = new ProductModel();
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
        $_productModel = $this->productModel->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_productModel->paginate($paginate);
        }
        return $_productModel->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->productModel->create($data)->fresh();
        });
    }

    /**
     * @param $productModel
     * @param $data
     * @return mixed
     */
    public function update($productModel, $data): mixed
    {
        return DB::transaction(static function () use ($productModel, $data) {
            return $productModel->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->productModel->findOrFail($id);
    }

    /**
     * @param ProductModel $productModel
     * @return mixed
     */
    public function delete(ProductModel $productModel): mixed
    {
        return DB::transaction(static function () use ($productModel) {
            return $productModel->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->productModel->where('status', 'active')->pluck('name', 'id');
    }
    public function getActiveList(): mixed
    {
        return $this->productModel->where('status', 'active')->orderBy('name','asc')->get();
    }

    public function getDistinctActiveList($ids): mixed
    {
        return $this->productModel->whereIn('id', $ids)->where('status', 'active')->orderBy('name','asc')->get();
    }


}
