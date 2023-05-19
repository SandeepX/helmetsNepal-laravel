<?php

namespace App\Http\Repositories;


use App\Http\Enums\EStatus;
use App\Models\AboutUS\CoreValue;
use Illuminate\Support\Facades\DB;

class CoreValueRepository
{

    public function __construct()
    {
        $this->coreValue = new CoreValue();
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
        $_coreValue = $this->coreValue->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_coreValue->paginate($paginate);
        }
        return $_coreValue->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->coreValue->create($data)->fresh();
        });
    }

    /**
     * @param $coreValue
     * @param $data
     * @return mixed
     */
    public function update($coreValue, $data): mixed
    {
        return DB::transaction(static function () use ($coreValue, $data) {
            return $coreValue->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->coreValue->findOrFail($id);
    }

    /**
     * @param CoreValue $coreValue
     * @return mixed
     */
    public function delete(CoreValue $coreValue): mixed
    {
        return DB::transaction(static function () use ($coreValue) {
            return $coreValue->delete();
        });
    }

    public function getActiveList(): mixed
    {
        return $this->coreValue->where('status', EStatus::active->value)->get();
    }
}
