<?php

namespace App\Http\Repositories;

use App\Models\Pages\Pages;
use Illuminate\Support\Facades\DB;

class PagesRepository
{

    private Pages $page;

    public function __construct()
    {
        $this->page = new Pages();
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
        $_page = $this->page->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_page->paginate($paginate);
        }
        return $_page->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->page->create($data)->fresh();
        });
    }

    /**
     * @param $page
     * @param $data
     * @return mixed
     */
    public function update($page, $data): mixed
    {
        return DB::transaction(static function () use ($page, $data) {
            return $page->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->page->findOrFail($id);
    }

    /**
     * @param Pages $page
     * @return mixed
     */
    public function delete(Pages $page): mixed
    {
        return DB::transaction(static function () use ($page) {
            return $page->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->page->where('status', 'active')->pluck('name', 'id');
    }


    public function getPageNameList(): mixed
    {
        return $this->page->select('title', 'slug')->where('status', 'active')->get();
    }

    public function getPageBySlug($slug)
    {
        return $this->page->select('title', 'slug', 'details', 'meta_title', 'meta_keys', 'meta_description', 'alternate_text')
            ->where('slug', $slug)->where('status', 'active')->first();
    }

}
