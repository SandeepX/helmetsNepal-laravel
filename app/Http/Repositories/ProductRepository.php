<?php

namespace App\Http\Repositories;

use App\Helper\Helper;
use App\Http\Enums\EProductStatus;
use App\Http\Enums\EStatus;
use App\Models\Product\Product;
use App\Models\Product\ProductAttribute;
use App\Models\Product\ProductColor;
use App\Models\Product\ProductCustom;
use App\Models\Product\ProductDiscount;
use App\Models\Product\ProductImage;
use App\Models\Product\ProductSize;
use Illuminate\Support\Facades\DB;
use LaravelIdea\Helper\App\Models\Product\_IH_Product_C;

class ProductRepository
{
    private Product $product;

    public function __construct()
    {
        $this->product = new Product();
    }


    public function findALl(array $filter): mixed
    {
        return $this->product->when(array_keys($filter, true), function ($query) use ($filter) {
            if (isset($filter['search'])) {
                $query->where(function ($q) use ($filter) {
                    $q->orWhere('title', 'like', '%' . $filter['search'] . '%');
                    $q->orWhere('sub_title', 'like', '%' . $filter['search'] . '%');
                    $q->orWhere('tag_name', 'like', '%' . $filter['search'] . '%');
                    $q->orWhere('details', 'like', '%' . $filter['search'] . '%');
                    $q->orWhere('title', 'like', '%' . $filter['search'] . '%');
                });
            }
            if (isset($filter['category_id'])) {
                $query->where('category_id', '=', $filter['category_id']);
            }
            if (isset($filter['brand_id'])) {
                $query->where('brand_id', '=', $filter['brand_id']);
            }
        })->orderBy('id', 'desc')
            ->paginate(10);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->product->create($data);
        });
    }

    /**
     * @param string $image
     * @param int $product_id
     * @return void
     */
    public function saveProductImage(string $image, int $product_id): void
    {
        ProductImage::create(['image' => $image, 'product_id' => $product_id, 'status' => EStatus::active,]);
    }

    public function saveProductDiscount($data): void
    {
        ProductDiscount::create($data);
    }

    public function getProductImage(int $product_id)
    {
        return ProductImage::where('product_id', $product_id)->get();
    }

    public function findProductImage(int $productImage_id): mixed
    {
        return ProductImage::findOrFail($productImage_id);
    }

    public function deleteProductImage(ProductImage $productImage): mixed
    {
        return DB::transaction(static function () use ($productImage) {
            return $productImage->delete();
        });
    }

    /**
     * @param Product $product
     * @return mixed
     */
    public function delete(Product $product): mixed
    {
        return DB::transaction(static function () use ($product) {
            return $product->delete();
        });
    }

    public function saveProductAttribute($saveData)
    {
        return DB::transaction(static function () use ($saveData) {
            return ProductAttribute::create($saveData);
        });

    }

    public function findProductAttribute(int $productAttributeDetail_id): mixed
    {
        return ProductAttribute::findOrFail($productAttributeDetail_id);
    }

    public function findProductAttributeByProductId(int $product_id): mixed
    {
        return ProductAttribute::where('product_id', $product_id)->first();
    }

    public function updateProductAttribute(ProductAttribute $productAttribute, $data): mixed
    {
        return DB::transaction(static function () use ($productAttribute, $data) {
            return $productAttribute->update($data);
        });
    }

    public function getAllActiveProductList($select = ['*'])
    {
        return $this->product->select($select)
            ->where('status', EProductStatus::active)
            ->get();
    }

    /**
     * @param $product
     * @param $data
     * @return mixed
     */
    public function update($product, $data): mixed
    {
        return DB::transaction(static function () use ($product, $data) {
            return $product->update($data);
        });
    }

    public function getProductSearch($search)
    {
        return Product::leftJoin('categories', static function ($query) {
            $query->on('products.category_id', '=', 'categories.id');
        })->leftJoin('brands', static function ($query) {
            $query->on('products.brand_id', '=', 'brands.id');
        })->orWhere('brands.title', 'LIKE', "%$search%")->orWhere('categories.name', 'LIKE', "%$search%")->orWhere('products.title', 'LIKE', "%$search%")->orWhere('products.sub_title', 'LIKE', "%$search%")->orWhere('products.product_code', 'LIKE', "%$search%")->orWhere('products.sku', 'LIKE', "%$search%")->select([DB::raw('products.id as id'), DB::raw('products.title as name'),])->get();
    }

    public function getProductDetailsWithDiscount(Product $product)
    {
        return $product->getProductDiscount()->whereDate('discount_start_date', '<=', Helper::smTodayInYmd())->whereDate('discount_end_date', '>=', Helper::smTodayInYmd())->where('status', EProductStatus::active)->first();
    }

    public function getProductDiscount($product_id)
    {
        return ProductDiscount::whereDate('discount_start_date', '<=', Helper::smTodayInYmd())->whereDate('discount_end_date', '>=', Helper::smTodayInYmd())->where('status', EProductStatus::active)->where('product_id', $product_id)->first();
    }

    public function findActiveProduct($product_id)
    {
        return $this->product->where('id', $product_id)->where('status', EProductStatus::active)->where('is_approved', 1)->first();
    }

    public function findActiveProductBySlug($product_slug)
    {
        return $this->product->where('slug', $product_slug)->where('status', EProductStatus::active)->where('is_approved', 1)->first();
    }

    public function getActiveProductList($product_id)
    {
        return $this->product->where('id', $product_id)->where('status', EProductStatus::active)->where('is_approved', 1)->pluck('title', 'product_code');
    }

    public function saveProductSize($product_id, $size_id)
    {
        ProductSize::create(['product_id' => $product_id, 'size_id' => $size_id,]);
    }

    public function saveProductCustom($product_id, $product_custom_attributes, $product_custom_attribute_value)
    {
        ProductCustom::create(['product_id' => $product_id, 'product_custom_attributes' => $product_custom_attributes, 'product_custom_attribute_value' => $product_custom_attribute_value,]);
    }

    public function saveProductColor($product_id, $color_id_1, $color_id_2, $color_gradient, $product_image_color, $quantity, $barcode)
    {
        return ProductColor::create(['product_id' => $product_id, 'color_id_1' => $color_id_1, 'color_id_2' => $color_id_2, 'color_gradient' => (bool)$color_gradient, 'product_image_color' => $product_image_color, 'quantity' => $quantity, 'barcode' => $barcode]);
    }

    public function findProductColor($product_color_id)
    {
        return ProductColor::find($product_color_id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->product->findOrFail($id);
    }

    public function getProductColor($product_id)
    {
        return ProductColor::where('product_id', $product_id)->get();
    }

    public function updateProductColor(ProductColor $productColor, $data): mixed
    {
        return DB::transaction(static function () use ($productColor, $data) {
            return $productColor->update($data);
        });
    }

    public function deleteProductColor(ProductColor $productColor): mixed
    {
        return DB::transaction(static function () use ($productColor) {
            return $productColor->delete();
        });
    }

    public function productDiscountList($product_id)
    {
        return ProductDiscount::where('product_id', $product_id)->get();
    }


    /**
     * @param int $category_id
     * @param int $per_page
     * @param string $orderByll
     * @param string $orderByType
     * @param array $filter
     * @return mixed
     */
    public function getActiveProductListByCategory(array $category_ids, int $per_page, string $orderBy = 'id', string $orderByType = 'desc', array $filter = []): mixed
    {
        return $this->product->join('categories', static function ($query) {
            $query->on('products.category_id', '=', 'categories.id');
        })->leftJoin('brands', static function ($query) {
            $query->on('products.brand_id', '=', 'brands.id');
        })->when(array_keys($filter, true), function ($query) use ($filter) {
            if (isset($filter['search'])) {
                $query->where(function ($q) use ($filter) {
                    $q->orWhere('products.title', 'like', '%' . $filter['search'] . '%');
                    $q->orWhere('products.sub_title', 'like', '%' . $filter['search'] . '%');
                    $q->orWhere('products.short_details', 'like', '%' . $filter['search'] . '%');
                    $q->orWhere('categories.name', 'like', '%' . $filter['search'] . '%');
                    $q->orWhere('brands.title', 'like', '%' . $filter['search'] . '%');
                });
            }
            if (!is_null($filter['brand_id'] ?? null)) {
                $query->whereIn('products.brand_id', $filter['brand_id']);
            }
            if (!is_null($filter['product_graphic_id'] ?? null)) {
                $query->whereIn('products.product_graphic_id', $filter['product_graphic_id']);
            }
            if (!is_null($filter['product_model_id'] ?? null)) {
                $query->whereIn('products.product_model_id', $filter['product_model_id']);
            }
            if (!is_null($filter['color_id'] ?? null)) {
                $query->leftJoin('product_colors', static function ($q) {
                    $q->on('product_colors.product_id', '=', 'products.id');
                });
                $query->whereIn('product_colors.color_id_1', $filter['color_id']);
            }
        })
            ->select([
                DB::raw('products.id as id'),
                DB::raw('products.tag_type as tag_type'),
                DB::raw('products.tag_name as tag_name'),
                DB::raw('products.title as product_title'),
                DB::raw('products.slug as product_slug'),
                DB::raw('products.product_price as product_price'),
                DB::raw('products.cover_image as cover_image'),
                DB::raw('products.color_status as color_status'),
                DB::raw('products.brand_id as brand_id'),
                DB::raw('products.product_model_id as product_model_id'),

            ])
            ->where(function ($query) use ($filter) {
                if (!is_null($filter['min_price'] ?? null) && !is_null($filter['max_price'] ?? null)) {
                    $query->whereBetween('products.product_price', [$filter['min_price'], $filter['max_price']]);
                }
            })
            ->whereIn('products.category_id', $category_ids)
            ->where('products.status', EProductStatus::active)
            ->where('products.is_approved', 1)
            ->orderBy('products.' . $orderBy, $orderByType);
//            ->paginate($per_page);
    }


    public function getActiveProductListByCategoryForFilter(array $category_ids): mixed
    {
        return $this->product->select([
                DB::raw('products.brand_id as brand_id'),
                DB::raw('products.product_model_id as product_model_id'),
            ])->whereIn('products.category_id', $category_ids)
            ->where('products.status', EProductStatus::active)
            ->where('products.is_approved', 1)
            ->orderBy('products.' . 'id', 'desc');
    }

    public function getActiveProductListByParentCategory(array $category_id, int $per_page, string $orderBy = 'id', string $orderByType = 'desc', array $filter = []): mixed
    {
        return $this->product->join('categories', static function ($query) {
            $query->on('products.category_id', '=', 'categories.id');
        })->leftJoin('brands', static function ($query) {
            $query->on('products.brand_id', '=', 'brands.id');
        })->when(array_keys($filter, true), function ($query) use ($filter) {
            if (isset($filter['search'])) {
                $query->where(function ($q) use ($filter) {
                    $q->orWhere('products.title', 'like', '%' . $filter['search'] . '%');
                    $q->orWhere('products.sub_title', 'like', '%' . $filter['search'] . '%');
                    $q->orWhere('products.short_details', 'like', '%' . $filter['search'] . '%');
                    $q->orWhere('categories.name', 'like', '%' . $filter['search'] . '%');
                    $q->orWhere('brands.title', 'like', '%' . $filter['search'] . '%');
                });
            }
            if (!is_null($filter['brand_id'] ?? null)) {
                $query->where('products.brand_id', $filter['brand_id']);
            }
            if (!is_null($filter['product_graphic_id'] ?? null)) {
                $query->where('products.product_graphic_id', $filter['product_graphic_id']);
            }
            if (!is_null($filter['product_model_id'] ?? null)) {
                $query->where('products.product_model_id', $filter['product_model_id']);
            }
        })->select([
            DB::raw('products.id as id'),
            DB::raw('products.tag_type as tag_type'),
            DB::raw('products.tag_name as tag_name'),
            DB::raw('products.title as product_title'),
            DB::raw('products.slug as product_slug'),
            DB::raw('products.product_price as product_price'),
            DB::raw('products.cover_image as cover_image'),
            DB::raw('products.color_status as color_status'),
        ])->where(function ($query) use ($filter) {
            if (!is_null($filter['min_price'] ?? null) && !is_null($filter['max_price'] ?? null)) {
                $query->whereBetween('products.product_price', [$filter['min_price'], $filter['max_price']]);
            }
        })
            ->whereIn('products.category_id', $category_id)
            ->where('products.status', EProductStatus::active)
            ->where('products.is_approved', 1)
            ->orderBy('products.' . $orderBy, $orderByType)
            ->paginate($per_page);

    }

    public function getProductColorDetails($product_id)
    {
        return ProductColor::join('colors as color_1', static function ($query) {
            $query->on('product_colors.color_id_1', '=', 'color_1.id');
        })->join('colors as color_2', static function ($query) {
            $query->on('product_colors.color_id_2', '=', 'color_2.id');
        })->where('product_id', $product_id)->select([
            DB::raw('product_colors.id as id'),
            DB::raw('color_1.name as color_1_name'),
            DB::raw('color_1.color_value as color_1_color_value'),
            DB::raw('color_2.name as color_2_name'),
            DB::raw('color_2.color_value as color_2_color_value'),
            DB::raw('product_colors.color_gradient as color_gradient'),
            DB::raw('product_colors.product_image_color as product_image_color'),
            DB::raw('product_colors.quantity as quantity')
        ])->get();
    }

    public function getProductSizeDetails($product_id)
    {
        return ProductSize::join('sizes', static function ($query) {
            $query->on('product_sizes.size_id', '=', 'sizes.id');
        })->where('product_sizes.product_id', $product_id)->select([
            DB::raw('product_sizes.id as product_size_id'),
            DB::raw('sizes.name as size_name'),
        ])->get();
    }

    public function searchProductByTitle($paginate = 20, $title = null, $min_amount = 0, $max_amount = null)
    {
        return $this->product->where(function ($query) use ($title) {
            if (isset($title)) {
                $query->orWhere('title', 'like', '%' . $title . '%');
                $query->orWhere('sub_title', 'like', '%' . $title . '%');
                $query->orWhere('short_details', 'like', '%' . $title . '%');
                $query->orWhere('details', 'like', '%' . $title . '%');
            }
        })->where(function ($query) use ($min_amount, $max_amount) {
            if (isset($min_amount, $max_amount)) {
                $query->whereBetween('product_price', [$min_amount, $max_amount]);
            }
        })->paginate($paginate);
    }


    public function searchProductByCategory(int $category_id, $paginate = 20, $title = null, $min_amount = 0, $max_amount = null)
    {
        return $this->product->join('categories', static function ($query) {
            $query->on('products.category_id', '=', 'categories.id');
        })->where('products.category_id', $category_id)
            ->where(function ($query) use ($title) {
                if (isset($title)) {
                    $query->orWhere('title', 'like', '%' . $title . '%');
                    $query->orWhere('sub_title', 'like', '%' . $title . '%');
                    $query->orWhere('short_details', 'like', '%' . $title . '%');
                    $query->orWhere('details', 'like', '%' . $title . '%');
                }
            })->where(function ($query) use ($min_amount, $max_amount) {
                if (isset($min_amount, $max_amount)) {
                    $query->whereBetween('product_price', [$min_amount, $max_amount]);
                }
            })->paginate($paginate);
    }

    public function searchProductByParentCategory(array $category, int $paginate = 20, $title = null, $min_amount = 0, $max_amount = null)
    {
        return $this->product->join('categories', static function ($query) {
            $query->on('products.category_id', '=', 'categories.id');
        })->whereIn('products.category_id', $category)
            ->where(function ($query) use ($title) {
                if (isset($title)) {
                    $query->orWhere('title', 'like', '%' . $title . '%');
                    $query->orWhere('sub_title', 'like', '%' . $title . '%');
                    $query->orWhere('short_details', 'like', '%' . $title . '%');
                    $query->orWhere('details', 'like', '%' . $title . '%');
                }
            })->where(function ($query) use ($min_amount, $max_amount) {
                if (isset($min_amount, $max_amount)) {
                    $query->whereBetween('product_price', [$min_amount, $max_amount]);
                }
            })
            ->paginate($paginate);
    }


    public function getActiveProductListByBrand(int $brand_id, int $per_page, string $orderBy = 'id', string $orderByType = 'desc'): mixed
    {
        return $this->product->join('brands', static function ($query) {
            $query->on('products.brand_id', '=', 'brands.id');
        })->select([
            DB::raw('products.id as id'),
            DB::raw('products.tag_type as tag_type'),
            DB::raw('products.tag_name as tag_name'),
            DB::raw('products.title as product_title'),
            DB::raw('products.slug as product_slug'),
            DB::raw('products.product_price as product_price'),
            DB::raw('products.cover_image as cover_image'),
            DB::raw('products.color_status as color_status'),
        ])
            ->where('products.brand_id', $brand_id)
            ->where('products.status', EProductStatus::active)
            ->where('products.is_approved', 1)
            ->orderBy('products.' . $orderBy, $orderByType)
            ->paginate($per_page);
    }


}
