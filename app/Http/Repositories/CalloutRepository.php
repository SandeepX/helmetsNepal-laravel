<?php

namespace App\Http\Repositories;


use App\Http\Enums\EStatus;
use App\Models\AboutUS\Callout;
use Illuminate\Support\Facades\DB;

class CalloutRepository
{
    public function __construct()
    {
        $this->callout = new Callout();
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
        $_callout = $this->callout->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_callout->paginate($paginate);
        }
        return $_callout->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->callout->create($data)->fresh();
        });
    }

    /**
     * @param $callout
     * @param $data
     * @return mixed
     */
    public function update($callout, $data): mixed
    {
        return DB::transaction(static function () use ($callout, $data) {
            return $callout->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->callout->findOrFail($id);
    }

    /**
     * @param Callout $callout
     * @return mixed
     */
    public function delete(Callout $callout): mixed
    {
        return DB::transaction(static function () use ($callout) {
            return $callout->delete();
        });
    }

    public function getActiveList($type): mixed
    {
        return $this->callout->where('status', EStatus::active->value)->where('type', $type)->get();
    }
}
