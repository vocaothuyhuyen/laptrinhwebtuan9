@extends('dashboard')

@section('content')
<div class="container my-5">

    <h4>Chi tiết đơn hàng <strong>#{{ $order->order_number }}</strong></h4>
    <p><strong>Người đặt:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
    
    <p><strong>ID Đơn hàng:</strong> {{ $order->id }}</p>

    @if ($order->products->isEmpty())
        <div class="alert alert-info">Đơn hàng này chưa có sản phẩm nào.</div>
    @else
        <table class="table table-bordered table-striped mt-4 text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên sản phẩm</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">← Quay lại</a>
</div>
@endsection
