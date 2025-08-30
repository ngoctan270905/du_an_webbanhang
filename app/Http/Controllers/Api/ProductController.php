<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        // Lấy danh sách sản phẩm có phân trang và kèm theo danh mục
        $query = Product::with('category');
        if ($request->filled('ma_san_pham')) {
            $query->where('ma_san_pham', 'LIKE', '%' . $request->ten_san_pham . '%');
        }
        if ($request->filled('ten_san_pham')) {
            $query->where('ten_san_pham', 'LIKE', '%' . $request->ten_san_pham . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('gia_tu')) {
            $query->where('gia', '>=', (int) $request->gia_tu);
        }
        // 🔹 Lọc theo ngày nhập
        if ($request->filled('ngay_nhap_tu')) {
            $query->whereDate('ngay_nhap', '>=', $request->ngay_nhap_tu);
        }

        if ($request->filled('ngay_nhap_den')) {
            $query->whereDate('ngay_nhap', '<=', $request->ngay_nhap_den);
        }

        if ($request->filled('gia_den')) {
            $query->where('gia', '<=', (int) $request->gia_den);
        }
      
        $products = $query->paginate(10);
        // return response()->json($products, 200);

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return new ProductResource($product);
        

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
