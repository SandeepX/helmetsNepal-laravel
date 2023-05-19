<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDetails extends Model
{
    use HasFactory;

    protected $table = "company_details";
    protected $fillable = [
        'logo',
        'address',
        'email',
        'contact_no',
        'contact_person',
        'google_map_link',
        'facebook_link',
        'instagram_link',
        'twitter_link',
        'youtube_link',
        'youtube_link',
        'frontend_link',
    ];
    protected $appends = ['logo_image_path'];


    /**
     * @return string
     */
    public function getLogoImagePathAttribute(): string
    {
        $path = asset('/front/uploads/companyDetail');
        return $path . '/img-' . $this->logo;
    }
}
