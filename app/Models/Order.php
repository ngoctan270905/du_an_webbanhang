<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'ma_don_hang',
        'id_nguoi_dung',
        'tong_tien',
        'trang_thai',
        'dia_chi_giao_hang',
        'ho_ten_khach_hang',
        'so_dien_thoai',
        'province_code',
        'district_code',
        'ward_code',
        'phuong_thuc_thanh_toan',
        'ngay_dat_hang',
    ];

    protected $casts = [
        'tong_tien' => 'decimal:2',
        'trang_thai' => 'string', // Enum: 'pending', 'processing', 'shipped', 'delivered', 'cancelled'
        'phuong_thuc_thanh_toan' => 'string', // Enum: 'cod', 'bank_transfer', 'online_payment'
        'ngay_dat_hang' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_nguoi_dung');
    }

    // Quan hệ với OrderDetail
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id_don_hang');
    }

    // Quan hệ với Payment
    public function payment()
    {
        return $this->hasOne(Payment::class, 'id_don_hang');
    }

    // Quan hệ với Province
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    // Quan hệ với District
    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }

    // Quan hệ với Ward
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_code', 'code');
    }
}
