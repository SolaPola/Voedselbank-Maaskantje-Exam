<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_name',
        'supplier_id',
        'product_id',
        'amount',
        'delivery_date',
        'comment',
        'isactive',
        'dateadded',
        'datechanged',
    ];

    protected $casts = [
        'delivery_date' => 'date',
        'isactive' => 'boolean',
        'dateadded' => 'datetime',
        'datechanged' => 'datetime',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
