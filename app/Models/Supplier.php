<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'contact_name',
        'contact_email',
        'phone',
        'next_delivery',
        'comment',
        'isactive',
        'dateadded',
        'datechanged',
    ];

    protected $casts = [
        'next_delivery' => 'date',
        'isactive' => 'boolean',
        'dateadded' => 'datetime',
        'datechanged' => 'datetime',
    ];

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
