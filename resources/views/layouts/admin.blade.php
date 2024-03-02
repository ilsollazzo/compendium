@extends('adminlte::page')
@section('css')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield('css')
@endsection

@section('content_header')
        <h1>@yield('title')</h1>
    @yield('content_header')
@stop

@section('content')
    {{ $slot ?? '' }}
    @yield('content')
@endsection
