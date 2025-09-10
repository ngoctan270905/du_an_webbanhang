<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reviews';

    protected $fillable = [
        'id_nguoi_dung',
        'id_san_pham',
        'noi_dung',
        'image',
        'rating',
        'trang_thai'
    ];

    protected $casts = [
        'trang_thai' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_nguoi_dung');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_san_pham');
    }

    public function reviewReply()
    {
        return $this->hasOne(ReviewReply::class, 'review_id');
    }
}
