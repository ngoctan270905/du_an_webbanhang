<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
  public function addToCart(Request $request)
  {
    $product = Product::findOrFail($request->product_id);
    $quantity = $request->quantity;

    // Kiểm tra session cart
    $cart = session()->get('cart', []);

    // Nếu sản phẩm đã tồn tại trong giỏ hàng
    if (isset($cart[$product->id])) {
      $cart[$product->id]['quantity'] += $quantity;
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
    return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
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
