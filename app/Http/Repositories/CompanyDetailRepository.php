<?php

namespace App\Http\Repositories;

use App\Models\Setting\CompanyDetails;
use Illuminate\Support\Facades\DB;

class CompanyDetailRepository
{

    public function __construct()
    {
        $this->companyDetails = new CompanyDetails();
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
        $_companyDetails = $this->companyDetails->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_companyDetails->paginate($paginate);
        }
        return $_companyDetails->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->companyDetails->create($data)->fresh();
        });
    }

    /**
     * @param $companyDetails
     * @param $data
     * @return mixed
     */
    public function update($companyDetails, $data): mixed
    {
        return DB::transaction(static function () use ($companyDetails, $data) {
            return $companyDetails->update($data);
        });
    }

    /**
     * @return mixed
     */
    public function find(): mixed
    {
        return $this->companyDetails->find(1);
    }

    /**
     * @param CompanyDetails $companyDetails
     * @return mixed
     */
    public function delete(CompanyDetails $companyDetails): mixed
    {
        return DB::transaction(static function () use ($companyDetails) {
            return $companyDetails->delete();
        });
    }
}
