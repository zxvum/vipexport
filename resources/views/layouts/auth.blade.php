@extends('layouts.connection-layout')

@section('css')
    <link rel="stylesheet" href="../../assets/vendor/css/pages/page-auth.css" />
@endsection

@section('include')
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                @yield('content')
                <!-- /Register -->
            </div>
        </div>
    </div>
@endsection
