<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
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
        // Tương tự thực hiện tim kiếm sản phẩm theo:
        // Tên sản phẩm, Danh mục, Khoảng giá, Ngày nhập, Trạng thái
        $products = $query->paginate(10);
        $categories = Category::all();
        // Trả về view admin.products.index và truyền biến $products
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        // Lấy ra dữ liệu chi tiết theo id
        $product = Product::with('category')->findOrFail($id);
        return view('admin.products.show', compact('product'));

        // Đổ dữ liệu thông tin chi tiết ra giao diện
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request) {
        // Validate dữ liệu đầu vào
        $dataValidate = $request->validate([
            'ma_san_pham' => 'required|string|max:20|unique:products,ma_san_pham',
            'ten_san_pham' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'gia' => 'required|numeric|min:0|max:999999999',
            'gia_khuyen_mai' => 'required|numeric|min:0|lte:gia',
            'so_luong' => 'required|integer|min:1',
            'ngay_nhap' => 'required|date',
            'mo_ta' => 'nullable|string',
            'trang_thai' => 'required|boolean',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
    
        // Xử lý hình ảnh nếu có
        if ($request->hasFile('hinh_anh')) {
            $imagePath = $request->file('hinh_anh')->store('images/products', 'public');
            $dataValidate['hinh_anh'] = $imagePath;
        }
    
        // Tạo sản phẩm với dữ liệu đã có
        Product::create($dataValidate);
    
        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    
    }

    public function update(Request $request, $id)
    {
        // Tìm sản phẩm cần cập nhật
        $product = Product::findOrFail($id);
    
        // Validate dữ liệu đầu vào
        $dataValidate = $request->validate([
            'ma_san_pham' => 'required|string|max:20|unique:products,ma_san_pham,' . $id,
            'ten_san_pham' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'gia' => 'required|numeric|min:0|max:999999999',
            'gia_khuyen_mai' => 'required|numeric|min:0|lte:gia',
            'so_luong' => 'required|integer|min:1',
            'ngay_nhap' => 'required|date',
            'mo_ta' => 'nullable|string',
            'trang_thai' => 'required|boolean',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
    
        // Xử lý hình ảnh nếu có
        if ($request->hasFile('hinh_anh')) {
            // Xóa ảnh cũ nếu có
            if ($product->hinh_anh) {
                Storage::disk('public')->delete($product->hinh_anh);
            }
    
            // Lưu ảnh mới
            $imagePath = $request->file('hinh_anh')->store('images/products', 'public');
            $dataValidate['hinh_anh'] = $imagePath;
        }
    
        // Cập nhật sản phẩm
        $product->update($dataValidate);
    
        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }
    

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Xóa ảnh nếu có
        if ($product->hinh_anh) {
            Storage::disk('public')->delete($product->hinh_anh);
        }
        
        // Xóa sản phẩm
        $product->delete();
        
        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công');
    }

}
