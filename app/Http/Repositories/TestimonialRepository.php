<?php

namespace App\Http\Repositories;

use App\Models\Story\Testimonial;
use Illuminate\Support\Facades\DB;

class TestimonialRepository
{

    private Testimonial $testimonial;

    public function __construct()
    {
        $this->testimonial = new Testimonial();
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
        $_testimonial = $this->testimonial->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_testimonial->paginate($paginate);
        }
        return $_testimonial->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->testimonial->create($data)->fresh();
        });
    }

    /**
     * @param $testimonial
     * @param $data
     * @return mixed
     */
    public function update($testimonial, $data): mixed
    {
        return DB::transaction(static function () use ($testimonial, $data) {
            return $testimonial->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->testimonial->findOrFail($id);
    }

    /**
     * @param Testimonial $testimonial
     * @return mixed
     */
    public function delete(Testimonial $testimonial): mixed
    {
        return DB::transaction(static function () use ($testimonial) {
            return $testimonial->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->testimonial->where('status', 'active')->pluck('name', 'id');
    }

    public function getActiveTestimonialList(): mixed
    {
        return $this->testimonial->where('status', 'active')->get();
    }
}
