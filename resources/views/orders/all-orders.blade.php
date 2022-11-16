@extends('layouts.app')

@section('title', 'Все заказы')

@section('content')
    @if(session()->has('order_delete_success'))
        <div class="col-12">
            <div class="alert alert-warning">
                {{ session('order_delete_success') }}
            </div>
        </div>
    @endif
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h5 class="mb-0">Все ваши заказы</h5>
                </div>
                <a href="{{ route('order.create') }}" class="btn btn-primary">
                    Новый
                    <i class="bx bx-plus"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Наименование</th>
                            <th class="text-center">Статус</th>
                            <th class="text-center">Цена</th>
                            <th class="text-center">Товаров</th>
                            <th class="text-center">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @if($orders->count() < 1)
                            <tr>
                                <td colspan="6" class="text-center">У вас еще нет заказов, <a href="{{ route('order.create') }}" class="link-info">создайте новый</a>, чтобы он тут отобразился.</td>
                            </tr>
                        @else
                            @foreach($orders as $order)
                                <tr>
                                    <td class="text-center">{{ $order->id }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td class="text-center" style="color: {{ $order->status->hex }}">{{ $order->status->name }}</td>
                                    <td class="text-center">
                                        @php
                                            $cost = 0;
                                            foreach ($order->products as $product){
                                                $cost = $cost + ($product->price * $product->quantity);
                                            }
                                            echo $cost
                                        @endphp $
                                    </td>
                                    <td class="text-center">{{ $order->products->count() }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('order.view-order', ['id' => $order->id]) }}" class="btn btn-primary btn-sm"><i class="bx bx-show"></i></a>
                                        <a href="{{ route('order.view-order-edit', ['id' => $order->id]) }}" type="button" class="btn btn-success btn-sm"><i class="bx bx-edit"></i></a>
                                        <a href="{{ route('order.delete', ['order_id' => $order->id]) }}" onclick="confirm('Вы действительно хотите удалить заказ?')" class="btn btn-danger btn-sm"><i class="bx bx-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
