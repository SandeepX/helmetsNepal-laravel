<?php

namespace App\Http\Repositories;

use App\Http\Enums\EStatus;
use App\Models\Faq\Faq;
use Illuminate\Support\Facades\DB;

class FaqRepository
{

    private Faq $faq;

    public function __construct()
    {
        $this->faq = new Faq();
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
        $_faq = $this->faq->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_faq->paginate($paginate);
        }
        return $_faq->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->faq->create($data)->fresh();
        });
    }

    /**
     * @param $faq
     * @param $data
     * @return mixed
     */
    public function update($faq, $data): mixed
    {
        return DB::transaction(static function () use ($faq, $data) {
            return $faq->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->faq->findOrFail($id);
    }

    /**
     * @param Faq $faq
     * @return mixed
     */
    public function delete(Faq $faq): mixed
    {
        return DB::transaction(static function () use ($faq) {
            return $faq->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->faq->where('status', EStatus::active->value)->pluck('name', 'id');
    }

    public function getRelatedFaqByCategoryID($faq_category_id): mixed
    {
        return $this->faq->where('faq_category_id', $faq_category_id)->where('status', EStatus::active->value)->get();
    }


}
