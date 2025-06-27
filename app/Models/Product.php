<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'categoryid',
        'ean_code',
        'category',
        'stock',
        'expiry_date',
        'comment',
        'isactive',
        'dateadded',
        'datechanged',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'isactive' => 'boolean',
        'dateadded' => 'datetime',
        'datechanged' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryid');
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function packageItems()
    {
        return $this->hasMany(PackageItem::class);
    }
}
