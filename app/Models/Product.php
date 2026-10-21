<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'supplier_id',
        'name',
        'sku',
        'category',
        'price',
        'stock',
        'safety_stock',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}