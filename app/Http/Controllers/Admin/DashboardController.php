<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = today();

        $stats = [
            'orders_today'  => Order::whereDate('created_at', $today)->count(),
            'revenue_today' => Order::whereDate('created_at', $today)
                                    ->where('status', 'completed')->sum('total_amount'),
            'pending'       => Order::where('status', 'pending')->count(),
            'products'      => Product::count(),
        ];

        // Doanh thu 7 ngày gần nhất
        $revenueChart = Order::where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top 5 món bán chạy
        $topProducts = OrderItem::select('product_name', DB::raw('SUM(quantity) as sold'))
            ->groupBy('product_name')
            ->orderByDesc('sold')
            ->take(5)
            ->get();

        $recentOrders = Order::latest()->take(8)->get();

        return view('admin.dashboard', compact('stats', 'revenueChart', 'topProducts', 'recentOrders'));
    }
}