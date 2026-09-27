<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    private const SESSION_KEY = 'cart';

    public function all(): array
    {
        return session()->get(self::SESSION_KEY, []);
    }

    public function add(Product $product, string $size, int $quantity): void
    {
        $cart = $this->all();
        $key  = $this->makeKey($product->id, $size);

        $unitPrice = $product->priceBySize($size);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'slug'       => $product->slug,
                'image'      => $product->image,
                'size'       => $size,
                'unit_price' => $unitPrice,
                'quantity'   => $quantity,
            ];
        }

        $cart[$key]['subtotal'] = $cart[$key]['unit_price'] * $cart[$key]['quantity'];

        session()->put(self::SESSION_KEY, $cart);
    }

    public function update(string $key, int $quantity): void
    {
        $cart = $this->all();
        if (!isset($cart[$key])) return;

        if ($quantity <= 0) {
            unset($cart[$key]);
        } else {
            $cart[$key]['quantity'] = $quantity;
            $cart[$key]['subtotal'] = $cart[$key]['unit_price'] * $quantity;
        }

        session()->put(self::SESSION_KEY, $cart);
    }

    public function remove(string $key): void
    {
        $cart = $this->all();
        unset($cart[$key]);
        session()->put(self::SESSION_KEY, $cart);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public function total(): float
    {
        return array_sum(array_column($this->all(), 'subtotal'));
    }

    public function count(): int
    {
        return array_sum(array_column($this->all(), 'quantity'));
    }

    public function isEmpty(): bool
    {
        return empty($this->all());
    }

    // Cùng sản phẩm khác size = 2 dòng riêng biệt
    private function makeKey(int $productId, string $size): string
    {
        return $productId . '-' . $size;
    }
}