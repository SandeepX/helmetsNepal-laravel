<?php

namespace App\Http\Repositories;

use App\Models\Setting\HomePageSection;
use Illuminate\Support\Facades\DB;

class HomePageSectionRepository
{

    public function __construct()
    {
        $this->homePageSection = new HomePageSection();
    }

    /**
     * @param array $select
     * @param string $orderBy
     * @param string $orderByType
     * @param bool $is_paginate
     * @param int $paginate
     * @return mixed
     */
    public function findALl(array $select = ['*'], string $orderBy = 'id', string $orderByType = 'asc', bool $is_paginate = true, int $paginate = 10): mixed
    {
        $_homePageSection = $this->homePageSection->select($select)->orderBy('position', $orderByType);
        if ($is_paginate) {
            return $_homePageSection->paginate($paginate);
        }
        return $_homePageSection->get();
    }

    /**
     * @param $homePageSection
     * @param $data
     * @return mixed
     */
    public function update($homePageSection, $data): mixed
    {
        return DB::transaction(static function () use ($homePageSection, $data) {
            return $homePageSection->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->homePageSection->findOrFail($id);
    }

    public function getSelectList(): mixed
    {
        return $this->homePageSection->orderBy('position' , 'asc')->get();
    }
}
