<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'description',
        'brand_id',
        'article_id',
        'base_price',
        'bought_price',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
