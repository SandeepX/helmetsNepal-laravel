<?php

namespace App\Http\Repositories;

use App\Models\Product\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepository
{

    public function __construct()
    {
        $this->category = new Category();
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
        $_category = $this->category->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_category->paginate($paginate);
        }
        return $_category->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->category->create($data);
        });
    }

    /**
     * @param $category
     * @param $data
     * @return mixed
     */
    public function update($category, $data): mixed
    {
        return DB::transaction(static function () use ($category, $data) {
            return $category->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->category->findOrFail($id);
    }

    /**
     * @param Category $category
     * @return mixed
     */
    public function delete(Category $category): mixed
    {
        return DB::transaction(static function () use ($category) {
            return $category->delete();
        });
    }

    /**
     * @return mixed
     */
    public function getSelectList(): mixed
    {
        return $this->category->where('status', 'active')->pluck('name', 'id');
    }
    public function getSelectSubCatList(): mixed
    {
        return $this->category->where('status', 'active')->where('parent_id' ,'!=', null)->pluck('name', 'id');
    }

    public function getAllActiveCategory($select): mixed
    {
        return Category::select(['id','name'])
            ->where('status', 'active')
            ->get();
    }

    public function getParentCategorySlugList(): mixed
    {
        return $this->category->where('parent_id', null)->where('status', 'active')->pluck('name', 'id');
    }

    /**
     * @param string $parent_slug
     * @return mixed
     */
    public function getChildCategory(string $parent_id): mixed
    {
        return $this->category->select('id', 'name', 'slug', 'parent_id')->where('parent_id', $parent_id)->where('status', 'active')->get()->toArray();
    }

    public function getCategoryFromSlug(string $slug): mixed
    {
        return $this->category->where('slug', $slug)->where('status', 'active')->first();
    }

    public function getChildCategorySelectList(int $parent_id): mixed
    {
        return $this->category->where('parent_id', $parent_id)->where('status', 'active')->pluck('name', 'id');
    }


    public function getActiveParentCategoryList(): mixed
    {
        return $this->category->select('id', 'name', 'slug', 'image')->where('parent_id', null)->where('status', 'active')->orderBy('name','asc')->get();
    }
    public function getActiveParentCategoryList_2(): mixed
    {
        return $this->category->select('id', 'name', 'slug', 'image')->where('parent_id', null)->where('status', 'active')->get();
    }

    public function getActiveChildCategoryList(int $parent_id): mixed
    {
        return $this->category->select('id', 'name', 'slug', 'image')->where('parent_id', $parent_id)->where('status', 'active')->orderBy('name','asc')->get();
    }
    public function getActiveChildCategoryList_2(int $parent_id): mixed
    {
        return $this->category->select('id', 'name', 'slug', 'image')->where('parent_id', $parent_id)->where('status', 'active')->get();
    }

    public function getCategoryFromSlugArray($slug): mixed
    {
        return $this->category->whereIn('slug', $slug)->where('status', 'active')->get();
    }


}
