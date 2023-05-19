<?php

namespace App\Http\Repositories;

use App\Models\ProductAttribute\Color;
use Illuminate\Support\Facades\DB;

class ColorRepository
{

    public function __construct()
    {
        $this->color = new Color();
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
        $_color = $this->color->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_color->paginate($paginate);
        }
        return $_color->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->color->create($data)->fresh();
        });
    }

    /**
     * @param $color
     * @param $data
     * @return mixed
     */
    public function update($color, $data): mixed
    {
        return DB::transaction(static function () use ($color, $data) {
            return $color->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->color->findOrFail($id);
    }

    /**
     * @param Color $color
     * @return mixed
     */
    public function delete(Color $color): mixed
    {
        return DB::transaction(static function () use ($color) {
            return $color->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->color->where('status', 'active')->pluck('name', 'id');
    }

    public function getActiveList(): mixed
    {
        return $this->color->where('status', 'active')->orderBy('name','asc')->get();
    }
}
