<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use HasFactory;

    protected $table = 'districts';

    // Primary key là code
    protected $primaryKey = 'code';
    public $incrementing = false; // code là string, không auto increment
    protected $keyType = 'string';

    // Các cột có thể gán
    protected $fillable = [
        'code',
        'name',
        'type',
        'name_with_type',
        'path_with_type',
        'parent_code', // mã tỉnh
    ];

    /**
     * Quan hệ: District thuộc Province
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'parent_code', 'code');
    }

    /**
     * Quan hệ: District có nhiều Wards
     */
    public function wards()
    {
        return $this->hasMany(Ward::class, 'parent_code', 'code');
    }
}
