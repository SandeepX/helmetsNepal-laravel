<?php

namespace App\Http\Repositories;

use App\Models\Slider\Banner;
use App\Models\Slider\SlidingContent;
use Illuminate\Support\Facades\DB;

class SlidingContentRepository
{

    public function __construct()
    {
        $this->slidingContent = new SlidingContent();
    }


    /**
     * @param array $select
     * @param string $orderBy
     * @param string $orderByType
     * @param bool $is_paginate
     * @param int $paginate
     * @return mixed
     */
    public function findALlImageType(array $select = ['*'], string $orderBy = 'id', string $orderByType = 'desc', bool $is_paginate = true, int $paginate = 10): mixed
    {
        $_slidingContent = $this->slidingContent->select($select)->where('type', 'image_type')->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_slidingContent->paginate($paginate);
        }
        return $_slidingContent->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findImageType($id): mixed
    {
        return $this->slidingContent->where('type', 'image_type')->where('id', $id)->first();
    }


    /**
     * @param array $select
     * @param string $orderBy
     * @param string $orderByType
     * @param bool $is_paginate
     * @param int $paginate
     * @return mixed
     */
    public function findALlYoutubeType(array $select = ['*'], string $orderBy = 'id', string $orderByType = 'desc', bool $is_paginate = true, int $paginate = 10): mixed
    {
        $_slidingContent = $this->slidingContent->select($select)->where('type', 'youtube_type')->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_slidingContent->paginate($paginate);
        }
        return $_slidingContent->get();
    }


    /**
     * @param $id
     * @return mixed
     */
    public function findYoutubeType($id): mixed
    {
        return $this->slidingContent->where('type', 'youtube_type')->where('id', $id)->first();
    }


    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->slidingContent->create($data)->fresh();
        });
    }

    /**
     * @param $slidingContent
     * @param $data
     * @return mixed
     */
    public function update($slidingContent, $data): mixed
    {
        return DB::transaction(static function () use ($slidingContent, $data) {
            return $slidingContent->update($data);
        });
    }

    public function find($id): mixed
    {
        return $this->slidingContent->findOrFail($id);
    }

    public function delete(SlidingContent $slidingContent): mixed
    {
        return DB::transaction(static function () use ($slidingContent) {
            return $slidingContent->delete();
        });
    }

    public function getImageTypeSlidingContent()
    {
        return $this->slidingContent->where('type', 'image_type')->where('status', 'active')->get();
    }

    public function getYoutubeSlidingContent()
    {
        return $this->slidingContent->where('type', 'youtube_type')->where('status', 'active')->get();
    }


}
