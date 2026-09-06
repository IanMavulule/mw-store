<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'product_variant_id',
        'client_id',
        'quantity',
    ];

    public function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
