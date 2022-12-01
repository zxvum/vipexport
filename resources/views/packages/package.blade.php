@extends('layouts.app')

@section('title', 'Посылка №'.$package->id)

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/multiselect/css/multi-select.css') }}">
@endsection

@section('modals')
    <div class="modal fade" id="edit" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="{{ route('package.edit.post', ['id' => $package->id]) }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editTitle">Редактирование заказа</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row row-cols-1">
                        <div class="col">
                            <label for="edit_title" class="form-label">Название</label>
                            <input type="text" id="edit_title" class="form-control" placeholder="Название заказа" value="{{ $package->title }}">
                        </div>
                        <div class="col mt-3">
                            <label for="edit_address" class="form-label">Адрес</label>
                            <select name="edit_address" id="edit_address" class="form-select">
                                <option selected value="" disabled>---</option>
                                @foreach($addresses as $address)
                                    <option value="{{ $address->id }}" @if($address->id == $package->address->id) selected @endif>{{ $address->country->name }}, {{ $address->city }}, {{ $address->street }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mt-3">
                            <label for="edit_description" class="form-label">Описание</label>
                            <textarea name="" id="" cols="2" style="max-height: 150px" class="form-control"></textarea>
                        </div>
                    </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h5 class="mb-0">Информация о посылке</h5> <span class="badge bg-info">{{ $package->status->name }}</span>
                </div>
                <span class="bx bx-edit h4 cursor-pointer" data-bs-toggle="modal" data-bs-target="#edit"></span>
            </div>
            <div class="card-body">
                <div class="item__text row fw-semibold">
                    <div class="col-md-6">
                        <div class="item__client">Клиент: {{ auth()->user()->name }}</div>
                        <div>Дата создания: {{ $package->created_at }}</div>
                        <div>Дата обновления: {{ $package->updated_at }}</div>
                        <div>Трек номер: US34SDA67ASD76</div>
                        <div class="item__description"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="item__title">Данные доставки:</div>
                        <div class="item__fio">ФИО: {{ $package->address->name }} {{ $package->address->surname }}</div>
                        <div class="item__address text-truncate" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" title="" data-bs-original-title="{{ $package->address->postal_code }}, {{ $package->address->country->name }}, {{ $package->address->region }}, {{{ $package->address->city }}}, {{ $package->address->street }}">Адрес: {{ $package->address->postal_code }}, {{ $package->address->country->name }}, {{ $package->address->region }}, {{{ $package->address->city }}}, {{ $package->address->street }}</div>
                        <div class="item__phone">Телефон: {{ $package->address->phone_number }}</div>
                    </div>
                </div>
                <div class="d-flex align-items-start flex-column flex-md-row justify-content-between gap-3 mt-3">
                    <div class="card accordion-item col-12 col-md-6">
                        <h2 class="accordion-header" id="headingTwo">
                            <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">
                                Отслеживание по трек номеру
                            </button>
                        </h2>
                        <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <span class="text-warning">Обратите внимание:</span> отслеживание по номеру отправления будет работать после того, как партия будет
                                принята в отделение Почты России в Европе. При присвоении вы получите уведомление на свой email адрес.
                                А также сможете самостоятельно отследивать статус на портале - <a href="https://pochta.ru">pochta.ru</a>
                            </div>
                        </div>
                    </div>
                    <div class="card accordion-item col-12 col-md-6">
                        <h2 class="accordion-header" id="headingOne">
                            <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="false" aria-controls="accordionOne">
                                Параметры коробки
                            </button>
                        </h2>

                        <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
                            <div class="accordion-body d-flex flex-column gap-1">
                                <div class="row row-cols-2">
                                    <p><span class="fw-semibold">Размер:</span> 2.54 / 31.75 / 19.05</p>
                                    <p class="text-truncate" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" title="" data-bs-original-title="(СМ) ширина/глубина/высота">(СМ) ширина/глубина/высота</p>
                                </div>
                                <div class="row row-cols-2">
                                    <p><span class="fw-semibold">Вес:</span> 2.68</p>
                                    <p>(КГ)</p>
                                </div>
                                <div class="row row-cols-2">
                                    <p><span class="fw-semibold">Объемный вес:</span> 0.26</p>
                                    <p class="text-truncate" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="" data-bs-original-title="(КГ) <small>Объемный вес = ширина * высоту * ширину / 6000</small>">(КГ) <small>Объемный вес = ширина * высоту * ширину / 6000</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Товары в посылке</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>Всего товаров: 0</div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary">Добавить заказ целиком</button>
                        <button class="btn btn-primary">Выбрать из списка товаров</button>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Название</th>
                            <th class="text-center">Статус</th>
                            <th class="text-center">Кол-во</th>
                            <th class="text-center">Цена</th>
                            <th class="text-center">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        <tr>
                            <td class="text-center"><a href="#" class="link-primary">1</a></td>
                            <td class="text-center">Товар такой-то</td>
                            <td class="text-center"><p style="color: #000000;">Статус</p></td>
                            <td class="text-center">12</td>
                            <td class="text-center">599$</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-primary btn-sm"><i class="bx bx-show"></i></a>
                                <a href="#" type="button" class="btn btn-success btn-sm"><i class="bx bx-edit"></i></a>
                                <a href="#" onclick="confirm('Вы действительно хотите удалить заказ?')" class="btn btn-danger btn-sm"><i class="bx bx-trash"></i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/multiselect/js/jquery.multi-select.js') }}"></script>
    <script>
        $('#optgroup').multiSelect({
            selectableOptgroup: true,
            selectableHeader: "<p class='h5 mb-0 text-center'>Выбор</p>",
            selectionHeader: "<p class='h5 mb-0 text-center'>В посылке</p>",
        });
    </script>
@endsection
