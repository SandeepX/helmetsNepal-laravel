<?php

namespace App\Http\Controllers\api\front;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Services\AboutUsServices;
use App\Http\Services\CompanyDetailsServices;
use App\Http\Services\CoreValueServices;
use App\Http\Services\PagesServices;
use App\Http\Services\ShowroomServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class PageController extends Controller
{
    public function __construct()
    {
        $this->pagesServices = new PagesServices();
        $this->aboutUsServices = new AboutUsServices();
        $this->showroomServices = new ShowroomServices();
        $this->coreValueServices = new CoreValueServices();
        $this->companyDetailsServices = new CompanyDetailsServices();
    }

    public function getCommonPagesNames(): JsonResponse
    {
        try {
            $page_name = $this->pagesServices->getCommonPagesNames();
            return Helper::successResponseAPI('Success', $page_name);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getCommonPagesDetails($slug): JsonResponse
    {
        try {
            $page_name = $this->pagesServices->getPageDetailsBySlug($slug);
            return Helper::successResponseAPI('Success', $page_name);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }


    public function getHomePageDetail(): JsonResponse
    {
        try {
            $page_name = $this->aboutUsServices->getHomePageDetail();
            return Helper::successResponseAPI('Success', $page_name);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function geBlogSectionDetail(): JsonResponse
    {
        try {
            $page_name = $this->aboutUsServices->geBlogSectionDetail();
            return Helper::successResponseAPI('Success', $page_name);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getNewsletterSectionDetail(): JsonResponse
    {
        try {
            $page_name = $this->aboutUsServices->getNewsletterSectionDetail();
            return Helper::successResponseAPI('Success', $page_name);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function geAboutUsDetail(): JsonResponse
    {
        try {
            $page_name = $this->aboutUsServices->geAboutUsDetail();
            return Helper::successResponseAPI('Success', $page_name);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }


    public function getShowroom(Request $request): JsonResponse
    {
        try {
            $_showroom = $this->showroomServices->getShowroomList($request);
            return Helper::successResponseAPI('Success', $_showroom);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getFeaturedShowroom(Request $request): JsonResponse
    {
        try {
            $_showroom = $this->showroomServices->getFeaturedShowroom();
            return Helper::successResponseAPI('Success', $_showroom);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getCoreValue(Request $request): JsonResponse
    {
        try {
            $_showroom = $this->coreValueServices->getActiveList($request);
            return Helper::successResponseAPI('Success', $_showroom);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getCompanyDetail(): JsonResponse
    {
        try {
            $_companyDetail = $this->companyDetailsServices->geCompanyDetail();
            return Helper::successResponseAPI('Success', $_companyDetail);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }


}
