<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'id_don_hang',
        'phuong_thuc_thanh_toan',
        'so_tien',
        'trang_thai',
        'ma_giao_dich',
    ];

    protected $casts = [
        'phuong_thuc_thanh_toan' => 'string', // Enum: 'cod', 'bank_transfer', 'online_payment'
        'trang_thai' => 'string', // Enum: 'pending', 'completed', 'failed'
        'so_tien' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Quan hệ với Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'id_don_hang');
    }
}