<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description',
        'price', 'image', 'is_available',
    ];

    protected $casts = [
        'price'        => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Giá theo size: S giữ nguyên, M +5k, L +10k
    public function priceBySize(string $size): float
    {
        return (float) $this->price + match ($size) {
            'S'     => 0,
            'M'     => 5000,
            'L'     => 10000,
            default => 0,
        };
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('images/products/' . $this->image)
            : 'https://placehold.co/400x400?text=No+Image';
    }
}