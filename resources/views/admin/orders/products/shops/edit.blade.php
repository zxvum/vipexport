@extends('admin.layouts.app')

@section('title', 'Редактирование магазина')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Магазин: {{ $shop->name }}</h3>
                </div>

                <form action="{{ route('admin.shop.edit.post', ['id' => $shop->id]) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Название</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Название магазина" value="{{ session('data.name') ? session('data.name') : $shop->name }}">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <a href="{{ route('admin.shop.all') }}" class="btn btn-danger">Отмена</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
