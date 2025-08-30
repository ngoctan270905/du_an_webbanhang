<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'banners';

    protected $fillable = [
        'tieu_de',
        'hinh_anh',
        'trang_thai'
    ];

    protected $casts = [
        'trang_thai' => 'boolean'
    ];
}