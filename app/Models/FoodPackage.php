<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'issued_at',
        'comment',
        'isactive',
        'dateadded',
        'datechanged',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'isactive' => 'boolean',
        'dateadded' => 'datetime',
        'datechanged' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function packageItems()
    {
        return $this->hasMany(PackageItem::class);
    }
}
