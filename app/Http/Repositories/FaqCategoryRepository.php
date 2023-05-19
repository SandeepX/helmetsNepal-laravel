<?php

namespace App\Http\Repositories;

use App\Models\Faq\FaqCategory;
use Illuminate\Support\Facades\DB;

class FaqCategoryRepository
{

    private FaqCategory $faqCategory;

    public function __construct()
    {
        $this->faqCategory = new FaqCategory();
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
        $_faqCategory = $this->faqCategory->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_faqCategory->paginate($paginate);
        }
        return $_faqCategory->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->faqCategory->create($data)->fresh();
        });
    }

    /**
     * @param $faqCategory
     * @param $data
     * @return mixed
     */
    public function update($faqCategory, $data): mixed
    {
        return DB::transaction(static function () use ($faqCategory, $data) {
            return $faqCategory->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->faqCategory->findOrFail($id);
    }

    /**
     * @param FaqCategory $faqCategory
     * @return mixed
     */
    public function delete(FaqCategory $faqCategory): mixed
    {
        return DB::transaction(static function () use ($faqCategory) {
            return $faqCategory->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->faqCategory->where('status', 'active')->pluck('name', 'id');
    }

    public function getActiveList(): mixed
    {
        return $this->faqCategory->where('status', 'active')->get();
    }


}
