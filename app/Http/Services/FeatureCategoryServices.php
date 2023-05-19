<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EDateFormat;
use App\Http\Enums\EStatus;
use App\Http\Repositories\FeatureCategoryRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\ReviewRepository;
use App\Http\Repositories\WishlistRepository;
use App\Models\FeatureCategory\FeatureCategory;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\ArrayShape;

class FeatureCategoryServices
{
    protected FeatureCategoryRepository $featureCategoryRepository;
    private string $notFoundMessage = "Sorry! Feature Category not found";

    public function __construct()
    {
        $this->featureCategoryRepository = new FeatureCategoryRepository();
        $this->productRepository = new ProductRepository();
        $this->wishlistRepository = new WishlistRepository();

    }

    public function getList()
    {
        return $this->featureCategoryRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveFeatureCategory($request): void
    {
        $data = $request->all();
        $this->featureCategoryRepository->save([
            'name' => $data['name'],
            'detail' => $data['detail'] ?? "",
            'slug' => Helper::getSlugSimple($data['name']),
            'status' => EStatus::active,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getFeatureCategory($featureCategory_id)
    {
        $_featureCategory = $this->featureCategoryRepository->find($featureCategory_id);
        if ($_featureCategory) {
            return $_featureCategory;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateFlashSale($featureCategory_id, $sale_start_date, $sale_end_date)
    {
        $d1 = strtotime($sale_start_date);
        $d2 = strtotime($sale_end_date);
        if ($d1 > $d2) {
            throw new SMException("Sales end date cannot be greater than sales start date");
        }
        $_featureCategory = $this->featureCategoryRepository->find($featureCategory_id);
        return $this->featureCategoryRepository->update($_featureCategory, [
            'sale_start_date' => date(EDateFormat::YmdHis->value, $d1),
            'sale_end_date' => date(EDateFormat::YmdHis->value, $d2),
        ]);
    }


    /**
     * @throws SMException
     */
    public function updateFeatureCategory($featureCategory_id, $request = null, $sale_start_date = null, $sale_end_date = null)
    {
        $data = $request?->validated() ?? [];
        $_featureCategory = $this->featureCategoryRepository->find($featureCategory_id);
        $d1 = strtotime($sale_start_date);
        $d2 = strtotime($sale_end_date);
        if ($_featureCategory) {
            return $this->featureCategoryRepository->update($_featureCategory, [
                'name' => $data['name'] ?? $_featureCategory->name,
                'detail' => $data['detail'] ?? $_featureCategory->name,
                'slug' => Helper::getSlugSimple($data['name'] ?? $_featureCategory->name),
                'sale_start_date' => date(EDateFormat::YmdHis->value, $d1),
                'sale_end_date' => date(EDateFormat::YmdHis->value, $d2),
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateFeatureCategoryDetail($featureCategory_id, $request)
    {
        $data = $request->all() ?? [];
        $_featureCategory = $this->featureCategoryRepository->find($featureCategory_id);

        if ($_featureCategory) {
            return $this->featureCategoryRepository->update($_featureCategory, [
                'detail' => $data['detail'] ?? $_featureCategory->detail,
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteFeatureCategory($featureCategory_id)
    {
        $_featureCategory = $this->featureCategoryRepository->find($featureCategory_id);
        if ($_featureCategory) {
            return $this->featureCategoryRepository->delete($_featureCategory);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->featureCategoryRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    public function saveFeatureCategoryItem($request, string $feature_category): FeatureCategory
    {
        $_feature_category = $this->featureCategoryRepository->findFeatureCategoryBySlug($feature_category);
        if ($_feature_category) {
            $_products = $request->product_id ?? [];
            $feature_category_id = $_feature_category->id;
            foreach ($_products as $product_id) {
                $check_resp = $this->featureCategoryRepository->checkFeatureCategoryItem($product_id, $feature_category_id);
                if (is_null($check_resp)) {
                    $this->featureCategoryRepository->saveFeatureCategoryItem($product_id, $feature_category_id);
                }
            }
            return $_feature_category;
        }
        throw new SMException($this->notFoundMessage);
    }

    public function findFeatureCategoryBySlug($slug)
    {
        return $this->featureCategoryRepository->findFeatureCategoryBySlug($slug);
    }

    public function listFeatureCategoryItemWithProduct($feature_category_id)
    {
        return $this->featureCategoryRepository->getProductByFeatureCategoryID($feature_category_id);
    }

    /**
     * @throws SMException
     */
    public function deleteFeatureCategoryItem($feature_category_item_id)
    {
        $_featureCategoryItem = $this->featureCategoryRepository->findFeatureCategoryItem($feature_category_item_id);
        if ($_featureCategoryItem) {
            return $this->featureCategoryRepository->deleteFeatureCategoryItem($_featureCategoryItem);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_featureCategoryItem = $this->featureCategoryRepository->find($user_id);
        if ($_featureCategoryItem) {
            $this->featureCategoryRepository->update($_featureCategoryItem, ['status' => (($_featureCategoryItem->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getFeatureItemAPI($feature_category): array|string
    {
        $return_array = [];
        $_feature_category = $this->featureCategoryRepository->findFeatureCategoryBySlug($feature_category);
        $_customer = Auth::guard('customerApi')->user();
        $customer_id = $_customer?->id;
        if ($_feature_category) {
            $return_array['section_sub_title'] = $_feature_category->detail ?? "";
            $featureCategoryItems = $this->featureCategoryRepository->getFeatureItemList($_feature_category->id);
            $_review = new ReviewRepository();
            foreach ($featureCategoryItems as $featureCategoryItem) {
                $product_id = $featureCategoryItem->product_id;

                $images = [];
                $colors = [];
                if ($featureCategoryItem->color_status) {
                    $_ProductColors = $this->productRepository->getProductColorDetails($product_id);
                    foreach ($_ProductColors as $productColor) {
                        $images[] = [
                            'id' => $productColor->id ?? "",
                            'color_name' => $productColor->color_1_name ?? "",
                            'color' => [$productColor->color_1_color_value, ($productColor->color_2_color_value) ?: $productColor->color_1_color_value],
                            'image' => ($productColor->product_image_color) ? $productColor->product_image_color_path : asset('/front/uploads/product_cover_image/img-' . $productColor->cover_image),
                        ];
                        $colors[] = [$productColor->color_1_color_value, ($productColor->color_2_color_value) ?: $productColor->color_1_color_value];
                    }
                } else {
                    $images[] = [
                        'id' => "",
                        'color_name' => "",
                        'color' => "",
                        'image' => asset('/front/uploads/product_cover_image/img-' . $featureCategoryItem->cover_image),
                    ];
                }

                $_review_list = $_review->getPublishedReviewListByProductID($featureCategoryItem->product_id);
                $wishlist_status = false;
                if ($customer_id) {
                    $wishlist_resp = $this->wishlistRepository->find($customer_id, $product_id);
                    $wishlist_status = (bool)$wishlist_resp;
                }
                $_product = $this->productRepository->find($product_id);
                $_push_array = [
                    'id' => $featureCategoryItem->product_id,
                    'tag' => ['type' => ($featureCategoryItem->tag_type ?? ""), 'name' => ($featureCategoryItem->tag_name ?? "")],
                    'slug' => $featureCategoryItem->product_slug,
                    'name' => $featureCategoryItem->product_title,
                    'rating' => '',
                    'reviews' => '',
                    'oldPrice' => $_product->product_price,
                    'discount_percent' => $_product->product_discount['discount_percent'],
                    'discount_amount' => $_product->product_discount['discount_amount'],
                    'newPrice' => $_product->final_product_price,
                    'colors' => $colors,
                    'images' => $images,
                    'review_star' => Helper::countReviewStar($_review_list),
                    'wishlist_status' => $wishlist_status,
                ];

                $return_array['product'][] = $_push_array;
            }

            return $return_array;
        }
        return "Product Not Found";
    }

    /**
     * @throws SMException
     */
    public function getFlashSalesItemApi()
    {
        $return_array = [];
        $_featureCategoryItem = $this->featureCategoryRepository->findFeatureCategoryBySlug('flash-sale');
        if ($_featureCategoryItem) {

            $return_array['sale_start_date'] = $_featureCategoryItem->sale_start_date ?? "";
            $return_array['sale_end_date'] = $_featureCategoryItem->sale_end_date ?? "";
            $return_array['section_sub_title'] = $_featureCategoryItem->detail ?? "";

            $_customer = Auth::guard('customerApi')->user();
            $customer_id = $_customer?->id;

            $featureCategoryItems = $this->featureCategoryRepository->getFeatureItemList($_featureCategoryItem->id);

            foreach ($featureCategoryItems as $featureCategoryItem) {
                $product_id = $featureCategoryItem->product_id;
                $_ProductColor = $this->productRepository->getProductColorDetails($product_id);
                $_ProductSize = $this->productRepository->getProductSizeDetails($product_id)->pluck('size_name');
                $wishlist_status = false;
                if ($customer_id) {
                    $wishlist_resp = $this->wishlistRepository->find($customer_id, $product_id);
                    $wishlist_status = (bool)$wishlist_resp;
                }
                $_product = $this->productRepository->find($product_id);
                $_push_array = [
                    'id' => $featureCategoryItem->product_id,
                    'image' => asset('/front/uploads/feature_category/' . $featureCategoryItem->feature_category_image),
                    'tagline' => $featureCategoryItem->product_sub_title,
                    'name' => $featureCategoryItem->product_title,
                    'price' => $_product->final_product_price,
                    'colors' => $_ProductColor->pluck('color_1_color_value'),
                    'size' => $_ProductSize,
                    'slug' => $featureCategoryItem->product_slug,
                    'tag' => ['type' => ($featureCategoryItem->tag_type ?? ""), 'name' => ($featureCategoryItem->tag_name ?? "")],
                    'wishlist_status' => $wishlist_status,
                ];

                $return_array['flashSaleProduct'][] = $_push_array;
            }
            return $return_array;
        }
        throw new SMException($this->notFoundMessage);
    }


    /**
     * @param $request
     * @param $feature_category_item_id
     * @return mixed
     * @throws SMException
     */
    public function uploadImageFeatureCategoryItem($request, $feature_category_item_id): mixed
    {
        $_featureCategoryItem = $this->featureCategoryRepository->findFeatureCategoryItem($feature_category_item_id);
        if ($_featureCategoryItem) {
            if ($request->hasFile('images')) {
                $feature_category_image = Helper::uploadFile(file: $request->images, file_folder_name: "feature_category", width: 128, height: 128);
            } else {
                throw new SMException("Image not found");
            }
            return $this->featureCategoryRepository->updateFeatureCategoryItem($_featureCategoryItem, [
                'feature_category_image' => $feature_category_image
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }


}
