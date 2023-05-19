<?php

namespace App\Http\Controllers\api\front;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Repositories\ReviewRepository;
use App\Http\Resources\ReviewResources;
use App\Http\Services\FeatureCategoryServices;
use App\Http\Services\ProductServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->featureCategoryServices = new FeatureCategoryServices();
        $this->productServices = new ProductServices();
    }

    public function getFeatureItemList(): JsonResponse
    {
        try {
            $featureItem = $this->featureCategoryServices->getFeatureItemAPI('feature-product');
            return Helper::successResponseAPI('Success', $featureItem);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getFlashSales(): JsonResponse
    {
        try {
            $flashSale = $this->featureCategoryServices->getFlashSalesItemApi();
            return Helper::successResponseAPI('Success', $flashSale);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }


    public function getRecommendedItemList(): JsonResponse
    {
        try {
            $featureItem = $this->productServices->getApiRecommendedItem();
            return Helper::successResponseAPI('Success', $featureItem);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getFeatureHelmets(): JsonResponse
    {
        try {
            $featureItem = $this->featureCategoryServices->getFeatureItemAPI('helmets');
            return Helper::successResponseAPI('Success', $featureItem);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getFeatureRidingGears(): JsonResponse
    {
        try {
            $featureItem = $this->featureCategoryServices->getFeatureItemAPI('riding-gears');
            return Helper::successResponseAPI('Success', $featureItem);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getFeatureApparels(): JsonResponse
    {
        try {
            $featureItem = $this->featureCategoryServices->getFeatureItemAPI('apparels');
            return Helper::successResponseAPI('Success', $featureItem);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getFeatureAccessories(): JsonResponse
    {
        try {
            $featureItem = $this->featureCategoryServices->getFeatureItemAPI('accessories');
            return Helper::successResponseAPI('Success', $featureItem);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }


    public function getProductByCategory(Request $request): JsonResponse
    {
        try {
            $featureItem = $this->productServices->getApiProductByCategory($request);
            return Helper::successResponseAPI('Success', $featureItem);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }


    public function getProductDetails($product_slug): JsonResponse
    {
        try {
            $_product = $this->productServices->getProductDetailBySlug($product_slug);
            $_review = new ReviewRepository();
            $_review_list = $_review->getPublishedReviewListByProductID($_product['id']);

            return Helper::successResponseAPI('Success', [
                'product' => $_product,
                'review' => ReviewResources::collection($_review_list->get()) ,
                'review_star'=>Helper::countReviewStar($_review_list)
            ]);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function productSearchApi(Request $request): JsonResponse
    {
        try {
            return Response()->json($this->productServices->productSearchApi($request));
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function productSearch(Request $request): JsonResponse
    {
        try {
            return Helper::successResponseAPI('Success', $this->productServices->globalProductSearch($request));
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }

    public function getProductByBrand(Request $request): JsonResponse
    {
        try {
            $_product = $this->productServices->getApiProductByBrand($request);
            return Helper::successResponseAPI('Success', $_product);
        } catch (Throwable $t) {
            return Helper::errorResponseAPI($t->getMessage());
        }
    }


}
