<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsLetterSubscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "news_letter_subscriptions";
    protected $fillable = [
        'email',
        'status',
    ];
}
