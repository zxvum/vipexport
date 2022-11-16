@extends('admin.layouts.app')

@section('title', 'Редактированиe пользователя')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Пользователь: {{ $user->name }} {{ $user->surname }}</h3>
        </div>

        <form>
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input type="text" class="form-control" id="name" value="{{ $user->name }}" placeholder="Имя пользователя">
                </div>
                <div class="form-group">
                    <label for="surname">Фамилия:</label>
                    <input type="text" class="form-control" id="surname" value="{{ $user->surname }}" placeholder="Фамилия пользователя">
                </div>
                <div class="form-group">
                    <label for="email">Email адрес:</label>
                    <input type="email" class="form-control" id="email" value="{{ $user->email }}" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="country_name" class="form-label">Страна:</label>
                    <input value="{{ session('data.country_name') ? session('data.country_name') : $user->country->name }}" placeholder="Начните вводить название..." name="country_name" id="country_name" class="form-control country_input" list="country_list" />
                    <datalist id="country_list">
                        @foreach($countries as $country)
                            <option value="{{ $country->name }}"/>
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group">
                    <label for="city" class="form-label">Город</label>
                    <input type="text" value="{{ session('data.city') ? session('data.city') : $user->city }}"
                           name="city" id="city" class="form-control" placeholder="Город">
                </div>
                <div class="form-group">
                    <label for="phone_number" class="form-label">Номер телефона</label>
                    <input type="number" value="{{ session('data.phone_number') ? session('data.phone_number') : $user->phone_number }}"
                           name="phone_number" id="phone_number" class="form-control" placeholder="Номер телефона">
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('admin.user.all-users') }}" class="btn btn-danger">Отмена</a>
            </div>
        </form>
    </div>
    <div class="card">
        <div class="d-flex align-items-center justify-content-between border-bottom px-3 py-2">
            <h4 class="m-0">Адреса пользователя: {{ $user->addresses->count() }}</h4>
            <a href="{{ route('admin.user.add-address', ['id' => $user->id]) }}" class="btn btn-success d-flex align-items-center">
                <i class="fa fa-plus mr-1"></i>
                Добавить
            </a>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Страна</th>
                    <th>Регион</th>
                    <th>Город</th>
                    <th>Почтовый индекс</th>
                    <th>Улица</th>
                    <th>Номер телефона</th>
                    <th>Email адрес</th>
                </tr>
                </thead>
                <tbody>
                @foreach($user->addresses as $address)
                    <tr>
                        <td>{{ $address->name }}</td>
                        <td>{{ $address->surname }}</td>
                        <td>{{ $address->country->name }}</td>
                        <td>{{ $address->region }}</td>
                        <td>{{ $address->city }}</td>
                        <td>{{ $address->postal_code }}</td>
                        <td>{{ $address->street }}</td>
                        <td>{{ $address->phone_number }}</td>
                        <td>{{ $address->email }}</td>
                        <td>
                            {{--                                <button type="button" class="btn btn-primary"><i class="far fa-eye"></i></button>--}}
                            <a type="button" class="btn btn-success"><i class="fas fa-edit"></i></a>
                            <button type="button" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
