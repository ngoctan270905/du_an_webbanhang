<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->filled('ten_danh_muc')) {
            $query->where('ten_danh_muc', 'LIKE', '%' . $request->ten_danh_muc . '%');
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $categories = $query->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $dataValidate = $request->validate([
            'ten_danh_muc' => 'required|string|max:20|unique:categories,ten_danh_muc',
            'trang_thai' => 'required|boolean',
        ], [
            'ten_danh_muc.required' => 'Tên danh mục không được để trống.',
            'ten_danh_muc.string' => 'Tên danh mục phải là chuỗi ký tự.',
            'ten_danh_muc.max' => 'Tên danh mục không được vượt quá 20 ký tự.',
            'ten_danh_muc.unique' => 'Tên danh mục đã tồn tại. Vui lòng chọn tên khác.',
            'trang_thai.required' => 'Trạng thái không được để trống.',
            'trang_thai.boolean' => 'Trạng thái không hợp lệ.',
        ]);

        Category::create($dataValidate);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Thêm danh mục thành công!');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $dataValidate = $request->validate([
            'ten_danh_muc' => 'required|string|max:20|unique:categories,ten_danh_muc,' . $id,
            'trang_thai' => 'required|boolean',
        ], [
            'ten_danh_muc.required' => 'Tên danh mục không được để trống.',
            'ten_danh_muc.string' => 'Tên danh mục phải là chuỗi ký tự.',
            'ten_danh_muc.max' => 'Tên danh mục không được vượt quá 20 ký tự.',
            'ten_danh_muc.unique' => 'Tên danh mục đã tồn tại. Vui lòng chọn tên khác.',
            'trang_thai.required' => 'Trạng thái không được để trống.',
            'trang_thai.boolean' => 'Trạng thái không hợp lệ.',
        ]);

        $category->update($dataValidate);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Kiểm tra xem danh mục có chứa sản phẩm không
        if ($category->product()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục này vì đã có sản phẩm liên quan!');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Xóa danh mục thành công!');
    }
}
