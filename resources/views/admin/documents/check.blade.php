@extends('admin.layouts.app')

@section('title', 'Проверка документов')

@section('content')
    <div class="row">
{{--        <div class="col-12">--}}
{{--            @if(session()->has('document_create_success'))--}}
{{--                <div class="alert alert-success">--}}
{{--                    {{ session('document_create_success') }}--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Список документов</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table id="table" class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>Название</th>
                            <th>Пользователь</th>
                            <th>Файл</th>
                            <th class="d-flex justify-content-end">Действия</th>
                        </tr>
                        </thead>
                        <tbody id="tablecontents">
                        @foreach($documents as $document)
                            <tr>
                                <td>{{ $document->document->name }}</td>
                                <td>{{ $document->user->name }} {{ $document->user->surname }}</td>
                                <td>{{ $document->document_path }}</td>
                                <td class="d-flex justify-content-end">
                                    <a href="{{ route('admin.documents.edit', ['id' => $document->id]) }}" class="btn btn-success mr-1"><i class="fas fa-check-circle"></i></a>
                                    <a href="{{ route('admin.documents.delete', ['id' => $document->id]) }}" class="btn btn-danger" onclick="confirm('Вы действительно хотите удалить документ?')"><i class="fas fa-times"></i></a>
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
