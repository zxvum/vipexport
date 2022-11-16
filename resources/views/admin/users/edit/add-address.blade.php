@extends('admin.layouts.app')

@section('title', 'Добавление адреса пользователю')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Пользователь: {{ $user->name }} {{ $user->surname }}</h3>
        </div>

        <form method="post">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input type="text" class="form-control" id="name" name="surname" placeholder="Имя пользователя">
                </div>
                <div class="form-group">
                    <label for="surname">Фамилия:</label>
                    <input type="text" class="form-control" id="surname" name="surname" placeholder="Фамилия">
                </div>
                <div class="form-group">
                    <label for="country_name" class="form-label">Страна:</label>
                    <input value="{{ session('data.country_name') }}" placeholder="Начните вводить название..." name="country_name" id="country_name" class="form-control country_input" list="country_list" />
                    <datalist id="country_list">
                        @foreach($countries as $country)
                            <option value="{{ $country->name }}" />
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group">
                    <label for="region">Регион:</label>
                    <input type="text" class="form-control" id="region" name="region" placeholder="Регион">
                </div>
                <div class="form-group">
                    <label for="city">Город:</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="Город">
                </div>
                <div class="form-group">
                    <label for="postal_code">Почтовый индекс:</label>
                    <input type="number" class="form-control" id="postal_code" name="postal_code" placeholder="Почтовый индекс">
                </div>
                <div class="form-group">
                    <label for="street">Улица:</label>
                    <input type="text" class="form-control" id="street" name="street" placeholder="Улица">
                </div>
                <div class="form-group">
                    <label for="phone_number">Номер телефона:</label>
                    <input type="number" class="form-control" id="phone_number" name="phone_number" placeholder="Номер телефона">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">Создать</button>
                <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}" class="btn btn-danger">Отмена</a>
            </div>
        </form>
    </div>
@endsection
