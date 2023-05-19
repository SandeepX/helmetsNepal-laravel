<?php

namespace App\Http\Repositories;


use App\Models\Product\Manufacture;
use Illuminate\Support\Facades\DB;

class ManufactureRepository
{

    public function __construct()
    {
        $this->manufacture = new Manufacture();
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
        $_manufacture = $this->manufacture->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_manufacture->paginate($paginate);
        }
        return $_manufacture->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->manufacture->create($data)->fresh();
        });
    }

    /**
     * @param $manufacture
     * @param $data
     * @return mixed
     */
    public function update($manufacture, $data): mixed
    {
        return DB::transaction(static function () use ($manufacture, $data) {
            return $manufacture->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->manufacture->findOrFail($id);
    }

    /**
     * @param Manufacture $manufacture
     * @return mixed
     */
    public function delete(Manufacture $manufacture): mixed
    {
        return DB::transaction(static function () use ($manufacture) {
            return $manufacture->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->manufacture->where('status', 'active')->pluck('name', 'id');
    }
}
