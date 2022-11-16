@extends('admin.layouts.app')

@section('title', 'Документы для заполнения')

@section('content')
    <div class="row">
        <div class="col-12">
            @if(session()->has('document_create_success'))
                <div class="alert alert-success">
                    {{ session('document_create_success') }}
                </div>
            @endif
            @if(session()->has('document_edit_success'))
                <div class="alert alert-success">
                    {{ session('document_edit_success') }}
                </div>
            @endif
            @if(session()->has('document_delete_success'))
                <div class="alert alert-danger">
                    {{ session('document_delete_success') }}
                </div>
            @endif
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Список документов</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="btn-group-sm">
                                <a href="{{ route('admin.documents.create') }}" class="btn btn-primary">
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
                            <th>Активный</th>
                            <th class="d-flex justify-content-end">Действия</th>
                        </tr>
                        </thead>
                        <tbody id="tablecontents">
                        @foreach($documents as $document)
                            <tr class="row1" data-id="{{ $document->id }}">
                                <td>{{ $document->name }}</td>
                                <td>
                                    @if($document->is_active)
                                        Да
                                    @else
                                        Нет
                                    @endif
                                </td>
                                <td class="d-flex justify-content-end">
                                    <a href="{{ route('admin.documents.edit', ['id' => $document->id]) }}" class="btn btn-success mr-1"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('admin.documents.delete', ['id' => $document->id]) }}" class="btn btn-danger" onclick="confirm('Вы действительно хотите удалить документ?')"><i class="far fa-trash-alt"></i></a>
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
                    url: "{{ url('admin/documents/updateOrder') }}",
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
