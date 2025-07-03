<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'food_package_id',
        'product_id',
        'product_name',
        'amount',
        'comment',
        'isactive',
        'dateadded',
        'datechanged',
    ];

    protected $casts = [
        'isactive' => 'boolean',
        'dateadded' => 'datetime',
        'datechanged' => 'datetime',
    ];

    public function foodPackage()
    {
        return $this->belongsTo(FoodPackage::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
