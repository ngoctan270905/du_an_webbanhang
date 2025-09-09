<?php

namespace App\Http\Controllers\Client;

use App\Models\Post;
use App\Models\Banner;
use App\Models\Review;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

        // Lấy 3 bài viết mới nhất, đang hoạt động và chưa bị xóa mềm
        $posts = Post::query()
            ->where('trang_thai', 1)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('clients.home', compact('featuredBooks', 'latestBooks', 'posts'));
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

        // Lấy tất cả đánh giá để tính thống kê
        $allReviews = Review::where('id_san_pham', $product->id)
            ->where('trang_thai', 1) // Chỉ lấy đánh giá có trạng thái hoạt động (nếu có)
            ->get();

        // Lấy tham số filter từ request
        $filter = request()->input('filter', 'all');

        // Lấy 4 đánh giá mỗi trang để hiển thị danh sách, áp dụng lọc nếu có
        $reviewsQuery = Review::where('id_san_pham', $product->id)
            ->where('trang_thai', 1) // Chỉ lấy đánh giá có trạng thái hoạt động (nếu có)
            ->orderBy('created_at', 'desc'); // Sắp xếp đánh giá mới nhất trước

        if ($filter === '5') {
            $reviewsQuery->where('rating', 5);
        }

        $reviews = $reviewsQuery->paginate(4)->appends(['filter' => $filter]);

        // Lấy 5 sản phẩm liên quan cùng danh mục (ngẫu nhiên, trừ sản phẩm hiện tại)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('trang_thai', 1) // Chỉ lấy sản phẩm có trạng thái hoạt động
            ->inRandomOrder()
            ->take(5)
            ->get();

        return view('clients.products.product_detail', compact('product', 'allReviews', 'reviews', 'relatedProducts', 'filter'));
    }


    public function submitReview(Request $request, $id)
    {
        if (!auth()->check()) {
            Log::warning('Người dùng chưa đăng nhập khi gửi đánh giá cho sản phẩm ID: ' . $id);
            return response()->json(['success' => false, 'error' => 'Vui lòng đăng nhập để gửi đánh giá!'], 403);
        }

        // Log toàn bộ request và ID sản phẩm
        Log::info('Nhận yêu cầu đánh giá cho sản phẩm ID: ' . $id);
        Log::info('Dữ liệu gửi lên từ form: ', $request->all());
        Log::info('URL của request: ' . $request->fullUrl());

        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'noi_dung' => 'required|string|max:1000',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'rating.required' => 'Vui lòng chọn số sao đánh giá.',
            'rating.integer'  => 'Số sao phải là số nguyên.',
            'rating.min'      => 'Vui lòng chọn số sao bất kỳ.',
            'rating.max'      => 'Số sao tối đa là 5.',
            'noi_dung.required' => 'Vui lòng nhập nội dung đánh giá.',
            'noi_dung.max'      => 'Nội dung đánh giá không được vượt quá 1000 ký tự.',
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes' => 'Ảnh chỉ chấp nhận định dạng: jpeg, png, jpg, gif.',
            'image.max'   => 'Ảnh tải lên không được vượt quá 2MB.',
        ]);

        // Kiểm tra xem sản phẩm có tồn tại không
        $product = Product::find($id);
        if (!$product) {
            Log::error('Sản phẩm không tồn tại với ID: ' . $id);
            return response()->json(['success' => false, 'error' => 'Sản phẩm không tồn tại!'], 404);
        }
        Log::info('Sản phẩm được tìm thấy: ', ['id' => $product->id, 'ten_san_pham' => $product->ten_san_pham]);

        $data = [
            'id_nguoi_dung' => auth()->id(),
            'id_san_pham' => $id,
            'rating' => $request->rating,
            'noi_dung' => $request->noi_dung,
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('reviews', 'public');
            $data['image'] = $path;
            Log::info('Hình ảnh được tải lên: ' . $path);
        }

        // Log dữ liệu trước khi lưu vào cơ sở dữ liệu
        Log::info('Dữ liệu đánh giá sẽ được lưu: ', $data);

        $review = Review::create($data);

        // Log thông tin đánh giá sau khi lưu
        Log::info('Đánh giá đã được lưu: ', $review->toArray());

        return response()->json(['success' => true, 'message' => 'Đánh giá của bạn đã được gửi thành công!']);
    }

    public function showContactForm()
    {
        // Get the authenticated user's name and email if logged in, otherwise null
        $userData = Auth::check() ? [
            'ho_ten' => Auth::user()->name,
            'email' => Auth::user()->email
        ] : [
            'ho_ten' => null,
            'email' => null
        ];

        return view('clients.contacts.contact', $userData);
    }

    public function submitContactForm(Request $request)
    {
        $request->validate(
            [
                'ho_ten' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'so_dien_thoai' => 'nullable|string|max:20',
                'noi_dung' => 'required|string|max:255',
            ],
            [
                'ho_ten.required' => 'Vui lòng nhập họ tên.',
                'ho_ten.string' => 'Họ tên phải là chuỗi ký tự.',
                'ho_ten.max' => 'Họ tên không được vượt quá 255 ký tự.',

                'email.required' => 'Vui lòng nhập email.',
                'email.email' => 'Email không hợp lệ.',
                'email.max' => 'Email không được vượt quá 255 ký tự.',

                'so_dien_thoai.string' => 'Số điện thoại phải là chuỗi ký tự.',
                'so_dien_thoai.max' => 'Số điện thoại không được vượt quá 20 ký tự.',

                'noi_dung.required' => 'Vui lòng nhập nội dung.',
                'noi_dung.string' => 'Nội dung phải là chuỗi ký tự.',
                'noi_dung.max' => 'Nội dung không được vượt quá 255 ký tự.',
            ]
        );

        // Lưu vào CSDL
        Contact::create([
            'ho_ten' => $request->ho_ten,
            'email' => $request->email,
            'so_dien_thoai' => $request->so_dien_thoai,
            'noi_dung' => $request->noi_dung,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Liên hệ của bạn đã được gửi. Chúng tôi sẽ phản hồi sớm nhất có thể!');
    }
}
