<?php

namespace App\Http\Repositories;

use App\Models\Ad\AdBlock;
use Illuminate\Support\Facades\DB;

class AdBlockRepository
{

    public function __construct()
    {
        $this->adBlock = new AdBlock();
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
        $_adBlock = $this->adBlock->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_adBlock->paginate($paginate);
        }
        return $_adBlock->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->adBlock->create($data)->fresh();
        });
    }

    /**
     * @param $adBlock
     * @param $data
     * @return mixed
     */
    public function update($adBlock, $data): mixed
    {
        return DB::transaction(static function () use ($adBlock, $data) {
            return $adBlock->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->adBlock->findOrFail($id);
    }

    /**
     * @param AdBlock $adBlock
     * @return mixed
     */
    public function delete(AdBlock $adBlock): mixed
    {
        return DB::transaction(static function () use ($adBlock) {
            return $adBlock->delete();
        });
    }

    public function getActiveList(): mixed
    {
        return $this->adBlock->where('status', 'active')->get();
    }

    public function getActiveAdBlockBySection($section): mixed
    {
        return $this->adBlock->where('status', 'active')->where('section', $section)->get();
    }

}
