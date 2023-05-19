<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $table = "contact_us";
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'message',
        'status',
    ];

    protected $appends = ['full_name'];


    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . " " . $this->last_name;
    }

}
