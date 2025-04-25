<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Hiển thị chi tiết đơn hàng.
     */
    public function show($id)
    {
        // Lấy đơn hàng theo ID và eager load sản phẩm và người dùng
        $order = Order::with('products', 'user')->findOrFail($id);
    
        // Trả về view chi tiết đơn hàng
        return view('crud_user.show', compact('order'));
    }
    
}
