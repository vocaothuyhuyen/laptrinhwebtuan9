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
        $order = Order::with('products', 'user')->findOrFail($id);

        // Đảm bảo rằng bạn trả về đúng view 'crud_user.show'
        return view('crud_user.show', compact('order'));
    }

}