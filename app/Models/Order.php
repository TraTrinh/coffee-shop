<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_code', 'user_id', 'customer_name', 'customer_phone',
        'address', 'note', 'total_amount', 'order_type', 'status',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public const STATUSES = [
        'pending'   => 'Chờ xác nhận',
        'confirmed' => 'Đã xác nhận',
        'preparing' => 'Đang pha chế',
        'completed' => 'Hoàn thành',
        'cancelled' => 'Đã huỷ',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    // Sinh mã đơn dạng CF20260823-4821
    public static function generateCode(): string
    {
        return 'CF' . date('Ymd') . '-' . str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    }
}