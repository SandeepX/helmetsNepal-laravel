<?php

namespace App\Models\Product;

use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Models\FeatureCategory\FeatureCategoryItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "products";

    protected $fillable = [
        'title',
        'sub_title',
        'product_code',
        'slug',
        'cover_image',

        'short_details',
        'details',

        'product_price',
        'sku',

        'tag_type',
        'tag_name',

        'category_id',
        'brand_id',
        'product_graphic_id',
        'product_model_id',
        'manufacture_id',

        'size_status',
        'color_status',
        'custom_status',

        'is_approved',

        'meta_title',
        'meta_keys',
        'meta_description',
        'alternate_text',

        'is_feature',
        'is_returnable',
        'status',

        'quantity',
        'minimum_quantity',
        'vendor_price',

        'is_approved_by',
        'created_by',
        'updated_by',
    ];

    protected $appends = ['product_cover_image_path', 'final_product_price', 'product_discount'];


    public static function boot()
    {
        parent::boot();

        static::creating(static function ($model) {
            $model->created_by = Auth::user()->id;
            $model->updated_by = Auth::user()->id;
        });

        static::updating(static function ($model) {
            $model->updated_by = Auth::user()->id ?? 1;
        });
    }

    public function getProductCoverImagePathAttribute(): string
    {
        $path = asset('/front/uploads/product_cover_image');
        return $path . '/img-' . $this->cover_image;
    }

    public function getFinalProductPriceAttribute()
    {
        $_productDiscount = $this->getProductDiscountAttribute();
        if ($_productDiscount) {
            return (float)$this->product_price - (float)$_productDiscount['discount_amount'];
        }
        return $this->product_price;
    }

    public function getProductDiscountAttribute(): ?array
    {
        $_productDiscount = ProductDiscount::whereDate('discount_start_date', '<=', Helper::smTodayInYmd())
            ->whereDate('discount_end_date', '>=', Helper::smTodayInYmd())
            ->where('product_id', $this->id)
            ->where('status', EStatus::active)->first();

        if ($_productDiscount) {
            return ['discount_percent' => $_productDiscount->discount_percent ?? 0, 'discount_amount' => $_productDiscount->discount_amount ?? 0];
        }
        return ['discount_percent' => 0, 'discount_amount' => 0];;

    }

    public function getCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function getBrand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function getProductGraphic(): BelongsTo
    {
        return $this->belongsTo(ProductGraphic::class, 'product_graphic_id', 'id');
    }

    public function getProductModel(): BelongsTo
    {
        return $this->belongsTo(ProductModel::class, 'product_model_id', 'id');
    }

    public function geManufacture(): BelongsTo
    {
        return $this->belongsTo(Manufacture::class, 'manufacture_id', 'id');
    }

    public function getProductImage(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function getProductDiscount(): HasMany
    {
        return $this->hasMany(ProductDiscount::class, 'product_id', 'id');
    }

    public function getProductSize(): HasMany
    {
        return $this->hasMany(ProductSize::class, 'product_id', 'id');
    }

    public function getProductCustom(): HasOne
    {
        return $this->hasOne(ProductCustom::class, 'product_id', 'id');
    }

    public function getProductColor(): HasMany
    {
        return $this->hasMany(ProductColor::class, 'product_id', 'id');
    }
    public function getFeatureCategoryItem(): HasMany
    {
        return $this->hasMany(FeatureCategoryItem::class, 'product_id', 'id');
    }

}
