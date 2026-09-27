<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.form', [
            'product'    => new Product(),
            'categories' => Category::orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['image'] = $this->handleImage($request);
        $data['is_available'] = $request->boolean('is_available');

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Đã thêm sản phẩm mới.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', [
            'product'    => $product,
            'categories' => Category::orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateData($request, $product->id);
        $data['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            $this->deleteImage($product->image);
            $data['image'] = $this->handleImage($request);
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Đã cập nhật sản phẩm.');
    }

    public function destroy(Product $product)
    {
        $this->deleteImage($product->image);
        $product->delete();

        return back()->with('success', 'Đã xoá sản phẩm.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required'  => 'Vui lòng nhập tên sản phẩm.',
            'price.required' => 'Vui lòng nhập giá.',
            'image.max'      => 'Ảnh không được vượt quá 2MB.',
        ]);
    }

    private function uniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $i = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = Str::slug($name) . '-' . $i++;
        }
        return $slug;
    }

    private function handleImage(Request $request): ?string
    {
        if (!$request->hasFile('image')) return null;

        $file = $request->file('image');
        $name = time() . '_' . Str::random(6) . '.' . $file->extension();
        $file->move(public_path('images/products'), $name);

        return $name;
    }

    private function deleteImage(?string $image): void
    {
        if ($image && file_exists(public_path('images/products/' . $image))) {
            unlink(public_path('images/products/' . $image));
        }
    }
}