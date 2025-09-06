<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ward extends Model
{
  use HasFactory;

  protected $table = 'wards';

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
    'parent_code', // mã quận/huyện
  ];

  /**
   * Quan hệ: Ward thuộc District
   */
  public function district()
  {
    return $this->belongsTo(District::class, 'parent_code', 'code');
  }

  public function province()
  {
    return $this->district->province();
  }

  // Accessor để kiểm tra loại
  public function getIsCommune()
  {
    return $this->type === 'xa';
  }

  public function getIsWard()
  {
    return $this->type === 'phuong';
  }

  public function getIsTown()
  {
    return $this->type === 'thi-tran';
  }
}
