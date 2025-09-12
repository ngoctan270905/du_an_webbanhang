<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'returns';

    protected $fillable = [
        'ma_tra_hang',
        'order_id',
        'user_id',
        'ngay_yeu_cau',
        'ly_do_tra_hang',
        'trang_thai',
        'ghi_chu_admin',
        'tong_tien_hoan',
        'phuong_thuc_hoan_tien',
        'bank_details',
        'ngay_hoan_tien',
    ];

    protected $casts = [
        'ngay_yeu_cau' => 'datetime',
        'ngay_hoan_tien' => 'datetime',
        'tong_tien_hoan' => 'decimal:2',
        'trang_thai' => 'string',
        'phuong_thuc_hoan_tien' => 'string',
    ];

    // Mối quan hệ với bảng orders
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Mối quan hệ với bảng users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Mối quan hệ với bảng return_details
    public function returnDetails()
    {
        return $this->hasMany(ReturnDetail::class, 'return_id');
    }
}