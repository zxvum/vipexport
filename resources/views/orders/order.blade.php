@extends('layouts.app')

@section('title',  $order->name)

@section('content')
    @php
        $total_price = 0;
        foreach ($order->products as $product) {
            $total_price = $total_price + $product->price;
        }
    @endphp

    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ $order->name }}</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-2">
                    <p style="font-size: 16px; color: #020202">ID: {{ $order->id }}</p>
                    <p style="font-size: 16px; color: #020202">Статус: <span style="color: {{ $order->status->hex }}">{{ $order->status->name }}</span></p>
                    <p style="font-size: 16px; color: #020202">Название: {{ $order->name }}</p>
                    <p style="font-size: 16px; color: #020202">Описание: {{ $order->description }}</p>
                    <p style="font-size: 16px; color: #020202">Сумма заказа: {{ $total_price }}$</p>
                    <p style="font-size: 16px; color: #020202">Дата создания: {{ $order->created_at }}</p>
                    <p style="font-size: 16px; color: #020202">Дата изменения: {{ $order->updated_at }}</p>
                </div>
                <div class="mt-4 d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('order.view-order-edit', ['id' => $order->id]) }}" class="btn btn-primary">Редактировать</a>
                        <a href="{{ route('order.product.add-product', ['id' => $order->id]) }}" class="btn btn-secondary">Товары</a>
                    </div>
                    <a href="{{ route('order.all') }}" class="text-uppercase fw-semibold d-flex align-items-center gap-1">Все заказы<i class='bx bx-right-arrow-alt fw-semibold'></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
