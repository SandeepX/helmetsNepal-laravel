<?php

namespace App\Http\Repositories;

use App\Models\Admin\Role;
use Illuminate\Support\Facades\DB;

class RoleRepository
{
    private Role $role;

    public function __construct()
    {
        $this->role = new Role();
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
        $_role = $this->role->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_role->paginate($paginate);
        }
        return $_role->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->role->create($data)->fresh();
        });
    }

    /**
     * @param $role
     * @param $data
     * @return mixed
     */
    public function update($role, $data): mixed
    {
        return DB::transaction(static function () use ($role, $data) {
            return $role->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->role->findOrFail($id);
    }

    /**
     * @param Role $role
     * @return mixed
     */
    public function delete(Role $role): mixed
    {
        return DB::transaction(static function () use ($role) {
            return $role->delete();
        });
    }
}
