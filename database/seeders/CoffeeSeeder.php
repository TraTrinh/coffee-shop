<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CoffeeSeeder extends Seeder
{
    public function run(): void
    {
        // Tài khoản admin
        User::updateOrCreate(
            ['email' => 'admin@coffee.test'],
            [
                'name'     => 'Quản trị viên',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
                'phone'    => '0900000000',
            ]
        );

        $data = [
            'Cà phê' => [
                ['Cà phê đen đá', 25000, 'Cà phê phin truyền thống, đậm vị'],
                ['Cà phê sữa đá', 30000, 'Vị đậm đà hoà quyện sữa đặc'],
                ['Bạc xỉu', 32000, 'Nhiều sữa, nhẹ vị cà phê'],
                ['Cappuccino', 45000, 'Espresso với lớp bọt sữa mịn'],
                ['Latte', 45000, 'Espresso pha sữa tươi, vị dịu'],
                ['Americano', 40000, 'Espresso pha loãng với nước nóng'],
            ],
            'Trà' => [
                ['Trà đào cam sả', 45000, 'Thanh mát, thơm mùi sả'],
                ['Trà vải', 42000, 'Ngọt dịu, có vải tươi'],
                ['Trà sen vàng', 45000, 'Trà xanh kết hợp hạt sen'],
                ['Trà atiso mật ong', 38000, 'Nhẹ nhàng, tốt cho sức khoẻ'],
            ],
            'Đá xay' => [
                ['Chocolate đá xay', 55000, 'Socola nguyên chất, phủ kem'],
                ['Matcha đá xay', 55000, 'Bột trà xanh Nhật Bản'],
                ['Cookie đá xay', 58000, 'Bánh quy nghiền cùng kem tươi'],
            ],
            'Bánh ngọt' => [
                ['Bánh mì bơ tỏi', 25000, 'Nướng nóng, thơm bơ'],
                ['Tiramisu', 45000, 'Bánh Ý vị cà phê'],
                ['Croissant', 35000, 'Bánh sừng bò nhiều lớp'],
            ],
        ];

        $order = 1;
        foreach ($data as $catName => $items) {
            $category = Category::updateOrCreate(
                ['slug' => Str::slug($catName)],
                ['name' => $catName, 'sort_order' => $order++]
            );

            foreach ($items as [$name, $price, $desc]) {
                Product::updateOrCreate(
                    ['slug' => Str::slug($name)],
                    [
                        'category_id'  => $category->id,
                        'name'         => $name,
                        'description'  => $desc,
                        'price'        => $price,
                        'is_available' => true,
                    ]
                );
            }
        }
    }
}