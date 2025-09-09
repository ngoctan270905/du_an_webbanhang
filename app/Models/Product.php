<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'ma_san_pham',
        'ten_san_pham',
        'author',
        'publisher',
        'published_year',
        'category_id',
        'hinh_anh',
        'gia',
        'gia_khuyen_mai',
        'so_luong',
        'ngay_nhap',
        'mo_ta',
        'trang_thai',
    ];

    protected $dates = ['deleted_at'];
    // Tạo mối liên hệ với danh mục
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_san_pham', 'id');
    }
}
