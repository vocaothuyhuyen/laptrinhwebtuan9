<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy 100 user đã có
        $users = User::limit(100)->get();

        foreach ($users as $user) {
            // Tạo 1 order cho mỗi user
            Order::create([
                'user_id' => $user->id,
                'name' => 'Order of ' . $user->name,
                'order_number' => strtoupper(Str::random(10)),
            ]);
        }
    }
}
