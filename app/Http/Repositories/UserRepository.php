<?php

namespace App\Http\Repositories;

use App\Models\Admin\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserRepository
{

    private User $user;

    public function __construct()
    {
        $this->user = new User();
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
        $_user = $this->user->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_user->paginate($paginate);
        }
        return $_user->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->user->create($data)->fresh();
        });
    }

    /**
     * @param $user
     * @param $data
     * @return mixed
     */
    public function update($user, $data): mixed
    {
        return DB::transaction(static function () use ($user, $data) {
            return $user->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->user->findOrFail($id);
    }

    public function findUserDetailByUnexpiredOtpCode($otpCode)
    {
        return $this->user
            ->where('two_factor_code', $otpCode)
            ->where('two_factor_expires_at','>',Carbon::now())
            ->first();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function delete(User $user): mixed
    {
        return DB::transaction(static function () use ($user) {
            return $user->delete();
        });
    }

    /**
     * @param $username
     * @return mixed
     */
    public function getUserByUsername($username): mixed
    {
        return $this->user->where('username', $username)->first();
    }

    /**
     * @param $email
     * @return mixed
     */
    public function getUserByEmail($email): mixed
    {
        return $this->user->where('email', $email)->first();
    }
}
