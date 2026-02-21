<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'retailer_id',
        'name',
        'price',
        'currency',
    ];
}
