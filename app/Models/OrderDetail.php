<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $fillable = [
        'id_don_hang',
        'id_san_pham',
        'so_luong',
        'gia',
    ];

    protected $casts = [
        'gia' => 'decimal:2',
        'so_luong' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Quan hệ với Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'id_don_hang');
    }

    // Quan hệ với Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_san_pham');
    }
}