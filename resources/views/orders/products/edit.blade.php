@extends('layouts.app')

@section('title', 'Редактирование товара')

@section('content')
    @if(session()->has('product_edit_success'))
        <div class="alert alert-success">
            {{ session('product_edit_success') }}
        </div>
    @endif
    @if(session()->has('order_or_product_not_found'))
        <div class="alert alert-danger">
            {{ session('order_or_product_not_found') }}
        </div>
    @endif
    <div class="col-12 order-1">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Добавление товара</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('order.product.edit.post', ['order_id' => $order->id, 'product_id' => $product->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="shop" class="form-label">Магазин</label>
                        <select name="shop_id" id="shop" class="form-select" required>
                            @foreach($shops as $shop)
                                <option @if(session('data.shop_id') ? session('data.shop_id') : $product->shop->id == $shop->id) selected @endif value="{{ $shop->id }}">{{ $shop->name }}</option>
                            @endforeach
                        </select>
                        @error('shop_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="link">Ссылка на товар</label>
                        <input value="{{ session('data.link') ? session('data.link') : $product->link }}" name="link" type="text" class="form-control" id="link" placeholder="Вставьте ссылку на товар" required>
                        @error('link') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="title" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="точно как указано на сайте магазина, на том же языке, также укажите размер и цвет, если надо.">Название товара/Размер/Цвет:</label>
                        <input value="{{ session('data.title') ? session('data.title') : $product->title }}" name="title" type="text" class="form-control" id="title" placeholder="Введите название на товар прямо с сайта" required>
                        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="price" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="Важно: при неверно указанной сумме цена будет скорректирована">Цена товара</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input value="{{ session('data.price') ? session('data.price') : $product->price }}" name="price" type="number" class="form-control" placeholder="Цена за один товар" id="price" required>
                            <span class="input-group-text">.00</span>
                        </div>
                        @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="quantity">Количество:</label>
                        <input value="{{ session('data.quantity') ? session('data.quantity') : $product->quantity }}" name="quantity" type="number" class="form-control" id="quantity" placeholder="Введите название на товар прямо с сайта" required>
                        @error('quantity') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        @if($order->products->count() != 0)
                            <a href="{{ route('order.product.add-product', ['id' => $order->id]) }}" class="text-uppercase fw-semibold d-flex align-items-center gap-1">Товары<i class='bx bx-right-arrow-alt fw-semibold'></i></a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    @php
        session()->forget('data');
    @endphp
@endsection
