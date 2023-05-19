<?php

namespace App\Http\Repositories;

use App\Models\ProductAttribute\Size;
use Illuminate\Support\Facades\DB;

class SizeRepository
{

    public function __construct()
    {
        $this->size = new Size();
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
        $_size = $this->size->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_size->paginate($paginate);
        }
        return $_size->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->size->create($data)->fresh();
        });
    }

    /**
     * @param $size
     * @param $data
     * @return mixed
     */
    public function update($size, $data): mixed
    {
        return DB::transaction(static function () use ($size, $data) {
            return $size->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->size->findOrFail($id);
    }

    /**
     * @param Size $size
     * @return mixed
     */
    public function delete(Size $size): mixed
    {
        return DB::transaction(static function () use ($size) {
            return $size->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->size->where('status', 'active')->pluck('name', 'id');
    }

}
