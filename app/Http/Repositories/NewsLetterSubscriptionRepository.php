<?php

namespace App\Http\Repositories;

use App\Models\Setting\NewsLetterSubscription;
use Illuminate\Support\Facades\DB;

class NewsLetterSubscriptionRepository
{

    public function __construct()
    {
        $this->newsLetterSubscription = new NewsLetterSubscription();
    }

    /**
     * @param array $select
     * @param string $orderBy
     * @param string $orderByType
     * @param bool $is_paginate
     * @param int $paginate
     * @return mixed
     */
    public function findALl(array $select = ['*'], string $orderBy = 'id', string $orderByType = 'desc', bool $is_paginate = true, int $paginate = 20): mixed
    {
        $_newsLetterSubscription = $this->newsLetterSubscription->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_newsLetterSubscription->paginate($paginate);
        }
        return $_newsLetterSubscription->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->newsLetterSubscription->create($data)->fresh();
        });
    }

    /**
     * @param $newsLetterSubscription
     * @param $data
     * @return mixed
     */
    public function update($newsLetterSubscription, $data): mixed
    {
        return DB::transaction(static function () use ($newsLetterSubscription, $data) {
            return $newsLetterSubscription->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->newsLetterSubscription->findOrFail($id);
    }

    /**
     * @param NewsLetterSubscription $newsLetterSubscription
     * @return mixed
     */
    public function delete(NewsLetterSubscription $newsLetterSubscription): mixed
    {
        return DB::transaction(static function () use ($newsLetterSubscription) {
            return $newsLetterSubscription->delete();
        });
    }
}
