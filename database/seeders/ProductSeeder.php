<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::all();

        foreach ($orders as $order) {
            $count = rand(1, 5); // Số lượng sản phẩm mỗi đơn hàng

            for ($i = 1; $i <= $count; $i++) {
                Product::create([
                    'order_id' => $order->id,
                    'name' => 'Product ' . $i . ' for Order #' . $order->id,
                    'description' => 'Mô tả cho sản phẩm ' . $i,
                    'price' => rand(100, 500) + 0.99, // ví dụ 199.99
                ]);
            }
        }
    }
}
