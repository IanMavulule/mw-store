<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'size_id',
        'color_id',
        'second_color_id',
        'price',
        'stock',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function secondColor()
    {
        return $this->belongsTo(Color::class, 'second_color_id');
    }

    public function getEffectivePriceAttribute()
    {
        return $this->price ?? $this->product->base_price;
    }

    public function images()
    {
        return $this->hasMany(Image::class)->orderBy('sort_order')->orderBy('id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
