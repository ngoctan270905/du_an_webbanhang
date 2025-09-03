<?php
// app/Models/CartItem.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
  use HasFactory;

  protected $fillable = [
    'id_nguoi_dung',
    'id_san_pham',
    'so_luong',
    'gia',
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'id_nguoi_dung');
  }

  public function product()
  {
    return $this->belongsTo(Product::class, 'id_san_pham');
  }
}
