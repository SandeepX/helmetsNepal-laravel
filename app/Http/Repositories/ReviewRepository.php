<?php

namespace App\Http\Repositories;


use App\Models\Review\Review;
use Illuminate\Support\Facades\DB;

class ReviewRepository
{

    public function __construct()
    {
        $this->review = new Review();
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
        $_review = $this->review->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_review->paginate($paginate);
        }
        return $_review->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->review->create($data)->fresh();
        });
    }

    /**
     * @param $review
     * @param $data
     * @return mixed
     */
    public function update($review, $data): mixed
    {
        return DB::transaction(static function () use ($review, $data) {
            return $review->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->review->findOrFail($id);
    }

    /**
     * @param Review $review
     * @return mixed
     */
    public function delete(Review $review): mixed
    {
        return DB::transaction(static function () use ($review) {
            return $review->delete();
        });
    }

    public function getPublishedReviewList(): mixed
    {
        return $this->review->where('publish_status', 1)->get();
    }

    public function getPublishedReviewListByProductID($product_id)
    {
        return $this->review->where('publish_status', 1)->where('product_id', $product_id);
    }
}
