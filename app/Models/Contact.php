<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contacts';

    protected $fillable = [
        'ho_ten',
        'so_dien_thoai',
        'noi_dung',
        'trang_thai',
        'email'

    ];

    protected $casts = [
        'trang_thai' => 'boolean'
    ];

    public function replies()
    {
        return $this->hasMany(ContactReply::class);
    }
}
