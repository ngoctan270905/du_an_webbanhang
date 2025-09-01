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
            $query->where('ma_san_pham', 'LIKE', '%' . $request->ma_san_pham . '%');
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
        if ($request->filled('ngay_nhap_tu')) {
            $query->whereDate('ngay_nhap', '>=', $request->ngay_nhap_tu);
        }
        if ($request->filled('ngay_nhap_den')) {
            $query->whereDate('ngay_nhap', '<=', $request->ngay_nhap_den);
        }
        if ($request->filled('gia_den')) {
            $query->where('gia', '<=', (int) $request->gia_den);
        }

        // 💡 Thêm dòng này để sắp xếp sản phẩm mới nhất lên đầu
        $query->latest();

        $products = $query->paginate(10);
        $categories = Category::all();

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

    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào với thông báo tiếng Việt
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
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            // Thêm các trường mới
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
        ], [
            'ma_san_pham.required' => 'Mã sản phẩm không được để trống.',
            'ma_san_pham.string' => 'Mã sản phẩm phải là chuỗi ký tự.',
            'ma_san_pham.max' => 'Mã sản phẩm không được vượt quá 20 ký tự.',
            'ma_san_pham.unique' => 'Mã sản phẩm đã tồn tại.',

            'ten_san_pham.required' => 'Tên sản phẩm không được để trống.',
            'ten_san_pham.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
            'ten_san_pham.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',

            'category_id.required' => 'Bạn phải chọn một danh mục.',
            'category_id.exists' => 'Danh mục đã chọn không hợp lệ.',

            'gia.required' => 'Giá bán không được để trống.',
            'gia.numeric' => 'Giá bán phải là một số.',
            'gia.min' => 'Giá bán không được nhỏ hơn 0.',
            'gia.max' => 'Giá bán quá lớn.',

            'gia_khuyen_mai.required' => 'Giá khuyến mãi không được để trống.',
            'gia_khuyen_mai.numeric' => 'Giá khuyến mãi phải là một số.',
            'gia_khuyen_mai.min' => 'Giá khuyến mãi không được nhỏ hơn 0.',
            'gia_khuyen_mai.lte' => 'Giá khuyến mãi không được lớn hơn giá bán.',

            'so_luong.required' => 'Số lượng không được để trống.',
            'so_luong.integer' => 'Số lượng phải là số nguyên.',
            'so_luong.min' => 'Số lượng không được nhỏ hơn 1.',

            'ngay_nhap.required' => 'Ngày nhập không được để trống.',
            'ngay_nhap.date' => 'Ngày nhập không đúng định dạng.',

            'mo_ta.string' => 'Mô tả phải là chuỗi ký tự.',

            'trang_thai.required' => 'Trạng thái không được để trống.',
            'trang_thai.boolean' => 'Trạng thái không hợp lệ.',

            'hinh_anh.image' => 'File tải lên phải là hình ảnh.',
            'hinh_anh.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp.',
            'hinh_anh.max' => 'Dung lượng hình ảnh không được vượt quá 2048 KB.',

            // Thêm thông báo lỗi cho các trường mới
            'author.required' => 'Tên tác giả không được để trống.',
            'author.string' => 'Tên tác giả phải là chuỗi ký tự.',
            'author.max' => 'Tên tác giả không được vượt quá 255 ký tự.',

            'publisher.string' => 'Tên nhà xuất bản phải là chuỗi ký tự.',
            'publisher.max' => 'Tên nhà xuất bản không được vượt quá 255 ký tự.',

            'published_year.integer' => 'Năm xuất bản phải là một số nguyên.',
            'published_year.min' => 'Năm xuất bản không hợp lệ.',
            'published_year.max' => 'Năm xuất bản không được lớn hơn năm hiện tại.',
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

        // Validate dữ liệu đầu vào với thông báo tiếng Việt
        $dataValidate = $request->validate([
            // unique rule cần thêm ID của sản phẩm để bỏ qua chính nó
            'ma_san_pham' => 'required|string|max:20|unique:products,ma_san_pham,' . $id,
            'ten_san_pham' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'gia' => 'required|numeric|min:0|max:999999999',
            'gia_khuyen_mai' => 'required|numeric|min:0|lte:gia',
            'so_luong' => 'required|integer|min:1',
            'ngay_nhap' => 'required|date',
            'mo_ta' => 'nullable|string',
            'trang_thai' => 'required|boolean',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            // Thêm các trường mới
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
        ], [
            'ma_san_pham.required' => 'Mã sản phẩm không được để trống.',
            'ma_san_pham.string' => 'Mã sản phẩm phải là chuỗi ký tự.',
            'ma_san_pham.max' => 'Mã sản phẩm không được vượt quá 20 ký tự.',
            'ma_san_pham.unique' => 'Mã sản phẩm đã tồn tại.',

            'ten_san_pham.required' => 'Tên sản phẩm không được để trống.',
            'ten_san_pham.string' => 'Tên sản phẩm phải là chuỗi ký tự.',
            'ten_san_pham.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',

            'category_id.required' => 'Bạn phải chọn một danh mục.',
            'category_id.exists' => 'Danh mục đã chọn không hợp lệ.',

            'gia.required' => 'Giá bán không được để trống.',
            'gia.numeric' => 'Giá bán phải là một số.',
            'gia.min' => 'Giá bán không được nhỏ hơn 0.',
            'gia.max' => 'Giá bán quá lớn.',

            'gia_khuyen_mai.required' => 'Giá khuyến mãi không được để trống.',
            'gia_khuyen_mai.numeric' => 'Giá khuyến mãi phải là một số.',
            'gia_khuyen_mai.min' => 'Giá khuyến mãi không được nhỏ hơn 0.',
            'gia_khuyen_mai.lte' => 'Giá khuyến mãi không được lớn hơn giá bán.',

            'so_luong.required' => 'Số lượng không được để trống.',
            'so_luong.integer' => 'Số lượng phải là số nguyên.',
            'so_luong.min' => 'Số lượng không được nhỏ hơn 1.',

            'ngay_nhap.required' => 'Ngày nhập không được để trống.',
            'ngay_nhap.date' => 'Ngày nhập không đúng định dạng.',

            'mo_ta.string' => 'Mô tả phải là chuỗi ký tự.',

            'trang_thai.required' => 'Trạng thái không được để trống.',
            'trang_thai.boolean' => 'Trạng thái không hợp lệ.',

            'hinh_anh.image' => 'File tải lên phải là hình ảnh.',
            'hinh_anh.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp.',
            'hinh_anh.max' => 'Dung lượng hình ảnh không được vượt quá 2048 KB.',

            // Thêm thông báo lỗi cho các trường mới
            'author.required' => 'Tên tác giả không được để trống.',
            'author.string' => 'Tên tác giả phải là chuỗi ký tự.',
            'author.max' => 'Tên tác giả không được vượt quá 255 ký tự.',

            'publisher.string' => 'Tên nhà xuất bản phải là chuỗi ký tự.',
            'publisher.max' => 'Tên nhà xuất bản không được vượt quá 255 ký tự.',

            'published_year.integer' => 'Năm xuất bản phải là một số nguyên.',
            'published_year.min' => 'Năm xuất bản không hợp lệ.',
            'published_year.max' => 'Năm xuất bản không được lớn hơn năm hiện tại.',
        ]);

        // Xử lý hình ảnh nếu có
        if ($request->hasFile('hinh_anh')) {
            // Xóa ảnh cũ nếu có
            if ($product->hinh_anh && Storage::disk('public')->exists($product->hinh_anh)) {
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
        // Khi SoftDeletes được sử dụng, phương thức delete() sẽ tự động
        // chỉ cập nhật cột `deleted_at`, chứ không xóa hoàn toàn.
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công!');
    }

    /**
     * Hiển thị danh sách sản phẩm đã xóa mềm.
     */
    public function trashed()
    {
        $trashedProducts = Product::onlyTrashed()->paginate(10);
        // Lấy tất cả danh mục để hiển thị trong bộ lọc
        $categories = Category::all();
        // Truyền cả trashedProducts và categories vào view
        return view('admin.products.trashed', compact('trashedProducts', 'categories'));
    }

    /**
     * Khôi phục sản phẩm đã xóa mềm.
     */
    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.index')->with('success', 'Khôi phục sản phẩm thành công!');
    }

    /**
     * Xóa sản phẩm vĩnh viễn khỏi cơ sở dữ liệu.
     */
    public function forceDestroy($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        // Xóa ảnh nếu có
        if ($product->hinh_anh && Storage::disk('public')->exists($product->hinh_anh)) {
            Storage::disk('public')->delete($product->hinh_anh);
        }
        $product->forceDelete();

        return redirect()->route('admin.products.trashed')->with('success', 'Xóa sản phẩm vĩnh viễn thành công!');
    }
}
