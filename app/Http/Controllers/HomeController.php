<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with('availableProducts')
            ->orderBy('sort_order')
            ->get();

        $featured = Product::where('is_available', true)
            ->inRandomOrder()
            ->take(6)
            ->get();

        return view('home', compact('categories', 'featured'));
    }

    public function menu(Request $request)
    {
        $categories = Category::orderBy('sort_order')->get();

        $products = Product::with('category')
            ->where('is_available', true)
            ->when($request->category, function ($q) use ($request) {
                $q->whereHas('category', fn($c) => $c->where('slug', $request->category));
            })
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->orderBy('category_id')
            ->paginate(12)
            ->withQueryString();

        return view('menu', compact('categories', 'products'));
    }

    public function show(string $slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_available', true)
            ->take(4)
            ->get();

        return view('product-detail', compact('product', 'related'));
    }
}