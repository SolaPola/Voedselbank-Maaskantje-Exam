<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'categoriesid',
        'ean_code',
        'stock',
        'expiry_date',
        'comment',
        'isactive',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'isactive' => 'boolean',
    ];

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoriesid');
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
