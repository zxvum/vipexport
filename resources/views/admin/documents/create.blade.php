@extends('admin.layouts.app')

@section('title', 'Создание документа')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Добавление документа</h3>
                </div>

                <form action="{{ route('admin.documents.create.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Название*</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Название магазина">
                        </div>
                        <div class="form-group">
                            <label for="template_file">Файл шаблон</label>
                            <input type="file" name="template_file" id="template_file" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="example_file">Файл образец</label>
                            <input type="file" name="example_file" id="example_file" class="form-control">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="is_active" checked>
                            <label class="form-check-label" for="exampleCheck1">Активный</label>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Создать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
