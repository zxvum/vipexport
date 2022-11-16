@extends('admin.layouts.app')

@section('title', 'Все магазины')

@section('content')
    <div class="row">
        <div class="col-12">
            @if(session()->has('shop_not_find'))
                <div class="alert alert-danger">{{ session('shop_not_find') }}</div>
            @endif
            @if(session()->has('shop_delete_success'))
                <div class="alert alert-success">{{ session('shop_delete_success') }}</div>
            @endif
            @if(session()->has('shop_delete_failed'))
                <div class="alert alert-danger">{{ session('shop_delete_failed') }}</div>
            @endif
            @if(session()->has('shop_edit_success'))
                <div class="alert alert-success">{{ session('shop_edit_success') }}</div>
            @endif
            @if(session()->has('shop_create_success'))
                <div class="alert alert-success">{{ session('shop_create_success') }}</div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Список магазинов</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="btn-group-sm">
                                <a href="{{ route('admin.shop.add') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table id="table" class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>Название</th>
                            <th class="d-flex justify-content-end">Действия</th>
                        </tr>
                        </thead>
                        <tbody id="tablecontents">
                        @foreach($shops as $shop)
                            <tr class="row1" data-id="{{ $shop->id }}">
                                <td>{{ $shop->name }}</td>
                                <td class="d-flex justify-content-end">
                                    <a href="{{ route('admin.shop.edit', ['id' => $shop->id]) }}" class="btn btn-success mr-1"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('admin.shop.delete', ['id' => $shop->id]) }}" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
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

@section('js')
    <script>
        $(function () {
            $("#tablecontents" ).sortable({
                items: "tr",
                cursor: 'move',
                opacity: 0.6,
                update: function() {
                    sendOrderToServer();
                }
            });

            function sendOrderToServer() {

                var order = [];
                $('tr.row1').each(function(index,element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index+1
                    });
                });

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('admin/shop/updateOrder') }}",
                    data: {
                        order:order,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            console.log(response);
                        } else {
                            console.log(response);
                        }
                    }
                });

            }
        });
    </script>
@endsection
