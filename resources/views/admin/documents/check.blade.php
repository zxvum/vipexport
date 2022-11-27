@extends('admin.layouts.app')

@section('title', 'Проверка документов')

@section('content')
    <div class="row">

        @if($document)
            <div class="col-4 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $document->document->name }} - {{ auth()->user()->name }} {{ auth()->user()->surname }}</h3>
                    </div>
                    <div class="card-body py-2">
                        <a href="{{ url('storage/user_documents/'.$document->document_path) }}">
                            <img src="{{ asset('storage/user_documents/'.$document->document_path) }}" alt="" class="w-100">
                        </a>
                        <div class="d-flex mt-2 justify-content-between">
                            <a href="{{ route('admin.documents.check.cancel', ['id' => $document->id]) }}" class="btn btn-danger">Отклонить</a>
                            <a href="{{ route('admin.documents.check.access', ['id' => $document->id]) }}" class="btn btn-success">Принять</a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-4 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Все успешно проверено</h3>
                    </div>
                    <div class="card-body py-4 d-flex justify-content-center">
                        <i class="fas fa-check-circle text-xl text-success"></i>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
