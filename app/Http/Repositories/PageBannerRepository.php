<?php

namespace App\Http\Repositories;

use App\Models\Pages\PageBanner;
use Illuminate\Support\Facades\DB;

class PageBannerRepository
{

    public function __construct()
    {
        $this->pageBanner = new PageBanner();
    }

    /**
     * @param array $select
     * @param string $orderBy
     * @param string $orderByType
     * @param bool $is_paginate
     * @param int $paginate
     * @return mixed
     */
    public function findALl(): mixed
    {
        return $this->pageBanner->orderBy('id', 'desc')->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->pageBanner->create($data)->fresh();
        });
    }

    /**
     * @param $pageBanner
     * @param $data
     * @return mixed
     */
    public function update($pageBanner, $data): mixed
    {
        return DB::transaction(static function () use ($pageBanner, $data) {
            return $pageBanner->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->pageBanner->findOrFail($id);
    }

    /**
     * @param PageBanner $pageBanner
     * @return mixed
     */
    public function delete(PageBanner $pageBanner): mixed
    {
        return DB::transaction(static function () use ($pageBanner) {
            return $pageBanner->delete();
        });
    }

    public function getPageBannerByName($name)
    {
        return $this->pageBanner->where('page_name', $name)->first();
    }

}
