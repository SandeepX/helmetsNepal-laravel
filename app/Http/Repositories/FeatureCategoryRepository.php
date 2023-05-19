<?php

namespace App\Http\Repositories;

use App\Http\Enums\EProductStatus;
use App\Models\FeatureCategory\FeatureCategory;
use App\Models\FeatureCategory\FeatureCategoryItem;
use App\Models\Product\Category;
use Illuminate\Support\Facades\DB;

class FeatureCategoryRepository
{

    private FeatureCategory $featureCategory;

    public function __construct()
    {
        $this->featureCategory = new FeatureCategory();
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
        $_featureCategory = $this->featureCategory->select($select)->orderBy($orderBy, $orderByType);
        if ($is_paginate) {
            return $_featureCategory->paginate($paginate);
        }
        return $_featureCategory->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->featureCategory->create($data)->fresh();
        });
    }

    /**
     * @param $featureCategory
     * @param $data
     * @return mixed
     */
    public function update($featureCategory, $data): mixed
    {
        return DB::transaction(static function () use ($featureCategory, $data) {
            return $featureCategory->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->featureCategory->findOrFail($id);
    }

    /**
     * @param FeatureCategory $featureCategory
     * @return mixed
     */
    public function delete(FeatureCategory $featureCategory): mixed
    {
        return DB::transaction(static function () use ($featureCategory) {
            return $featureCategory->delete();
        });
    }

    public function getSelectList(): mixed
    {
        return $this->featureCategory->where('status', 'active')->pluck('name', 'id');
    }

    public function findFeatureCategoryBySlug(string $name)
    {
        return FeatureCategory::where('slug', $name)->first();
    }
    public function getRandomFeatureCategory()
    {
        return FeatureCategory::where('slug', 'helmets')->first();
    }



    public function checkFeatureCategoryItem($product_id, $feature_category_id)
    {
        return FeatureCategoryItem::where('product_id', $product_id)->where('feature_category_id', $feature_category_id)->first();
    }

    public function saveFeatureCategoryItem($product_id, $feature_category_id)
    {
        return FeatureCategoryItem::create([
            'product_id' => $product_id,
            'feature_category_id' => $feature_category_id,
        ]);
    }

    public function getFeatureCategoryItem($feature_category_id)
    {
        return FeatureCategoryItem::where('feature_category_id', $feature_category_id)->get();
    }

    public function findFeatureCategoryItem($feature_category_item_id)
    {
        return FeatureCategoryItem::findOrFail($feature_category_item_id);
    }

    public function getProductByFeatureCategoryID($feature_category_id)
    {
        return FeatureCategoryItem::join('products', static function ($query) {
            $query->on('products.id', '=', 'feature_category_items.product_id');
            $query->leftJoin('product_discounts', static function ($query) {
                $query->on('products.id', '=', 'product_discounts.product_id');
            });
        })
            ->leftJoin('brands', static function ($query) {
                $query->on('brands.id', '=', 'products.brand_id');
            })
            ->join('categories', static function ($query) {
                $query->on('categories.id', '=', 'products.category_id');
            })
            ->where('feature_category_items.feature_category_id', $feature_category_id)
            ->where('products.status', EProductStatus::active)
            ->where('products.is_approved', 1)
            ->select([
                DB::raw('products.id as id'),
                DB::raw('products.product_code as product_code'),
                DB::raw('products.title as title'),
                DB::raw('products.status as status'),
                DB::raw('products.product_price as product_price'),
                DB::raw('feature_category_items.id as feature_category_item_id'),
                DB::raw('categories.name as category_name'),
                DB::raw('brands.title as brand_name'),
                DB::raw('product_discounts.discount_percent as discount_percent'),
                DB::raw('product_discounts.discount_amount as discount_amount'),
                DB::raw('(products.product_price - product_discounts.discount_amount) as final_product_price'),
                DB::raw('feature_category_items.feature_category_image as feature_category_image'),
            ])
            ->get();
    }

    public function deleteFeatureCategoryItem($_featureCategoryItem)
    {
        return DB::transaction(static function () use ($_featureCategoryItem) {
            return $_featureCategoryItem->delete();
        });
    }

    public function getFeatureItemList($feature_category_id)
    {
        return FeatureCategoryItem::join('products', static function ($query) {
            $query->on('products.id', '=', 'feature_category_items.product_id');
            $query->leftJoin('product_discounts', static function ($query) {
                $query->on('products.id', '=', 'product_discounts.product_id');
            });
        })->where('feature_category_items.feature_category_id', $feature_category_id)
            ->where('products.status', EProductStatus::active)
            ->where('products.is_approved', 1)
            ->select([
                DB::raw('products.id as product_id'),
                DB::raw('products.product_code as product_code'),
                DB::raw('products.slug as product_slug'),
                DB::raw('products.title as product_title'),
                DB::raw('products.sub_title as product_sub_title'),
                DB::raw('products.cover_image as cover_image'),
                DB::raw('products.status as status'),
                DB::raw('products.color_status as color_status'),
                DB::raw('products.product_price as product_price'),
                DB::raw('products.tag_type as tag_type'),
                DB::raw('products.tag_name as tag_name'),
                DB::raw('feature_category_items.id as feature_category_item_id'),
                DB::raw('feature_category_items.feature_category_image as feature_category_image'),
            ])->get();
    }


    public function getRandomFeatureItemList()
    {
        return FeatureCategoryItem::join('products', static function ($query) {
            $query->on('products.id', '=', 'feature_category_items.product_id');
            $query->leftJoin('product_discounts', static function ($query) {
                $query->on('products.id', '=', 'product_discounts.product_id');
            });
        })->where('products.status', EProductStatus::active)
            ->where('products.is_approved', 1)
            ->select([
                DB::raw('products.id as product_id'),
                DB::raw('products.product_code as product_code'),
                DB::raw('products.slug as product_slug'),
                DB::raw('products.title as product_title'),
                DB::raw('products.sub_title as product_sub_title'),
                DB::raw('products.cover_image as cover_image'),
                DB::raw('products.status as status'),
                DB::raw('products.color_status as color_status'),
                DB::raw('products.product_price as product_price'),
                DB::raw('products.tag_type as tag_type'),
                DB::raw('products.tag_name as tag_name'),
                DB::raw('feature_category_items.id as feature_category_item_id'),
                DB::raw('product_discounts.discount_percent as discount_percent'),
                DB::raw('product_discounts.discount_amount as discount_amount'),
                DB::raw('(products.product_price - product_discounts.discount_amount) as final_product_price'),
                DB::raw('feature_category_items.feature_category_image as feature_category_image'),
            ])->inRandomOrder()
            ->limit(10)->get();
    }

    public function updateFeatureCategoryItem(FeatureCategoryItem $featureCategoryItem, $data): mixed
    {
        return DB::transaction(static function () use ($featureCategoryItem, $data) {
            return $featureCategoryItem->update($data);
        });
    }

    public function getRecommendedItemList($category_ids)
    {
        return Category::join('products', static function ($query) {
            $query->on('categories.id', '=', 'products.category_id');
            $query->leftJoin('product_discounts', static function ($query) {
                $query->on('products.id', '=', 'product_discounts.product_id');
            });
        })->whereIn('categories.id', $category_ids)
            ->where('products.status', EProductStatus::active)
            ->where('products.is_approved', 1)
            ->select([
                DB::raw('products.id as product_id'),
                DB::raw('products.product_code as product_code'),
                DB::raw('products.slug as product_slug'),
                DB::raw('products.title as product_title'),
                DB::raw('products.sub_title as product_sub_title'),
                DB::raw('products.cover_image as cover_image'),
                DB::raw('products.status as status'),
                DB::raw('products.color_status as color_status'),
                DB::raw('products.product_price as product_price'),
                DB::raw('products.tag_type as tag_type'),
                DB::raw('products.tag_name as tag_name'),
                DB::raw('product_discounts.discount_percent as discount_percent'),
                DB::raw('product_discounts.discount_amount as discount_amount'),
                DB::raw('(products.product_price - product_discounts.discount_amount) as final_product_price'),
            ])->inRandomOrder()
            ->limit(15)->get();
    }


}
