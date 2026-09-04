<?php

namespace App\Models;

use App\Enums\SizeType;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = [
        'type',
        'label',
    ];

    protected $casts = [
        'type' => SizeType::class,
    ];
}
