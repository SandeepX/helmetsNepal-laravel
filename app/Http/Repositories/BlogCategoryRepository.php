<?php

namespace App\Http\Repositories;

use App\Models\Blog\BlogCategory;
use Illuminate\Support\Facades\DB;

class BlogCategoryRepository
{

    private BlogCategory $blogCategory;

    public function __construct()
    {
        $this->blogCategory = new BlogCategory();
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
        $_blogCategory = $this->blogCategory->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_blogCategory->paginate($paginate);
        }
        return $_blogCategory->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->blogCategory->create($data)->fresh();
        });
    }

    /**
     * @param $blogCategory
     * @param $data
     * @return mixed
     */
    public function update($blogCategory, $data): mixed
    {
        return DB::transaction(static function () use ($blogCategory, $data) {
            return $blogCategory->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->blogCategory->findOrFail($id);
    }

    /**
     * @param BlogCategory $blogCategory
     * @return mixed
     */
    public function delete(BlogCategory $blogCategory): mixed
    {
        return DB::transaction(static function () use ($blogCategory) {
            return $blogCategory->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->blogCategory->where('status', 'active')->pluck('name', 'id');
    }

    public function getActiveList(): mixed
    {
        return $this->blogCategory->where('status', 'active')->get();
    }

}
