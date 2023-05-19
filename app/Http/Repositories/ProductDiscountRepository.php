<?php

namespace App\Http\Repositories;


use App\Http\Enums\EStatus;
use App\Models\Product\ProductDiscount;
use Illuminate\Support\Facades\DB;

class ProductDiscountRepository
{

    public function __construct()
    {
        $this->productDiscount = new ProductDiscount();
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
        $_productDiscount = $this->productDiscount->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_productDiscount->paginate($paginate);
        }
        return $_productDiscount->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->productDiscount->create($data)->fresh();
        });
    }

    /**
     * @param $productDiscount
     * @param $data
     * @return mixed
     */
    public function update($productDiscount, $data): mixed
    {
        return DB::transaction(static function () use ($productDiscount, $data) {
            return $productDiscount->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->productDiscount->findOrFail($id);
    }

    public function productDiscountList($product_id)
    {
        return $this->productDiscount->where('product_id', $product_id)->where('status', EStatus::active->value)->get();
    }

    /**
     * @param ProductDiscount $productDiscount
     * @return mixed
     */
    public function delete(ProductDiscount $productDiscount): mixed
    {
        return DB::transaction(static function () use ($productDiscount) {
            return $productDiscount->delete();
        });
    }
}
