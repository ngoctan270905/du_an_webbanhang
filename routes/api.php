<?php

use App\Models\Ward;
use App\Models\District;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;


// Mặc định apiResource sẽ trỏ tới 5 hàm mặc định trong controller api
// Nếu muốn tạo ra các phương thức mới trong controller api
// thì ta phải tạo thêm các route khác để trỏ riêng tới phương thức đó
Route::apiResource('products', ProductController::class);
Route::get('/districts/{province_code}', function ($provinceCode) {
  return District::where('parent_code', $provinceCode)->get();
});

Route::get('/wards/{district_code}', function ($districtCode) {
  return Ward::where('parent_code', $districtCode)->get();
});
