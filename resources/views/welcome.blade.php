<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div class="d-flex align-items-center justify-content-center row" style="height: 100vh; max-width: 100%">
    <div class="col-10 col-md-4">
        <a href="https://www.ilsollazzo.com/c/disney">
            <img src="{{ asset('imgs/logo-home.png') }}" alt="The Disney Compendium" class="img-fluid">
        </a>
    </div>

</div>
</body>
</html>
