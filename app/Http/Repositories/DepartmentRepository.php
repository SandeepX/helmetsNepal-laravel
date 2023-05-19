<?php

namespace App\Http\Repositories;

use App\Models\Career\Department;
use Illuminate\Support\Facades\DB;

class DepartmentRepository
{

    public function __construct()
    {
        $this->department = new Department();
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
        $_department = $this->department->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_department->paginate($paginate);
        }
        return $_department->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->department->create($data)->fresh();
        });
    }

    /**
     * @param $department
     * @param $data
     * @return mixed
     */
    public function update($department, $data): mixed
    {
        return DB::transaction(static function () use ($department, $data) {
            return $department->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->department->findOrFail($id);
    }

    /**
     * @param Department $department
     * @return mixed
     */
    public function delete(Department $department): mixed
    {
        return DB::transaction(static function () use ($department) {
            return $department->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->department->where('status', 'active')->pluck('title', 'id');
    }

    public function getActiveDepartment()
    {
        return $this->department->where('status', 'active')->get();
    }


}
