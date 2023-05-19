<?php

namespace App\Http\Controllers\api\front;


use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Services\CalloutServices;
use App\Http\Services\HomePageSectionServices;
use App\Http\Services\PageBannerServices;
use Illuminate\Http\JsonResponse;
use Throwable;

class PageBannerController extends Controller
{
    public function __construct()
    {
        $this->pageBannerServices = new PageBannerServices();
        $this->calloutServices = new CalloutServices();
        $this->homePageSectionServices = new HomePageSectionServices();
    }

    public function getPageBanner($name): JsonResponse
    {
        try {
            $_pageBanner = $this->pageBannerServices->getPageBannerByName($name);
            return Helper::successResponseAPI('Success', $_pageBanner);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getAboutUsCallout(): JsonResponse
    {
        try {
            $_callout = $this->calloutServices->getActiveList('about_us');
            return Helper::successResponseAPI('Success', $_callout);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getShopCallout(): JsonResponse
    {
        try {
            $_callout = $this->calloutServices->getActiveList('shop');
            return Helper::successResponseAPI('Success', $_callout);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getHomeSectionPosition(): JsonResponse
    {
        try {
            $_homePageSection = $this->homePageSectionServices->getSelectList();
            return Helper::successResponseAPI('Success', $_homePageSection);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }


}
