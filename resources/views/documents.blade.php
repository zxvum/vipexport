@extends('layouts.app')

@section('title', 'Документы')

@section('content')
    <div class="col-12">
        @if(session()->has('document_upload_success'))
            <div class="alert alert-success">
                {{ session('document_upload_success') }}
            </div>
        @endif
        @if(session()->has('document_delete_success'))
            <div class="alert alert-danger">
                {{ session('document_delete_success') }}
            </div>
        @endif
    </div>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h5 class="mb-0">Ваши документы</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Название документа</th>
                            <th>Статус</th>
                        <th></th>
                            <th>Образец заполнения</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($documents as $document)
                            <tr>
                                <td>{{ $document->name }} @if($document->template_file)
                                        (<a href="{{ route('user.documents.download.template', ['file' => $document->template_file]) }}">скачать шаблон</a>) @endif</td>
                                <td style="color: {{ $document->status->hex }}">{{ $document->status->name }}</td>
                                <td>
                                    @if($document->document_path)
                                        <a href="{{ route('user.documents.download.user-document', ['file' => $document->document_path]) }}">Скачать документ</a> <a href="{{ route('user.documents.delete', ['document_id' => $document->id]) }}" class="text-danger"><i class='bx bx-x-circle'></i></a>
                                    @else
                                        <form action="{{ route('user.documents.upload', ['document_id' => $document->id]) }}" method="POST" class="d-flex flex-column" enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="user_document_{{ $document->id }}" onchange="this.form.submit()" />
                                            @error('user_document_'.$document->id) <small class="text-danger">{{ $message }}</small> @enderror
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    @if($document->example_file)
                                        (<a href="{{ route('user.documents.download.template', ['file' => $document->example_file]) }}">скачать шаблон</a>)
                                    @endif
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
        $(document).ready(function() {
            setTimeout(function() {
                $('small.text-danger').hide({duration: 500})
            }, 5000)
        })
    </script>
@endsection
