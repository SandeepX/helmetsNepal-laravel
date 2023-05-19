<?php

namespace App\Http\Repositories;

use App\Models\Career\Career;
use Illuminate\Support\Facades\DB;

class CareerRepository
{

    private Career $career;

    public function __construct()
    {
        $this->career = new Career();
    }

    /**
     * @param string $orderBy
     * @param string $orderByType
     * @param bool $is_paginate
     * @param int $paginate
     * @return mixed
     */
    public function findALl(string $orderBy = 'id', string $orderByType = 'desc', bool $is_paginate = true, int $paginate = 10): mixed
    {
        $_career = $this->career->join('departments', static function ($query) {
            $query->on('departments.id', '=', 'careers.department_id');
        })->select(
            [
                DB::raw('careers.id as id'),
                DB::raw('careers.title as title'),
                DB::raw('careers.salary_details as salary_details'),
                DB::raw('careers.description as description'),
                DB::raw('careers.status as status'),
                DB::raw('departments.title as department_name'),
            ]
        )->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_career->paginate($paginate);
        }
        return $_career->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->career->create($data)->fresh();
        });
    }

    /**
     * @param $career
     * @param $data
     * @return mixed
     */
    public function update($career, $data): mixed
    {
        return DB::transaction(static function () use ($career, $data) {
            return $career->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->career->findOrFail($id);
    }

    /**
     * @param Career $career
     * @return mixed
     */
    public function delete(Career $career): mixed
    {
        return DB::transaction(static function () use ($career) {
            return $career->delete();
        });
    }

    public function getSelectList()
    {
        return $this->career->where('status', 'active')->pluck('name', 'id');
    }


    public function getCareerByDepartment($department_id)
    {
        return $this->career->where('department_id', $department_id)->where('status', 'active')->get();
    }

    public function getCareer($career_id)
    {
        return $this->career->join('departments', static function ($query) {
            $query->on('careers.department_id', '=', 'departments.id');
        })->select([
            DB::raw('careers.title as title'),
            DB::raw('careers.salary_details as salary_details'),
            DB::raw('careers.description as description'),
            DB::raw('departments.title as department_name'),
        ])
            ->where('careers.id', $career_id)->where('careers.status', 'active')->first();
    }

}
