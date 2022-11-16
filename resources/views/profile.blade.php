@extends('layouts.app')

@section('title', 'Профиль')

@section('content')
    <div class="row">
        <!-- About Me -->
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Информация о себе</h5> <small class="text-muted float-end">Для формирования заказов</small>
                </div>
                <div class="card-body">
                    @if(session()->has('profile_update_success'))
                        <div class="alert alert-success">
                            {{ session('profile_update_success') }}
                        </div>
                    @endif
                    @if(session()->has('country_not_find'))
                        <div class="alert alert-danger">
                            {{ session('country_not_find') }}
                        </div>
                    @endif
                    <form action="{{ route('profile.update-profile-information') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="name">Имя</label>
                            <input name="name" type="text" class="form-control" id="name" placeholder="Александр" value="{{ auth()->user()->name }}">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="surname">Фамилия</label>
                            <input name="surname" type="text" class="form-control" id="surname" placeholder="Попов" value="{{ auth()->user()->surname }}">
                            @error('surname') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Email адрес</label>
                            <div class="input-group input-group-merge">
                                <input name="email" type="text" id="email" class="form-control" placeholder="example@company.com" aria-label="john.doe" aria-describedby="basic-default-email2" value="{{ auth()->user()->email }}" disabled>
                            </div>
                            @if(!$errors->has('email')) <div class="form-text"> Вы можете использовать буквы, цифры и точки </div> @endif
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="defaultSelect" class="form-label">Страна</label>
                            <input placeholder="Начните вводить название..." value="{{ session('data.country_name') }}" name="country_name" class="form-control country_input" list="country_list" />
                            <datalist id="country_list">
                                @foreach($countries as $country)
                                    <option value="{{ $country->name }}" />
                                @endforeach
                            </datalist>
                            @error('country_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">Город</label>
                            <input value="{{ session('data.city') ?? auth()->user()->city }}" name="city" class="form-control city_input" id="city" placeholder="Ваш город" disabled>
                            @error('city') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="phone">Номер телефона</label>
                            <input name="phone_number" value="{{ session('data.phone_number') ?? auth()->user()->phone_number }}" type="text" id="phone" class="form-control phone-mask" placeholder="Введите номер телефона">
                            @error('phone_number') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Security -->
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Смена пароля</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="old_password">Старый пароль</label>
                            <div class="input-group input-group-merge">
                                <input
                                    type="password"
                                    id="old_password"
                                    class="form-control"
                                    name="old_password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    required
                                />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="new_password">Новый пароль</label>
                            <div class="input-group input-group-merge">
                                <input
                                    type="password"
                                    id="new_password"
                                    class="form-control"
                                    name="new_password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password"
                                    required
                                />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="new_password_confirm">Подтверждение нового пароля</label>
                            <div class="input-group input-group-merge">
                                <input
                                    type="password"
                                    id="new_password_confirm"
                                    class="form-control"
                                    name="new_password_confirm"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password"
                                    required
                                />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Изменить пароль</button>
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
        $(document).ready(function(){
            $.ajax({
                method: 'GET',
                url: '{{ route('check-country') }}',
                data: {name: $('.country_input').val()},
                success: function (data){
                    console.log(data)
                    if (data) {
                        $('.city_input').prop("disabled", false)
                    } else {
                        $('.city_input').prop("disabled", true)
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
                        if (data) {
                            $('.city_input').prop("disabled", false)
                        } else {
                            $('.city_input').prop("disabled", true)
                        }
                    }
                })
            })
        });
    </script>
@endsection
