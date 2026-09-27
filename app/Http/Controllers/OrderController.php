<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function checkout()
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('menu')->with('error', 'Giỏ hàng đang trống.');
        }

        return view('orders.checkout', [
            'items' => $this->cart->all(),
            'total' => $this->cart->total(),
        ]);
    }

    public function store(StoreOrderRequest $request)
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('menu')->with('error', 'Giỏ hàng đang trống.');
        }

        $items = $this->cart->all();
        $total = $this->cart->total();

        $order = DB::transaction(function () use ($request, $items, $total) {

            $order = Order::create([
                'order_code'     => Order::generateCode(),
                'user_id'        => auth()->id(),
                'customer_name'  => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'address'        => $request->order_type === 'delivery' ? $request->address : null,
                'note'           => $request->note,
                'total_amount'   => $total,
                'order_type'     => $request->order_type,
                'status'         => 'pending',
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['product_id'],
                    'product_name' => $item['name'],
                    'size'         => $item['size'],
                    'note'         => $item['note'] ?? null,
                    'unit_price'   => $item['unit_price'],
                    'quantity'     => $item['quantity'],
                    'subtotal'     => $item['subtotal'],
                ]);
            }

            return $order;
        });

        $this->cart->clear();

        return redirect()->route('order.success', $order->order_code);
    }

    public function success(string $code)
    {
        $order = Order::with('items')->where('order_code', $code)->firstOrFail();
        return view('orders.success', compact('order'));
    }

    public function trackForm()
    {
        return view('orders.track', [
            'myOrders' => $this->myOrders(),
        ]);
    }

    public function track(Request $request)
      {
        $request->validate([
            'order_code' => 'required|string',
            'phone'      => 'required|string',
        ]);

        $order = Order::with('items')
            ->where('order_code', $request->order_code)
            ->where('customer_phone', $request->phone)
            ->first();

        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng. Kiểm tra lại mã đơn và số điện thoại.');
        }

        return view('orders.track', [
            'order'    => $order,
            'myOrders' => $this->myOrders(),
        ]);
    }
        // Đơn của tài khoản đang đăng nhập (khách chưa đăng nhập thì trả về rỗng)
    private function myOrders()
    {
        if (!auth()->check()) {
            return collect();
        }

        return Order::with('items')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }
}