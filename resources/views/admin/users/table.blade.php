@extends('admin.layouts.app')

@section('title', 'Все пользователи')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Responsive Hover Table</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>ФИ</th>
                            <th>Email</th>
                            <th>Страна</th>
                            <th>Город</th>
                            <th>Номер телефона</th>
                            <th>Адресов</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }} {{ $user->surname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->country->name }}</td>
                                <td>{{ $user->city }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>{{ $user->addresses->count() }}</td>
                                <td>
                                    {{--                                <button type="button" class="btn btn-primary"><i class="far fa-eye"></i></button>--}}
                                    <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                    <button type="button" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
