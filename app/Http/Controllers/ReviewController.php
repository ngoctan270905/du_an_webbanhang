<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use App\Models\ReviewReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::has('reviews')
            ->withCount('reviews')
            ->with(['reviews']);

        if ($request->filled('noi_dung')) {
            $query->where('ten_san_pham', 'LIKE', '%' . $request->noi_dung . '%');
        }

        $products = $query->paginate(10);
        return view('admin.reviews.index', compact('products'));
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
        $review = Review::with(['user', 'product', 'reviewReply'])->findOrFail($id);

        // Chọn văn mẫu dựa trên rating
        $defaultReply = match (true) {
            $review->rating >= 4 => 'Cảm ơn quý khách đã tin tưởng và ủng hộ sản phẩm của chúng tôi! Chúng tôi rất vui khi nhận được đánh giá tích cực từ bạn. Hy vọng sẽ tiếp tục mang đến những trải nghiệm tuyệt vời hơn nữa. Chúc bạn một ngày vui vẻ!',
            $review->rating == 3 => 'Cảm ơn quý khách đã chia sẻ ý kiến! Chúng tôi rất trân trọng phản hồi của bạn và sẽ tiếp tục cải thiện chất lượng sản phẩm cũng như dịch vụ để mang đến trải nghiệm tốt hơn. Nếu có bất kỳ vấn đề nào cần hỗ trợ, xin vui lòng liên hệ với chúng tôi. Chúc bạn một ngày tốt lành!',
            default => 'Chân thành cảm ơn quý khách đã gửi phản hồi. Chúng tôi rất tiếc vì trải nghiệm của bạn chưa được như mong đợi. Đội ngũ của chúng tôi sẽ kiểm tra và cải thiện ngay. Nếu bạn cần hỗ trợ thêm, xin vui lòng liên hệ qua hotline 0123-456-789 hoặc email support@example.com. Mong bạn thông cảm và tiếp tục ủng hộ!',
        };

        return view('admin.reviews.show', compact('review', 'defaultReply'));
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

    public function showReviews(Product $product, Request $request)
    {
        $query = Review::where('id_san_pham', $product->id)
            ->with(['user', 'product']);

        if ($request->filled('noi_dung')) {
            $query->where('noi_dung', 'LIKE', '%' . $request->noi_dung . '%');
        }

        // Sắp xếp theo mới nhất
        $reviews = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.reviews.showReviews', compact('product', 'reviews'));
    }

    // Lưu phản hồi mới
    public function storeReply(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $request->validate([
            'admin_reply' => 'required|string|max:1000',
        ]);

        $reply = ReviewReply::create([
            'review_id' => $review->id,
            'user_id' => Auth::id(),
            'content' => $request->admin_reply,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'reply' => [
                    'content' => $reply->content,
                    'created_at' => $reply->created_at->format('d/m/Y H:i:s'),
                    'delete_url' => route('admin.reviews.reply.delete', $id),
                ],
            ]);
        }

        return redirect()->route('admin.reviews.show', $id)
            ->with('reply_success', 'Phản hồi đã được gửi thành công!');
    }

    // Xóa phản hồi
    public function deleteReply($id)
    {
        $review = Review::findOrFail($id);
        $reply = ReviewReply::where('review_id', $review->id)->first();

        if ($reply) {
            $reply->delete();
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'form_action' => route('admin.reviews.reply.store', $id),
                ]);
            }
            return redirect()->route('admin.reviews.show', $id)
                ->with('reply_success', 'Phản hồi đã được xóa thành công!');
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy phản hồi để xóa.',
            ], 404);
        }

        return redirect()->route('reviews.show', $id)
            ->with('error', 'Không tìm thấy phản hồi để xóa.');
    }
}
