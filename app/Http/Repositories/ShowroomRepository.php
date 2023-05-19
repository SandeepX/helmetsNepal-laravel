<?php

namespace App\Http\Repositories;


use App\Http\Enums\EStatus;
use App\Models\AboutUS\Showroom;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use LaravelIdea\Helper\App\Models\AboutUS\_IH_Showroom_C;

class ShowroomRepository
{

    public function __construct()
    {
        $this->showroom = new Showroom();
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
        $_showroom = $this->showroom->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_showroom->paginate($paginate);
        }
        return $_showroom->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->showroom->create($data)->fresh();
        });
    }

    /**
     * @param $showroom
     * @param $data
     * @return mixed
     */
    public function update($showroom, $data): mixed
    {
        return DB::transaction(static function () use ($showroom, $data) {
            return $showroom->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->showroom->findOrFail($id);
    }

    /**
     * @param Showroom $showroom
     * @return mixed
     */
    public function delete(Showroom $showroom): mixed
    {
        return DB::transaction(static function () use ($showroom) {
            return $showroom->delete();
        });
    }

    public function getActiveListWithPaginate(string $orderBy = 'id', string $orderByType = 'desc', int $paginate = 10): LengthAwarePaginator|_IH_Showroom_C|array
    {
        return $this->showroom->where('status', EStatus::active->value)->orderBy($orderBy, $orderByType)->paginate($paginate);
    }

    public function getActiveList(string $orderBy = 'id', string $orderByType = 'desc')
    {
        return $this->showroom->
        select('name',
            'address',
            'google_map_link',
            'youtube_link',
            'email',
            'contact_no',
            'contact_person',
            'showroom_image')
            ->where('status', EStatus::active->value)
            ->orderBy($orderBy, $orderByType)->get();
    }


    public function getShowInContactList()
    {
        return $this->showroom->
        select('name', 'address', 'google_map_link', 'youtube_link', 'email', 'contact_no', 'contact_person', 'showroom_image')
            ->where('status', EStatus::active->value)
            ->where('show_in_contactUs', 1)
            ->orderBy('id', 'desc')->limit(2)->get();
    }

    public function getFeaturedShowroomList()
    {
        return $this->showroom->where('status', EStatus::active->value)
            ->where('is_feature', 1)
            ->orderBy('id', 'desc')->get();
    }
}
