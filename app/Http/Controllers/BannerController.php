<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $query = Banner::query();
        
        if ($request->filled('tieu_de')) {
            $query->where('tieu_de', 'LIKE', '%' . $request->tieu_de . '%');
        }
        
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $banners = $query->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $dataValidate = $request->validate([
            'tieu_de' => 'required|string|max:255',
            'hinh_anh' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trang_thai' => 'required|boolean',
        ]);

        if ($request->hasFile('hinh_anh')) {
            $imagePath = $request->file('hinh_anh')->store('images/banners', 'public');
            $dataValidate['hinh_anh'] = $imagePath;
        }

        Banner::create($dataValidate);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Thêm banner thành công!');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $dataValidate = $request->validate([
            'tieu_de' => 'required|string|max:255',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trang_thai' => 'required|boolean',
        ]);

        if ($request->hasFile('hinh_anh')) {
            // Xóa ảnh cũ nếu có
            if ($banner->hinh_anh) {
                Storage::disk('public')->delete($banner->hinh_anh);
            }

            // Lưu ảnh mới
            $imagePath = $request->file('hinh_anh')->store('images/banners', 'public');
            $dataValidate['hinh_anh'] = $imagePath;
        }

        $banner->update($dataValidate);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Cập nhật banner thành công!');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        
        // Xóa ảnh khi xóa banner
        if ($banner->hinh_anh) {
            Storage::disk('public')->delete($banner->hinh_anh);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Xóa banner thành công!');
    }
} 