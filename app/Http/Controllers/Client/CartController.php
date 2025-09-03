<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'error' => 'Vui lòng đăng nhập hoặc đăng ký để thêm sản phẩm vào giỏ hàng!'
            ]);
        }

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;
        $user = Auth::user();
        $currentPrice = $product->gia_khuyen_mai ?? $product->gia;

        if ($quantity <= 0) {
            return response()->json([
                'success' => false,
                'error' => 'Số lượng phải lớn hơn 0!'
            ]);
        }

        if ($quantity > $product->so_luong) {
            return response()->json([
                'success' => false,
                'error' => "Số lượng yêu cầu vượt quá tồn kho. Sản phẩm này chỉ còn {$product->so_luong} quyển."
            ]);
        }

        $cartItem = CartItem::where('id_nguoi_dung', $user->id)
            ->where('id_san_pham', $product->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->so_luong + $quantity;
            if ($newQuantity > $product->so_luong) {
                return response()->json([
                    'success' => false,
                    'error' => "Bạn đã có {$cartItem->so_luong} sản phẩm trong giỏ, sản phẩm này chỉ còn {$product->so_luong} quyển."
                ]);
            }
            $cartItem->so_luong = $newQuantity;
            $cartItem->gia = $currentPrice; // Cập nhật giá hiện tại
            $cartItem->save();
        } else {
            CartItem::create([
                'id_nguoi_dung' => $user->id,
                'id_san_pham' => $product->id,
                'so_luong' => $quantity,
                'gia' => $currentPrice // Lưu giá hiện tại
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng!'
        ]);
    }

   public function show()
    {
        if (!Auth::check()) {
            return view('clients.cart.index', ['cart' => []]);
        }

        $user = Auth::user();
        $cartItems = CartItem::where('id_nguoi_dung', $user->id)->with('product')->get();

        // Kiểm tra và cập nhật giỏ hàng
        foreach ($cartItems as $item) {
            $product = $item->product;

            // Xóa sản phẩm nếu không tồn tại hoặc ngừng bán
            if (!$product || $product->trang_thai != 1) {
                $item->delete();
                continue;
            }

            $currentPrice = $product->gia_khuyen_mai ?? $product->gia;
            $availableStock = $product->so_luong;

            // Cập nhật số lượng nếu vượt quá tồn kho
            if ($item->so_luong > $availableStock) {
                $item->so_luong = $availableStock;
                $item->save();
            }

            // Cập nhật giá nếu có thay đổi
            if ($item->gia != $currentPrice) {
                $item->gia = $currentPrice;
                $item->save();
            }
        }

        // Lấy lại danh sách giỏ hàng sau khi cập nhật
        $cartItems = CartItem::where('id_nguoi_dung', $user->id)
            ->with('product')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id_san_pham,
                    'name' => $item->product ? $item->product->ten_san_pham : 'Sản phẩm không tồn tại',
                    'quantity' => $item->so_luong,
                    'price' => $item->gia, // Sử dụng giá từ cart_items, đã được cập nhật
                    'image' => $item->product ? $item->product->hinh_anh : '',
                    'stock' => $item->product ? $item->product->so_luong : 0
                ];
            })->toArray();

        return view('clients.cart.index', ['cart' => $cartItems]);
    }

    public function update(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'error' => 'Vui lòng đăng nhập hoặc đăng ký để cập nhật giỏ hàng!'
            ], 401);
        }

        try {
            $product = Product::findOrFail($request->product_id);
            $quantity = $request->quantity;
            $user = Auth::user();
            $currentPrice = $product->gia_khuyen_mai ?? $product->gia;

            if ($quantity <= 0) {
                return response()->json([
                    'success' => false,
                    'error' => 'Số lượng phải lớn hơn 0!'
                ], 400);
            }

            if ($quantity > $product->so_luong) {
                return response()->json([
                    'success' => false,
                    'error' => "Số lượng yêu cầu vượt quá tồn kho. Sản phẩm này chỉ còn {$product->so_luong} quyển."
                ], 400);
            }

            $cartItem = CartItem::where('id_nguoi_dung', $user->id)
                ->where('id_san_pham', $request->product_id)
                ->first();

            if ($cartItem) {
                $cartItem->so_luong = $quantity;
                $cartItem->gia = $currentPrice; // Cập nhật giá hiện tại
                $cartItem->save();

                $cartTotal = CartItem::where('id_nguoi_dung', $user->id)
                    ->get()
                    ->sum(function ($item) {
                        return $item->gia * $item->so_luong; // Sử dụng giá từ cart_items
                    });

                return response()->json([
                    'success' => true,
                    'message' => 'Số lượng đã được cập nhật!',
                    'total' => $currentPrice * $quantity,
                    'cart_total' => $cartTotal
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Sản phẩm không tồn tại trong giỏ hàng!'
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Cart update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ], 500);
        }
    }

    public function remove(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'error' => 'Vui lòng đăng nhập hoặc đăng ký để xóa sản phẩm khỏi giỏ hàng!'
            ], 401);
        }

        $user = Auth::user();
        $cartItem = CartItem::where('id_nguoi_dung', $user->id)
            ->where('id_san_pham', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->delete();
            $cartTotal = CartItem::where('id_nguoi_dung', $user->id)
                ->get()
                ->sum(function ($item) {
                    return $item->gia * $item->so_luong; // Sử dụng giá từ cart_items
                });

            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng!',
                'cart_total' => $cartTotal
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => 'Sản phẩm không tồn tại trong giỏ hàng!'
        ], 404);
    }

    public function clear(): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'error' => 'Vui lòng đăng nhập hoặc đăng ký để xóa giỏ hàng!'
            ]);
        }

        CartItem::where('id_nguoi_dung', Auth::id())->delete();
        return response()->json([
            'success' => true,
            'message' => 'Tất cả sản phẩm đã được xóa khỏi giỏ hàng!'
        ]);
    }

    public function validateCart(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'error' => 'Vui lòng đăng nhập!'], 401);
        }

        $user = Auth::user();
        $cartItems = CartItem::where('id_nguoi_dung', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'error' => 'Giỏ hàng trống!']);
        }

        $changes = [];
        $updatedItems = [];
        $total = 0;

        foreach ($cartItems as $item) {
            $product = $item->product;

            if (!$product || $product->trang_thai != 1) {
                $changes[] = [
                    'id' => $item->id_san_pham,
                    'message' => 'Sản phẩm không tồn tại hoặc ngừng bán.',
                    'action' => 'remove'
                ];
                continue;
            }

            $currentPrice = $product->gia_khuyen_mai ?? $product->gia;
            $availableStock = $product->so_luong;
            $updatedQuantity = $item->so_luong;

            if ($availableStock == 0) {
                $changes[] = [
                    'id' => $item->id_san_pham,
                    'message' => 'Sản phẩm hết hàng.',
                    'action' => 'remove'
                ];
                continue;
            } elseif ($item->so_luong > $availableStock) {
                $updatedQuantity = $availableStock;
                $changes[] = [
                    'id' => $item->id_san_pham,
                    'message' => "Sản phẩm này chỉ còn {$availableStock} quyển, số lượng trong giỏ đã được cập nhật.",
                    'action' => 'update_quantity'
                ];
            }

            // Kiểm tra thay đổi giá
            if ($item->gia != $currentPrice) {
                $changes[] = [
                    'id' => $item->id_san_pham,
                    'message' => "Sản phẩm {$product->ten_san_pham} có giá mới: " . number_format($currentPrice, 0, ',', '.') . "đ.",
                    'action' => 'update_price'
                ];
            }

            $subtotal = $currentPrice * $updatedQuantity;
            $total += $subtotal;

            $updatedItems[] = [
                'id' => $item->id_san_pham,
                'quantity' => $updatedQuantity,
                'gia' => $currentPrice
            ];
        }

        \Log::info('ValidateCart changes: ' . json_encode($changes));

        if (!empty($changes)) {
            return response()->json([
                'success' => true,
                'has_changes' => true,
                'changes' => $changes,
                'updated_items' => $updatedItems,
                'new_total' => $total,
                'message' => 'Để đảm bảo đơn hàng chính xác, chúng tôi phát hiện sản phẩm trong giỏ hàng đã có thay đổi từ hệ thống. Nhấn Xác nhận để cập nhật giỏ hàng với thông tin mới nhất và tiếp tục đặt hàng.'
            ]);
        }

        return response()->json(['success' => true, 'has_changes' => false, 'new_total' => $total]);
    }

    public function applyChanges(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Vui lòng đăng nhập để cập nhật giỏ hàng!'
                ], 401);
            }

            $updatedItems = $request->input('updated_items', []);
            if (empty($updatedItems)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Dữ liệu cập nhật không hợp lệ!'
                ], 400);
            }

            $userId = Auth::id();
            $cartItems = CartItem::where('id_nguoi_dung', $userId)->get()->keyBy('id_san_pham');

            foreach ($updatedItems as $item) {
                $productId = $item['id'] ?? null;
                $quantity = $item['quantity'] ?? 0;
                $price = $item['gia'] ?? null;

                if (!$productId || $quantity <= 0 || $price === null) {
                    return response()->json([
                        'success' => false,
                        'error' => "Dữ liệu không hợp lệ cho sản phẩm ID: {$productId}"
                    ], 400);
                }

                $product = Product::find($productId);
                if (!$product) {
                    return response()->json([
                        'success' => false,
                        'error' => "Sản phẩm ID: {$productId} không tồn tại!"
                    ], 404);
                }

                if ($product->trang_thai == 0) {
                    return response()->json([
                        'success' => false,
                        'error' => "Sản phẩm {$product->ten_san_pham} hiện không khả dụng!"
                    ], 400);
                }

                if ($quantity > $product->so_luong) {
                    return response()->json([
                        'success' => false,
                        'error' => "Sản phẩm {$product->ten_san_pham} chỉ còn {$product->so_luong} trong kho!"
                    ], 400);
                }

                if (isset($cartItems[$productId])) {
                    $cartItem = $cartItems[$productId];
                    $cartItem->so_luong = $quantity;
                    $cartItem->gia = $price; // Cập nhật giá
                    $cartItem->save();
                } else {
                    CartItem::create([
                        'id_nguoi_dung' => $userId,
                        'id_san_pham' => $productId,
                        'so_luong' => $quantity,
                        'gia' => $price
                    ]);
                }
            }

            foreach ($cartItems as $cartItem) {
                if (!collect($updatedItems)->pluck('id')->contains($cartItem->id_san_pham)) {
                    $cartItem->delete();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Giỏ hàng đã được cập nhật thành công!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in applyChanges: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Lỗi server khi cập nhật giỏ hàng: ' . $e->getMessage()
            ], 500);
        }
    }
}
?>