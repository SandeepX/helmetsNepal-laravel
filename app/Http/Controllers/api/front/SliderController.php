<?php

namespace App\Http\Controllers\api\front;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Services\BannerServices;
use App\Http\Services\BrandServices;
use App\Http\Services\CategoryServices;
use App\Http\Services\SlidingContentServices;
use Illuminate\Http\JsonResponse;
use Throwable;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->categoryServices = new CategoryServices();
        $this->brandServices = new BrandServices();
        $this->bannerServices = new BannerServices();
        $this->slidingContentServices = new SlidingContentServices();
    }

    public function getBannerList(): JsonResponse
    {
        try {
            $banner = $this->bannerServices->getActiveBannerListArray();
            return Helper::successResponseAPI('Success', $banner);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getCategoryList(): JsonResponse
    {
        try {
            $category = $this->categoryServices->getParentChildCategoryList();
            return Helper::successResponseAPI('Success', $category);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getBrandList(): JsonResponse
    {
        try {
            $brand = $this->brandServices->getActiveBrandListArray();
            return Helper::successResponseAPI('Success', $brand);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getSlidingContent(): JsonResponse
    {
        try {
            $_slidingContent = $this->slidingContentServices->getImageTypeSlidingContent();
            return Helper::successResponseAPI('Success', $_slidingContent);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getYoutubeSlidingContent(): JsonResponse
    {
        try {
            $_slidingContent = $this->slidingContentServices->getYoutubeSlidingContent();
            return Helper::successResponseAPI('Success', $_slidingContent);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }


}
