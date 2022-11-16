@extends('layouts.app')

@section('title', 'Новый заказ')

@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-12 col-lg-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Создание заказа</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('order.create-order') }}" method="get">
                        <div class="mb-3">
                            <label class="form-label" for="title">Название</label>
                            <input type="text" class="form-control" name="name" id="title" placeholder="Новый заказ" value="{{ session('data.name') ? session('data.name') : $title }}" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="description">Описание</label>
                            <input value="{{ session('data.description') ? session('data.description') : '' }}" type="text" class="form-control" name="description" id="description" placeholder="Описание и пожелания к заказу">
                            @error('description') <small class="text-danger">error</small> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Перейти к добавлению товаров</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @php
        session()->forget('data')
    @endphp
@endsection
