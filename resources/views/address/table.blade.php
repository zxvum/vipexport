@extends('layouts.app')

@section('title', 'Адреса')

@section('content')

    <div class="col-12">
        @if(session()->has('address_edit_success'))
            <div class="alert alert-success">
                {{ session('address_edit_success') }}
            </div>
        @endif
        @if(session()->has('address_delete_success'))
            <div class="alert alert-warning">
                {{ session('address_delete_success') }}
            </div>
        @endif
    </div>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h5 class="mb-0">Все ваши адреса</h5>
                </div>
                <a href="{{ route('address.create') }}" class="btn btn-primary">
                    Новый
                    <i class="bx bx-plus"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center">Адрес</th>
                            <th class="text-center">ФИ</th>
                            <th class="text-center">Номер телефона</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @if($addresses->count() == 0)
                            <tr>
                                <td colspan="6" class="text-center">У вас еще нет адресов, <a href="{{ route('address.create') }}" class="link-info">создайте новый</a>, чтобы он тут отобразился.</td>
                            </tr>
                        @else
                            @foreach($addresses as $address)
                                <tr>
                                    <td>{{ $address->country->name }}, {{ $address->city }}, {{ $address->street }}</td>
                                    <td class="text-center">{{ $address->name }} {{ $address->surname }}</td>
                                    <td class="text-center">{{ $address->phone_number }}</td>
                                    <td class="text-center">{{ $address->email }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('address.edit', ['id' => $address->id]) }}" type="button" class="btn btn-success btn-sm"><i class="bx bx-edit"></i></a>
                                        <a href="{{ route('address.delete', ['id' => $address->id]) }}" onclick="confirm('Вы действительно хотите удалить заказ?')" class="btn btn-danger btn-sm"><i class="bx bx-trash"></i></a>
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
