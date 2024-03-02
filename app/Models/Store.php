<?php

namespace App\Models;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'name',
        'description',
        'address',
        'city',
        'email',
        'phone',
        'industry',
        'logo',
        'social_media_links',
        'return_policy',
        'shipping_policy',
        'rating',
        'rating_count',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
