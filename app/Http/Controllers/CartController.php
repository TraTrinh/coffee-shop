<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function index()
    {
        return view('cart.index', [
            'items' => $this->cart->all(),
            'total' => $this->cart->total(),
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'size'       => 'required|in:S,M,L',
            'quantity'   => 'required|integer|min:1|max:20',
        ]);

        $product = Product::findOrFail($data['product_id']);

        if (!$product->is_available) {
            return back()->with('error', 'Món này hiện đã hết.');
        }

        $this->cart->add($product, $data['size'], $data['quantity']);

        return redirect()->route('cart.index')
            ->with('success', 'Đã thêm ' . $product->name . ' vào giỏ hàng.');
    }

    public function update(Request $request, string $key)
    {
        $request->validate(['quantity' => 'required|integer|min:0|max:20']);
        $this->cart->update($key, (int) $request->quantity);

        return back()->with('success', 'Đã cập nhật giỏ hàng.');
    }

    public function remove(string $key)
    {
        $this->cart->remove($key);
        return back()->with('success', 'Đã xoá món khỏi giỏ.');
    }
}