<?php

namespace App\Http\Repositories;

use App\Models\Team\Team;
use Illuminate\Support\Facades\DB;

class TeamRepository
{

    private Team $team;

    public function __construct()
    {
        $this->team = new Team();
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
        $_team = $this->team->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_team->paginate($paginate);
        }
        return $_team->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->team->create($data)->fresh();
        });
    }

    /**
     * @param $team
     * @param $data
     * @return mixed
     */
    public function update($team, $data): mixed
    {
        return DB::transaction(static function () use ($team, $data) {
            return $team->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->team->findOrFail($id);
    }

    /**
     * @param Team $team
     * @return mixed
     */
    public function delete(Team $team): mixed
    {
        return DB::transaction(static function () use ($team) {
            return $team->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->team->where('status', 'active')->pluck('title', 'id');
    }

    public function getFeatureTeamList(): mixed
    {
        return $this->team->where('is_featured', 1)->where('status', 'active')->get();
    }

    public function getActiveTeamList(): mixed
    {
        return $this->team->where('status', 'active')->get();
    }

    public function getActiveTeamBySlug($slug): mixed
    {
        return $this->team->where('status', 'active')->where('slug', $slug)->first();
    }
}
