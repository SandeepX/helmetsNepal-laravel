<?php

namespace App\Http\Controllers\api\front;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Services\FaqServices;
use App\Http\Services\PageBannerServices;
use Illuminate\Http\JsonResponse;
use Throwable;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->faqServices = new FaqServices();
        $this->pageBannerServices = new PageBannerServices();
    }

    public function getFaq(): JsonResponse
    {
        try {
            $_faq = $this->faqServices->getFaqList();
            $_pageBanner = $this->pageBannerServices->getPageBannerByName('faq');
            return Helper::successResponseAPI('Success', ['faqsCategories' => $_faq['faqsCategories'], 'faqsData' => $_faq['faqsData'], 'page_banner' => $_pageBanner]);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }
}
