<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnDetail extends Model
{
    use HasFactory;

    protected $table = 'return_details';

    protected $fillable = [
        'return_id',
        'order_detail_id',
        'so_luong',
        'gia_tra',
        'ly_do_chi_tiet',
    ];

    protected $casts = [
        'so_luong' => 'integer',
        'gia_tra' => 'decimal:2',
    ];

    // Mối quan hệ với bảng returns
    public function return()
    {
        return $this->belongsTo(ReturnModel::class, 'return_id');
    }

    // Mối quan hệ với bảng order_details
    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class, 'order_detail_id');
    }
}