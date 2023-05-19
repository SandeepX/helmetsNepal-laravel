<?php

namespace App\Http\Repositories;

use App\Models\Story\RiderStory;
use Illuminate\Support\Facades\DB;

class RiderStoryRepository
{

    private RiderStory $riderStory;

    public function __construct()
    {
        $this->riderStory = new RiderStory();
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
        $_riderStory = $this->riderStory->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_riderStory->paginate($paginate);
        }
        return $_riderStory->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->riderStory->create($data)->fresh();
        });
    }

    /**
     * @param $riderStory
     * @param $data
     * @return mixed
     */
    public function update($riderStory, $data): mixed
    {
        return DB::transaction(static function () use ($riderStory, $data) {
            return $riderStory->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->riderStory->findOrFail($id);
    }

    /**
     * @param RiderStory $riderStory
     * @return mixed
     */
    public function delete(RiderStory $riderStory): mixed
    {
        return DB::transaction(static function () use ($riderStory) {
            return $riderStory->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->riderStory->where('status', 'active')->pluck('name', 'id');
    }

    public function getActiveRiderStoryList(): mixed
    {
        return $this->riderStory->where('status', 'active')->get();
    }

    public function getActiveRiderStoryDetail($id): mixed
    {
        return $this->riderStory->where('id', $id)->where('status', 'active')->first();
    }
}
