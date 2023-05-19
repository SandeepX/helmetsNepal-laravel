<?php

namespace App\Http\Repositories;

use App\Models\Career\Application;
use Illuminate\Support\Facades\DB;

class ApplicationRepository
{

    public function __construct()
    {
        $this->application = new Application();
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
        $_application = $this->application->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_application->with('getCareer')->paginate($paginate);
        }
        return $_application->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->application->create($data)->fresh();
        });
    }

    /**
     * @param $application
     * @param $data
     * @return mixed
     */
    public function update($application, $data): mixed
    {
        return DB::transaction(static function () use ($application, $data) {
            return $application->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->application->findOrFail($id);
    }

    /**
     * @param Application $application
     * @return mixed
     */
    public function delete(Application $application): mixed
    {
        return DB::transaction(static function () use ($application) {
            return $application->delete();
        });
    }
}
