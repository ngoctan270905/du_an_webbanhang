<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Banner;
use App\Models\Review;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        $featuredBooks = Product::where('trang_thai', 1)
            ->inRandomOrder()
            ->take(5)
            ->get();

        $latestBooks = Product::where('trang_thai', 1)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('clients.home', compact('featuredBooks', 'latestBooks'));
    }

    public function productList(Request $request)
    {
        // Tìm kiếm sản phẩm
        $query = Product::query();

        // Bộ lọc tìm kiếm theo tên sản phẩm
        if ($request->has('search') && $request->search) {
            $query->where('ten_san_pham', 'like', '%' . $request->search . '%');
        }

        // Bộ lọc theo danh mục
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Kiểm tra và áp dụng bộ lọc khoảng giá
        if ($request->has('min_price') && is_numeric($request->min_price)) {
            $query->where('gia', '>=', $request->min_price);
        }

        if ($request->has('max_price') && is_numeric($request->max_price)) {
            $query->where('gia', '<=', $request->max_price);
        }

        // Sắp xếp theo giá
        if ($request->has('sort_by') && $request->sort_by == 'asc') {
            $query->orderBy('gia', 'asc');
        } elseif ($request->has('sort_by') && $request->sort_by == 'desc') {
            $query->orderBy('gia', 'desc');
        }

        // Phân trang sản phẩm
        $products = $query->paginate(10); // Phân trang 10 sản phẩm mỗi trang

        // Lấy tất cả danh mục (có thể cần cho phần lọc danh mục)
        $categories = Category::all();

        return view('products.dssanpham', compact('products', 'categories'));
    }

    public function showProductDetail($id)
    {
        // Lấy thông tin sản phẩm
        $product = Product::findOrFail($id);

        // Lấy toàn bộ đánh giá của sản phẩm
        $reviews = Review::where('id_san_pham', $product->id)->get();

        // Lấy 5 sản phẩm cùng danh mục (trừ chính sản phẩm hiện tại)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(5)
            ->get();

        return view('clients.products.product_detail', compact('product', 'reviews', 'relatedProducts'));
    }

    public function postList(Request $request)
    {
        // Tạo query để lấy bài viết
        $query = Post::query();

        // Bộ lọc tìm kiếm theo tiêu đề bài viết
        if ($request->has('search') && $request->search) {
            $query->where('tieu_de', 'like', '%' . $request->search . '%');
        }

        // Sắp xếp theo ngày tạo
        if ($request->has('sort_by') && $request->sort_by == 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->has('sort_by') && $request->sort_by == 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc'); // Mặc định sắp xếp mới nhất trước
        }

        // Phân trang bài viết (10 bài mỗi trang)
        $posts = $query->paginate(10);

        return view('clients.posts.post_list', compact('posts'));
    }

    public function submitReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'noi_dung' => 'required|string|max:1000',
        ]);

        Review::create([
            'id_nguoi_dung' => auth()->id(),
            'id_san_pham' => $id,
            'rating' => $request->rating,
            'noi_dung' => $request->noi_dung,
        ]);

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi!');
    }

    public function showContactForm()
    {
        return view('clients.contacts.contact');
    }

    public function submitContactForm(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required|string|max:255',
            'so_dien_thoai' => 'nullable|string|max:20',
            'noi_dung' => 'required|string|max:255',
        ]);

        // Lưu vào CSDL
        Contact::create([
            'ho_ten' => $request->ho_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'noi_dung' => $request->noi_dung,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Gửi email cảm ơn
        Mail::raw('Cảm ơn bạn đã liên hệ với chúng tôi. Chúng tôi sẽ phản hồi sớm nhất có thể!', function ($message) use ($request) {
            $message->to('admin@example.com') // Thay bằng email admin
                ->subject('Liên hệ mới từ: ' . $request->ho_ten);
        });

        return redirect()->back()->with('success', 'Liên hệ của bạn đã được gửi. Cảm ơn bạn!');
    }
}
