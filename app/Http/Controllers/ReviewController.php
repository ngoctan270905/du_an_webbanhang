<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'product']);

        if ($request->filled('noi_dung')) {
            $query->where('noi_dung', 'LIKE', '%' . $request->noi_dung . '%');
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $reviews = $query->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        $users = User::all();
        $products = Product::all();
        return view('admin.reviews.create', compact('users', 'products'));
    }

    public function store(Request $request)
    {
        $dataValidate = $request->validate([
            'id_nguoi_dung' => 'required|exists:users,id',
            'id_san_pham'   => 'required|exists:products,id',
            'noi_dung'      => 'nullable|string',
            'trang_thai'    => 'required|boolean',
            'rating'        => 'nullable|integer|min:1|max:5',
        ]);

        Review::create($dataValidate);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Thêm đánh giá thành công!');
    }

    public function show($id)
    {
        $review = Review::with(['user', 'product'])->findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);
        $users = User::all();
        $products = Product::all();
        return view('admin.reviews.edit', compact('review', 'users', 'products'));
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $dataValidate = $request->validate([
            'id_nguoi_dung' => 'required|exists:users,id',
            'id_san_pham'   => 'required|exists:products,id',
            'noi_dung'      => 'nullable|string',
            'trang_thai'    => 'required|boolean',
            'rating'        => 'nullable|integer|min:1|max:5',
        ]);

        $review->update($dataValidate);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Cập nhật đánh giá thành công!');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Xóa đánh giá thành công!');
    }
}
