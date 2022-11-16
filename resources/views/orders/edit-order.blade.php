@extends('layouts.app')

@section('title', 'Заказ N'.$order->id)

@section('content')
    <div class="col-12">
        @if(session()->has('order_not_found'))
            <div class="alert alert-danger">
                {{ session('order_not_found') }}
            </div>
        @endif
        @if(session()->has('order_updated'))
            <div class="alert alert-success">
                {{ session('order_updated') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Заказ: {{ $order->title }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('order.post-edit-order', ['id' => $order->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Название</label>
                        <input value="{{ session('data.name') ? session('data.name') : $order->name }}" type="text" class="form-control" id="title" name="name" placeholder="Название заказа">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea class="form-control" name="description" style="max-height: 200px; min-height: 40px; height: 60px;">{{ session('data.description') ? session('data.description') : $order->description }}</textarea>
                        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                            <a href="{{ route('order.product.add-product', ['id' => $order->id]) }}" type="submit" class="btn btn-secondary">Товары</a>
                        </div>
                        <a href="{{ route('order.view-order', ['id' => $order->id]) }}" class="text-uppercase fw-semibold d-flex align-items-center gap-1">К заказу<i class='bx bx-right-arrow-alt fw-semibold'></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
