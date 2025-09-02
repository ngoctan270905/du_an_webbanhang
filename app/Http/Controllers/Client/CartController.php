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
        "image" => $product->hinh_anh
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

  public function update(Request $request)
  {
    $cart = session()->get('cart', []);

    if (isset($cart[$request->product_id])) {
      $cart[$request->product_id]['quantity'] = $request->quantity;
      session()->put('cart', $cart);
    }

    return redirect()->back()->with('success', 'Giỏ hàng đã được cập nhật!');
  }

  public function remove(Request $request)
  {
    $cart = session()->get('cart', []);

    if (isset($cart[$request->product_id])) {
      unset($cart[$request->product_id]);
      session()->put('cart', $cart);
    }

    return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
  }
}
