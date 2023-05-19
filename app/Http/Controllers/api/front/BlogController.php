<?php

namespace App\Http\Controllers\api\front;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Services\BlogCategoryServices;
use App\Http\Services\BlogServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->blogServices = new BlogServices();
        $this->blogCategoryServices = new BlogCategoryServices();
    }

    public function getFeatureBlog(): JsonResponse
    {
        try {
            $_blog = $this->blogServices->getFeatureBlog();
            return Helper::successResponseAPI('Success', $_blog);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }


    public function getBlogList(Request $request): JsonResponse
    {
        try {
            $_blog = $this->blogServices->getBlogList($request);
            $feature_blog = $this->blogServices->getFeatureBlog();
            return Helper::successResponseAPI('Success', ['blog_list' => $_blog, 'feature_blog' => $feature_blog]);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getBlogCategory(): JsonResponse
    {
        try {
            $_blog = $this->blogCategoryServices->getBlogCategoryList();
            return Helper::successResponseAPI('Success', $_blog);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getBlogByCategoryID(Request $request, $id): JsonResponse
    {
        try {
            if ($id === "all") {
                $_blog = $this->blogServices->getBlogList($request);
            } else {
                $_blog = $this->blogServices->getBlogByCategoryID($id, $request);
            }

            return Helper::successResponseAPI('Success', $_blog);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getBlogDetail($id): JsonResponse
    {
        try {
            return $this->blogServices->getBlogDetail($id);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }


}
