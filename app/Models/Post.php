<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'tieu_de',
        'noi_dung',
        'hinh_anh',
        'trang_thai'
    ];

    protected $casts = [
        'trang_thai' => 'boolean'
    ];
} 