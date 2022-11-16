@extends('layouts.app')

@section('title', 'Товар: '.$product->id)

@section('content')
    <div class="card col-12">
        <div class="card-header">
            <h5 class="mb-0">Товар: {{ $product->id }}</h5>
        </div>
        <div class="card-body">
            <div class="d-flex flex-column gap-2">
                <p style="font-size: 16px; color: #020202">ID: {{ $product->id }}</p>
                <p style="font-size: 16px; color: #020202">Ссылка: {{ $product->link }}</p>
                <p style="font-size: 16px; color: #020202">Магазин: {{ $product->shop->name }}</p>
                <p style="font-size: 16px; color: #020202">Название: {{ $product->title }}</p>
                <p style="font-size: 16px; color: #020202">Цена: {{ $product->price }}$</p>
                <p style="font-size: 16px; color: #020202">Количество: {{ $product->quantity }}</p>
            </div>
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('order.product.edit', ['order_id' => $order->id, 'product_id' => $product->id]) }}" class="btn btn-primary">Редактировать</a>
                </div>
                <a href="{{ route('order.product.add-product', ['id' => $order->id]) }}" class="text-uppercase fw-semibold d-flex align-items-center gap-1">Все товары<i class='bx bx-right-arrow-alt fw-semibold'></i></a>
            </div>
        </div>
    </div>
@endsection
