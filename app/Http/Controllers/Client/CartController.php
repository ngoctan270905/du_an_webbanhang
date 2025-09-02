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
    // Check if user is authenticated
    if (!Auth::check()) {
      return response()->json([
        'success' => false,
        'error' => 'Vui lòng đăng nhập hoặc đăng ký để thêm sản phẩm vào giỏ hàng!'
      ]);
    }

    $product = Product::findOrFail($request->product_id);
    $quantity = $request->quantity;
    $user = Auth::user();

    // Kiểm tra số lượng hợp lệ
    if ($quantity <= 0) {
      return response()->json([
        'success' => false,
        'error' => 'Số lượng phải lớn hơn 0!'
      ]);
    }

    // Kiểm tra số lượng tồn kho
    if ($quantity > $product->so_luong) {
      return response()->json([
        'success' => false,
        'error' => "Số lượng yêu cầu vượt quá tồn kho. Sản phẩm này chỉ còn {$product->so_luong} quyển."
      ]);
    }

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng của người dùng
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
      $cartItem->save();
    } else {
      CartItem::create([
        'id_nguoi_dung' => $user->id,
        'id_san_pham' => $product->id,
        'so_luong' => $quantity
      ]);
    }

    return response()->json([
      'success' => true,
      'message' => 'Sản phẩm đã được thêm vào giỏ hàng!'
    ]);
  }

  public function show()
  {
    $cartItems = Auth::check() ? CartItem::where('id_nguoi_dung', Auth::id())
      ->with('product')
      ->get()
      ->map(function ($item) {
        return [
          'id' => $item->id_san_pham,
          'name' => $item->product->ten_san_pham,
          'quantity' => $item->so_luong,
          'price' => $item->product->gia_khuyen_mai ?? $item->product->gia,
          'image' => $item->product->hinh_anh,
          'stock' => $item->product->so_luong
        ];
      })->toArray() : [];

    return view('clients.cart.index', ['cart' => $cartItems]);
  }

  public function update(Request $request): JsonResponse
  {
    // Check if user is authenticated
    if (!Auth::check()) {
      return response()->json([
        'success' => false,
        'error' => 'Vui lòng đăng nhập hoặc đăng ký để cập nhật giỏ hàng!'
      ]);
    }

    $product = Product::findOrFail($request->product_id);
    $quantity = $request->quantity;
    $user = Auth::user();

    // Kiểm tra số lượng hợp lệ
    if ($quantity <= 0) {
      return response()->json([
        'success' => false,
        'error' => 'Số lượng phải lớn hơn 0!'
      ]);
    }

    // Kiểm tra số lượng tồn kho
    if ($quantity > $product->so_luong) {
      return response()->json([
        'success' => false,
        'error' => "Số lượng yêu cầu vượt quá tồn kho. Sản phẩm này chỉ còn {$product->so_luong} quyển."
      ]);
    }

    // Cập nhật giỏ hàng
    $cartItem = CartItem::where('id_nguoi_dung', $user->id)
      ->where('id_san_pham', $request->product_id)
      ->first();

    if ($cartItem) {
      $cartItem->so_luong = $quantity;
      $cartItem->save();
      return response()->json([
        'success' => true,
        'message' => 'Số lượng đã được cập nhật!',
        'total' => number_format(($product->gia_khuyen_mai ?? $product->gia) * $quantity, 0, ',', '.') . 'đ',
        'cart_total' => number_format(CartItem::where('id_nguoi_dung', $user->id)
          ->with('product')
          ->get()
          ->sum(function ($item) {
            return ($item->product->gia_khuyen_mai ?? $item->product->gia) * $item->so_luong;
          }), 0, ',', '.') . 'đ'
      ]);
    }

    return response()->json([
      'success' => false,
      'error' => 'Sản phẩm không tồn tại trong giỏ hàng!'
    ]);
  }

  public function remove(Request $request): JsonResponse
  {
    // Check if user is authenticated
    if (!Auth::check()) {
      return response()->json([
        'success' => false,
        'error' => 'Vui lòng đăng nhập hoặc đăng ký để xóa sản phẩm khỏi giỏ hàng!'
      ]);
    }

    $user = Auth::user();
    $cartItem = CartItem::where('id_nguoi_dung', $user->id)
      ->where('id_san_pham', $request->product_id)
      ->first();

    if ($cartItem) {
      $cartItem->delete();
      return response()->json([
        'success' => true,
        'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng!',
        'cart_total' => number_format(CartItem::where('id_nguoi_dung', $user->id)
          ->with('product')
          ->get()
          ->sum(function ($item) {
            return ($item->product->gia_khuyen_mai ?? $item->product->gia) * $item->so_luong;
          }), 0, ',', '.') . 'đ'
      ]);
    }

    return response()->json([
      'success' => false,
      'error' => 'Sản phẩm không tồn tại trong giỏ hàng!'
    ]);
  }

  public function clear(): JsonResponse
  {
    // Check if user is authenticated
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
}
