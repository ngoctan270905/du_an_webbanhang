<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
  public function addToCart(Request $request): JsonResponse
  {
    $product = Product::findOrFail($request->product_id);
    $quantity = $request->quantity;

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

    // Kiểm tra session cart
    $cart = session()->get('cart', []);

    // Nếu sản phẩm đã tồn tại trong giỏ hàng
    if (isset($cart[$product->id])) {
      $currentQuantity = $cart[$product->id]['quantity'];
      $newQuantity = $currentQuantity + $quantity;
      if ($newQuantity > $product->so_luong) {
        return response()->json([
          'success' => false,
          'error' => "Bạn đã có {$currentQuantity} sản phẩm trong giỏ, sản phẩm này chỉ còn {$product->so_luong} quyển."
        ]);
      }
      $cart[$product->id]['quantity'] = $newQuantity;
    } else {
      // Nếu sản phẩm chưa có trong giỏ hàng
      $cart[$product->id] = [
        "name" => $product->ten_san_pham,
        "quantity" => $quantity,
        "price" => $product->gia_khuyen_mai ?? $product->gia,
        "image" => $product->hinh_anh,
        "stock" => $product->so_luong // Lưu số lượng tồn kho
      ];
    }

    session()->put('cart', $cart);
    return response()->json([
      'success' => true,
      'message' => 'Sản phẩm đã được thêm vào giỏ hàng!'
    ]);
  }

  public function show()
  {
    $cart = session()->get('cart', []);
    return view('clients.cart.index', compact('cart'));
  }

  public function update(Request $request): JsonResponse
  {
    $product = Product::findOrFail($request->product_id);
    $quantity = $request->quantity;

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
    $cart = session()->get('cart', []);
    if (isset($cart[$request->product_id])) {
      $cart[$request->product_id]['quantity'] = $quantity;
      session()->put('cart', $cart);
      return response()->json([
        'success' => true,
        'message' => 'Số lượng đã được cập nhật!',
        'total' => number_format($cart[$request->product_id]['price'] * $quantity, 0, ',', '.') . 'đ',
        'cart_total' => number_format(array_sum(array_map(function ($item) {
          return $item['price'] * $item['quantity'];
        }, $cart)), 0, ',', '.') . 'đ'
      ]);
    }

    return response()->json([
      'success' => false,
      'error' => 'Sản phẩm không tồn tại trong giỏ hàng!'
    ]);
  }

  public function remove(Request $request): JsonResponse
  {
    $cart = session()->get('cart', []);

    if (isset($cart[$request->product_id])) {
      unset($cart[$request->product_id]);
      session()->put('cart', $cart);
      return response()->json([
        'success' => true,
        'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng!',
        'cart_total' => number_format(array_sum(array_map(function ($item) {
          return $item['price'] * $item['quantity'];
        }, $cart)), 0, ',', '.') . 'đ'
      ]);
    }

    return response()->json([
      'success' => false,
      'error' => 'Sản phẩm không tồn tại trong giỏ hàng!'
    ]);
  }

  public function clear(): JsonResponse
  {
    session()->forget('cart');
    return response()->json([
      'success' => true,
      'message' => 'Tất cả sản phẩm đã được xóa khỏi giỏ hàng!'
    ]);
  }
}
