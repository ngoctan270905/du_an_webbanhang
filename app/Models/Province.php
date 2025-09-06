<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use HasFactory;
    protected $table = 'provinces';
    
    // Primary key là code chứ không phải id
    protected $primaryKey = 'code';
    public $incrementing = false; // vì code là string
    protected $keyType = 'string';

    // Các cột có thể gán (fillable)
    protected $fillable = [
        'code',
        'name',
        'slug',
        'type',
        'name_with_type',
    ];

    // Quan hệ với districts
    public function districts()
    {
        return $this->hasMany(District::class, 'parent_code', 'code');
    }
}
