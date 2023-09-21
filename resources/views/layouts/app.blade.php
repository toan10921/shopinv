<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Shop Invest
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="mini-cart-wrap">
                    <button class="btn btn-success btn-open-cart"><strong class="cart-text">Cart</strong>
                            <strong class="cart-number">0</strong> <strong class="cart-total">0 $</strong></button>
                            <div id="mini-cart" class="mini-cart">
                                <div class="header"></div>
                                <div class="body">0 item in your cart</div>
                            </div>
                </div>
            </div>
        </nav>
        @include('layouts.breadcrumb')
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
