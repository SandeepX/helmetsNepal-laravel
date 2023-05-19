<?php

namespace App\Http\Repositories;

use App\Models\Blog\Blog;
use Illuminate\Support\Facades\DB;

class BlogRepository
{

    private Blog $blog;

    public function __construct()
    {
        $this->blog = new Blog();
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
        $_blog = $this->blog->join('blog_categories', static function ($query) {
            $query->on('blog_categories.id', '=', 'blogs.blog_category_id');
        })->select(
            [
                DB::raw('blogs.id as id'),
                DB::raw('blogs.title as title'),
                DB::raw('blogs.status as status'),
                DB::raw('blogs.is_featured as is_featured'),
                DB::raw('blog_categories.name as blog_category_name'),
            ]
        )->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_blog->paginate($paginate);
        }
        return $_blog->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->blog->create($data)->fresh();
        });
    }

    /**
     * @param $blog
     * @param $data
     * @return mixed
     */
    public function update($blog, $data): mixed
    {
        return DB::transaction(static function () use ($blog, $data) {
            return $blog->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->blog->findOrFail($id);
    }

    /**
     * @param Blog $blog
     * @return mixed
     */
    public function delete(Blog $blog): mixed
    {
        return DB::transaction(static function () use ($blog) {
            return $blog->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->blog->where('status', 'active')->pluck('name', 'id');
    }

    public function getFeatureBlog(): mixed
    {
        return $this->blog->join('blog_categories', static function ($query) {
            $query->on('blog_categories.id', '=', 'blogs.blog_category_id');
        })->select([
            DB::raw('blogs.id as blog_id'),
            DB::raw('blogs.title as title'),
            DB::raw('blogs.blog_created_by as blog_created_by'),
            DB::raw('blogs.blog_publish_date as blog_publish_date'),
            DB::raw('blogs.blog_read_time as blog_read_time'),
            DB::raw('blog_categories.name as blog_category_name'),
            DB::raw('blogs.blog_creator_image as blog_creator_image'),
            DB::raw('blogs.blog_image as blog_image'),
        ])->where('blogs.is_featured', 1)->where('blogs.status', 'active')->get();
    }

    public function getActiveBlogPaginate($per_page): mixed
    {
        return $this->blog->join('blog_categories', static function ($query) {
            $query->on('blog_categories.id', '=', 'blogs.blog_category_id');
        })->where('blogs.status', 'active')
            ->select([
                DB::raw('blogs.id as blog_id'),
                DB::raw('blogs.title as title'),
                DB::raw('blogs.blog_created_by as blog_created_by'),
                DB::raw('blogs.blog_publish_date as blog_publish_date'),
                DB::raw('blogs.blog_read_time as blog_read_time'),
                DB::raw('blog_categories.name as blog_category_name'),
                DB::raw('blogs.blog_creator_image as blog_creator_image'),
                DB::raw('blogs.blog_image as blog_image'),
            ])
            ->orderBy('blogs.id', 'desc')->paginate($per_page);
    }

    public function getBlogByCategoryID($blog_category_id, $per_page): mixed
    {
        return $this->blog->join('blog_categories', static function ($query) {
            $query->on('blog_categories.id', '=', 'blogs.blog_category_id');
        })->where('blogs.status', 'active')
            ->where('blog_categories.id', $blog_category_id)
            ->select([
                DB::raw('blogs.id as blog_id'),
                DB::raw('blogs.title as title'),
                DB::raw('blogs.blog_created_by as blog_created_by'),
                DB::raw('blogs.blog_publish_date as blog_publish_date'),
                DB::raw('blogs.blog_read_time as blog_read_time'),
                DB::raw('blog_categories.name as blog_category_name'),
                DB::raw('blogs.blog_creator_image as blog_creator_image'),
                DB::raw('blogs.blog_image as blog_image'),
            ])
            ->orderBy('blogs.id', 'desc')->paginate($per_page);
    }


    public function getRelatedBlogByCategoryID($blog_category_id, $blog_id): mixed
    {
        return $this->blog->join('blog_categories', static function ($query) {
            $query->on('blog_categories.id', '=', 'blogs.blog_category_id');
        })->where('blogs.status', 'active')
            ->where('blog_categories.id', $blog_category_id)
            ->where('blogs.id', '!=', $blog_id)
            ->select([
                DB::raw('blogs.id as blog_id'),
                DB::raw('blogs.title as title'),
                DB::raw('blogs.blog_created_by as blog_created_by'),
                DB::raw('blogs.blog_publish_date as blog_publish_date'),
                DB::raw('blogs.blog_read_time as blog_read_time'),
                DB::raw('blog_categories.name as blog_category_name'),
                DB::raw('blogs.blog_creator_image as blog_creator_image'),
                DB::raw('blogs.blog_image as blog_image'),
            ])
            ->orderBy('blogs.id', 'desc')->limit(3)->get();
    }

    public function getBlogDetail($blog_id): mixed
    {
        return $this->blog->join('blog_categories', static function ($query) {
            $query->on('blog_categories.id', '=', 'blogs.blog_category_id');
        })->where('blogs.status', 'active')
            ->where('blogs.id', $blog_id)
            ->select([
                DB::raw('blogs.id as blog_id'),
                DB::raw('blogs.title as title'),
                DB::raw('blogs.description as description'),
                DB::raw('blogs.blog_created_by as blog_created_by'),
                DB::raw('blogs.blog_publish_date as blog_publish_date'),
                DB::raw('blogs.blog_read_time as blog_read_time'),
                DB::raw('blogs.blog_category_id as blog_category_id'),
                DB::raw('blog_categories.name as blog_category_name'),
                DB::raw('blogs.blog_image as blog_image'),
                DB::raw('blogs.blog_creator_image as blog_creator_image'),
            ])->first();
    }


}
