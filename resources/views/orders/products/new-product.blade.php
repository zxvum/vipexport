@extends('layouts.app')

@section('title', 'Добавление товара')

@section('content')
    <div class="row d-flex justify-content-center">
            @if(session()->has('order_created'))
                <div class="col-12">
                    <div class="alert alert-success">
                        {{ session('order_created') }}
                    </div>
                </div>
            @endif

            @if(session()->has('product_created'))
                <div class="col-12">
                    <div class="alert alert-success">
                        {{ session('product_created') }}
                    </div>
                </div>
            @endif

            @if(session()->has('order_not_found'))
                <div class="col-12">
                    <div class="alert alert-danger">
                        {{ session('order_not_found') }}
                    </div>
                </div>
            @endif

            @if(session()->has('product_not_found'))
                <div class="col-12">
                    <div class="alert alert-danger">
                        {{ session('product_not_found') }}
                    </div>
                </div>
            @endif

            @if(session()->has('product_delete_success'))
                <div class="col-12">
                    <div class="alert alert-warning">
                        {{ session('product_delete_success') }}
                    </div>
                </div>
            @endif
        <div class="col-12 col-xl-6 order-1">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Добавление товара в заказ: {{ $order->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('order.product.add-product.create', ['id' => $order->id]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="shop" class="form-label">Магазин</label>
                            <select name="shop_id" id="shop" class="form-select" required>
                                @foreach($shops as $shop)
                                    <option @if(session('data.shop_id') == $shop->id) selected @endif value="{{ $shop->id }}">{{ $shop->name }}</option>
                                @endforeach
                            </select>
                            @error('shop_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="link">Ссылка на товар</label>
                            <input value="{{ session('data.link') }}" name="link" type="text" class="form-control" id="link" placeholder="Вставьте ссылку на товар" required>
                            @error('link') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="title" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="точно как указано на сайте магазина, на том же языке, также укажите размер и цвет, если надо.">Название товара/Размер/Цвет:</label>
                            <input value="{{ session('data.title') }}" name="title" type="text" class="form-control" id="title" placeholder="Введите название на товар прямо с сайта" required>
                            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="price" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="Важно: при неверно указанной сумме цена будет скорректирована">Цена товара</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input value="{{ session('data.price') }}" name="price" type="number" class="form-control" placeholder="Цена за один товар" id="price" required>
                                <span class="input-group-text">.00</span>
                            </div>
                            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="quantity">Количество:</label>
                            <input value="{{ session('data.quantity') ? session('data.quantity') : 1 }}" name="quantity" type="number" class="form-control" id="quantity" placeholder="Введите название на товар прямо с сайта" required>
                            @error('quantity') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button type="submit" class="btn btn-primary">Добавить</button>
                                @if($order->products->count() == 0)
                                    <a href="{{ route('order.delete', ['order_id' => $order->id]) }}" onclick="confirm('Вы действительно хотите удалить заказ?')" class="btn btn-danger">Удалить заказ</a>
                                @endif
                            </div>
                            @if($order->products->count() != 0)
                                <a href="{{ route('order.all') }}" class="text-uppercase fw-semibold d-flex align-items-center gap-1">Все заказы<i class='bx bx-right-arrow-alt fw-semibold'></i></a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-6 order-2">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Товары в заказе</h5>
                </div>
                <div class="card-body">
                    @if($order->products->count() > 0)
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Название</th>
                                    <th class="text-center">Ссылка</th>
                                    <th class="text-center">Статус</th>
                                    <th class="text-center">Магазин</th>
                                    <th class="text-center">Цена</th>
                                    <th class="text-center">Действия</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach($products as $product)
                                        <tr>
                                            <td class="text-center"><a href="#">{{ $product->id }}</a></td>
                                            <td class="text-center text-truncate cursor-pointer" style="max-width: 120px" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="{{ $product->title }}">{{ $product->title }}</td>
                                            <td class="text-center"><a href="{{ $product->link }}" target="_blank">тык</a></td>
                                            <td class="text-center fw-semibold" style="color: {{ $product->status->hex }}">{{ $product->status->name }}</td>
                                            <td class="text-center">{{ $product->shop->name }}</td>
                                            <td class="text-center">{{ $product->price * $product->quantity }}$</td>
                                            <td class="text-center">
                                                <a href="{{ route('order.product.view', ['order_id' => $order->id, 'product_id' => $product->id]) }}" class="btn btn-primary btn-sm"><i class="bx bx-show"></i></a>
                                                <a href="{{ route('order.product.edit', ['order_id' => $order->id, 'product_id' => $product->id]) }}" class="btn btn-success btn-sm"><i class="bx bx-edit"></i></a>
                                                <a href="{{ route('order.product.delete', ['order_id' => $order->id, 'product_id' => $product->id]) }}" onclick="confirm('Вы действительно хотите удалить товар?')" class="btn btn-danger btn-sm"><i class="bx bx-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <h4 class="p-0 m-0 text-center">Тут пусто</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @php
        session()->forget('data');
    @endphp
@endsection

