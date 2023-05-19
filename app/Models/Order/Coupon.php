<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "coupons";
    protected $fillable = [
        'campaign_name',
        'campaign_code',
        'campaign_image',
        'coupon_for',
        'coupon_apply_on',
        'coupon_type',
        'coupon_value',
        'min_amount',
        'max_amount',
        'product_type',
        'starting_date',
        'expiry_date',
        'status',
        'created_by',
        'updated_by',
    ];
    protected $appends = ['image_path'];

    CONST COUPON_FOR = [
       'all',
       'category',
       'brand',
       'product'
    ];

    /**
     * @return string
     */
    public function getImagePathAttribute(): string
    {
        $path = asset('/front/uploads/coupon');
        return $path . '/' . $this->campaign_image;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(static function ($model) {
            $model->created_by = Auth::user()->id;
            $model->updated_by = Auth::user()->id;
        });

        static::updating(static function ($model) {
            $model->updated_by = Auth::user()->id;
        });
    }


}
