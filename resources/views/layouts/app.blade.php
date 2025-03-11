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
    <link href="{{ asset('css/iziToast.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a href="{{route('products.index')}}" class="nav-link">
                            {{ __('navigation.client.products') }}
                        </a></li>
                    <li class="nav-item"><a href="{{route('categories.index')}}" class="nav-link">
                            {{ __('navigation.client.categories') }}
                        </a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span
                                id="cartCountBadge"
                                style="font-size: 10px;"
                                class="position-absolute top-20 start-90 translate-middle badge rounded-pill bg-info">
                                {{Cart::instance('cart')->countItems()}}
                              </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown locale-dropdown">
                            <button class="nav-link dropdown-toggle local-dropdown_title" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                {{ App::currentLocale() }}
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <button class="dropdown-item" data-locale="en"
                                            @if (App::currentLocale() === 'en') disabled @endif
                                    >
                                        en
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" data-locale="uk"
                                            @if (App::currentLocale() === 'uk') disabled @endif
                                    >
                                        uk
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @hasanyrole('admin|moderator')
                                <a href="{{route('admin.dashboard')}}" class="dropdown-item">Admin panel</a>
                                @endhasanyrole
                                <a href="{{route('account.wishlist')}}" class="dropdown-item">Wish List</a>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
<script src="{{ asset('js/iziToast.js') }}"></script>
@include('vendor.lara-izitoast.toast')
@stack('footer-js')
@vite(['resources/js/admin/export.js'])
</body>
</html>
