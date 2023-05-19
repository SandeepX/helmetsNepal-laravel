<?php

namespace App\Http\Repositories;

use App\Models\Setting\CompanySetting;
use Illuminate\Support\Facades\DB;

class CompanySettingRepository
{

    private CompanySetting $companySetting;

    public function __construct()
    {
        $this->companySetting = new CompanySetting();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->companySetting->create($data)->fresh();
        });
    }

    /**
     * @param $companySetting
     * @param $data
     * @return mixed
     */
    public function update($companySetting, $data): mixed
    {
        return DB::transaction(static function () use ($companySetting, $data) {
            return $companySetting->update($data);
        });
    }

    /**
     * @return mixed
     */
    public function find(): mixed
    {
        return $this->companySetting->find(1);
    }

    public function getReturnDays()
    {
        return $this->companySetting->select('return_days')->first();
    }
}
