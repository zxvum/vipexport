@extends('layouts.app')

@section('title', 'Все посылки')

@section('content')
    @if(session()->has('package_delete_success'))
        <div class="col-12">
            <div class="alert alert-warning">
                {{ session('package_delete_success') }}
            </div>
        </div>
    @endif
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h5 class="mb-0">Все ваши посылки</h5>
                </div>
                <a href="{{ route('package.create') }}" class="btn btn-primary">
                    Новая
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
                            <th class="text-center">Кол-во заказов</th>
                            <th class="text-center">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @if($packages->count() < 1)
                            <tr>
                                <td colspan="6" class="text-center">У вас еще нет посылок, <a href="{{ route('package.create') }}" class="link-info">создайте новую</a>, чтобы она тут отобразилась.</td>
                            </tr>
                        @else
                            @foreach($packages as $package)
                                <tr>
                                    <td class="text-center">{{ $package->id }}</td>
                                    <td>{{ $package->title }}</td>
                                    <td class="text-center" style="color: {{ $package->status->hex }}">{{ $package->status->name }}</td>
                                    <td class="text-center">
                                        1
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('package.view', ['id' => $package->id]) }}" class="btn btn-primary btn-sm"><i class="bx bx-show"></i></a>
                                        <a href="#" type="button" class="btn btn-success btn-sm"><i class="bx bx-edit"></i></a>
                                        <a href="{{ route('package.delete', ['id' => $package->id]) }}" onclick="confirm('Вы действительно хотите удалить заказ?')" class="btn btn-danger btn-sm"><i class="bx bx-trash"></i></a>
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
