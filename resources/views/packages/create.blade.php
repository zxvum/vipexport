@extends('layouts.app')

@section('title', 'Создание посылки')

@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-12 col-lg-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Создание посылки</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('package.create.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="title">Название</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Новый заказ" value="Заказ №{{ $user_package_count+1 }}" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="address">Адрес для доставки</label>
                            <select name="address_id" id="address" class="form-select">
                                <option value="" selected>---</option>
                                @foreach($user_addresses as $address)
                                    <option value="{{ $address->id }}">{{ $address->country->name }}, {{ $address->city }}, {{ $address->street }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('address_id'))
                                <small class="text-danger">{{ $errors->first('address_id') }}</small>
                            @else
                                <a href="{{ route('address.create') }}">Добавить адрес</a>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="description">Описание</label>
                            <input type="text" class="form-control" id="description" placeholder="Описание и пожелания к заказу">
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Дальше</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
