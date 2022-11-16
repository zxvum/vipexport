@extends('admin.layouts.app')

@section('title', 'Редактирование документа')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Редактирование документа: {{ $document->name }}</h3>
                </div>

                <form action="{{ route('admin.documents.edit.post', ['id' => $document->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Название*</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $document->name }}" placeholder="Название магазина">
                        </div>
                        <div class="form-group">
                            <label for="template_file">Файл шаблон</label>
                            @if($document->template_file)
                                <div class="d-flex align-items-centers">
                                    <a href="{{ route('user.documents.download.template', ['file' => $document->template_file]) }}" class="mr-2">{{ $document->template_file }}</a>
                                    <a href="{{ route('admin.documents.delete.template', ['id' => $document->id]) }}" class="text-danger text-md"><i class="fas fa-times-circle"></i></a>
                                </div>
                            @else
                                <input type="file" name="template_file" id="template_file" class="form-control">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="example_file">Файл образец</label>
                            @if($document->example_file)
                                <div class="d-flex align-items-centers">
                                    <a href="{{ route('user.documents.download.template', ['file' => $document->example_file]) }}" class="mr-2">{{ $document->example_file }}</a>
                                    <a href="{{ route('admin.documents.delete.example', ['id' => $document->id]) }}" class="text-danger text-md"><i class="fas fa-times-circle"></i></a>
                                </div>
                            @else
                                <input type="file" name="example_file" id="example_file" class="form-control">
                            @endif
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="is_active" @if($document->is_active) checked @endif>
                            <label class="form-check-label" for="exampleCheck1">Активный</label>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <a href="{{ route('admin.documents.all') }}" class="btn btn-secondary">Назад</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
