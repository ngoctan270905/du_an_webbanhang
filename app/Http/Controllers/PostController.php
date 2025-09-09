<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();
        
        if ($request->filled('tieu_de')) {
            $query->where('tieu_de', 'LIKE', '%' . $request->tieu_de . '%');
        }
        
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $posts = $query->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $dataValidate = $request->validate([
            'tieu_de' => 'required|string|max:255',
            'noi_dung' => 'nullable|string|max:2555',
            'trang_thai' => 'required|boolean',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048' // max 2MB
        ]);

        // Xử lý upload hình ảnh nếu có
        if ($request->hasFile('hinh_anh')) {
            $path = $request->file('hinh_anh')->store('images/posts', 'public');
            $dataValidate['hinh_anh'] = $path;
        }

        Post::create($dataValidate);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Thêm bài viết thành công!');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $dataValidate = $request->validate([
            'tieu_de' => 'required|string|max:255',
            'noi_dung' => 'nullable|string|max:255',
            'trang_thai' => 'required|boolean',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Xử lý upload hình ảnh mới nếu có
        if ($request->hasFile('hinh_anh')) {
            // Xóa hình cũ nếu tồn tại
            if ($post->hinh_anh) {
                Storage::disk('public')->delete($post->hinh_anh);
            }
            
            $path = $request->file('hinh_anh')->store('images/posts', 'public');
            $dataValidate['hinh_anh'] = Storage::url($path);
        }

        $post->update($dataValidate);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Cập nhật bài viết thành công!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        
        // Xóa hình ảnh liên quan nếu tồn tại
        if ($post->hinh_anh) {
            Storage::delete(str_replace('/storage', 'public', $post->hinh_anh));
        }
        
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Xóa bài viết thành công!');
    }
}