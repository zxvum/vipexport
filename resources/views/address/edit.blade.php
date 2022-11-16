@extends('layouts.app')

@section('title', 'Редактирование адресаы')

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Изменение адреса</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('address.edit.post', ['id' => $address->id]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="name">Имя</label>
                            <input name="name" value="{{ session('data.name') ? session('data.name') : $address->name }}" type="text" class="form-control" id="name" placeholder="Введите имя получателя">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="surname">Фамилия</label>
                            <input name="surname" value="{{ session('data.surname') ? session('data.surname') : $address->surname }}" type="text" class="form-control" id="surname" placeholder="Введите фамилию получателя">
                            @error('surname') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="defaultSelect" class="form-label">Страна</label>
                            <input value="{{ session('data.country_name') ? session('data.country_name') : $address->country->name }}" placeholder="Начните вводить название..." name="country_name" class="form-control country_input" list="country_list" />
                            <datalist id="country_list">
                                @foreach($countries as $country)
                                    <option value="{{ $country->name }}" />
                                @endforeach
                            </datalist>
                            @error('country_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="postal_code">Индекс</label>
                            <input name="postal_code" value="{{ session('data.postal_code') ? session('data.postal_code') : $address->postal_code }}" type="text" class="form-control postal_code" id="postal_code" placeholder="Введите индекс города" disabled>
                            @error('postal_code') <small class="text-danger index-error">{{ $message }}</small> @enderror
                            <small class="text-danger regex-postal-code-error d-none">Формат индекса не соответствует вашей стране региону</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="region">Область/край</label>
                            <input name="region" value="{{ session('data.region') ? session('data.region') : $address->region }}" type="text" class="form-control" id="region" placeholder="Введите индекс города">
                            @error('region') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="city">Город</label>
                            <input name="city" value="{{ session('data.city') ? session('data.city') : $address->city }}" type="text" class="form-control" id="city" placeholder="Введите город получателя">
                            @error('city') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="street">Улица</label>
                            <input name="street" value="{{ session('data.street') ? session('data.street') : $address->street }}" type="text" class="form-control" id="street" placeholder="Воронежская 64">
                            @error('street') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="phone">Номер телефона</label>
                            <input name="phone_number" value="{{ session('data.phone_number') ? session('data.phone_number') : $address->phone_number }}" type="text" class="form-control phone_number" id="phone" placeholder="Ваш номер телефона">
                            <small class="text-danger phone-error">{{ $errors->first('phone_number') }}</small>
                            <small class="text-danger regex-phone-error d-none">Формат номера телефона не соответствует страндартам</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email адрес</label>
                            <input name="email" value="{{ session('data.email') ? session('data.email') : $address->email }}" type="text" class="form-control" id="email" placeholder="example@company.com">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                            <a href="{{ route('address.all') }}" class="btn btn-secondary">Назад</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @php
        session()->forget('data')
    @endphp
@endsection

@section('js')
    <script>
        setTimeout(function (){
            $('.alert').hide({duration: 500})
        }, 8000)

        $(document).ready(function(){
            var regex = ''

            $.ajax({
                method: 'GET',
                url: '{{ route('check-country') }}',
                data: {name: $('.country_input').val()},
                success: function (data){
                    console.log(data.status)
                    if (data.status) {
                        $('.postal_code').prop("disabled", false)
                        if (data.regex) {
                            regex = data.regex
                        }
                    } else {
                        $('.postal_code').prop("disabled", true)
                    }
                }
            })
            $('.country_input').on('input', function(){
                $.ajax({
                    method: 'GET',
                    url: '{{ route('check-country') }}',
                    data: {name: $(this).val()},
                    success: function (data){
                        console.log(data)
                        if (data.status) {
                            $('.postal_code').prop("disabled", false)
                            if (data.regex) {
                                regex = data.regex
                                console.log(regex)
                            }
                        } else {
                            $('.postal_code').prop("disabled", true)
                        }
                    }
                })
            })

            $('.postal_code').on('input', function () {
                $('.index-error').addClass('d-none')
                checkRegex(regex, $(this).val()) ? $('.regex-postal-code-error').addClass('d-none') : $('.regex-postal-code-error').removeClass('d-none')
            })

            $('.phone_number').on("input", function () {
                $('.phone-error').addClass('d-none')
                const regex = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/
                checkRegex(regex, $(this).val()) ? $('.regex-phone-error').addClass('d-none') : $('.regex-phone-error').removeClass('d-none')
            })
        });

        function checkRegex(regex, value){
            return !!value.match(regex);
        }
    </script>
@endsection
