<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'sort_order'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Chỉ lấy món còn bán
    public function availableProducts()
    {
        return $this->hasMany(Product::class)->where('is_available', true);
    }
}