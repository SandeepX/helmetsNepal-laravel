<?php

namespace App\Http\Repositories;

use App\Models\Team\Designation;
use Illuminate\Support\Facades\DB;

class DesignationRepository
{

    private Designation $designation;

    public function __construct()
    {
        $this->designation = new Designation();
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
        $_designation = $this->designation->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_designation->paginate($paginate);
        }
        return $_designation->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->designation->create($data)->fresh();
        });
    }

    /**
     * @param $designation
     * @param $data
     * @return mixed
     */
    public function update($designation, $data): mixed
    {
        return DB::transaction(static function () use ($designation, $data) {
            return $designation->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->designation->findOrFail($id);
    }

    /**
     * @param Designation $designation
     * @return mixed
     */
    public function delete(Designation $designation): mixed
    {
        return DB::transaction(static function () use ($designation) {
            return $designation->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->designation->where('status', 'active')->pluck('name', 'id');
    }

}
