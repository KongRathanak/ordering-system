<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="app-url" content="{{ env('APP_URL') }}" />

    <title>{{ $title }} | {{ env('APP_NAME', 'Lara') }}</title>
    @laravelPWA
    @stack('before_styles')
    <link rel="icon" href="{{ config('backpack.base.browser_tab_logo') }}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('packages/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') . '?v=' . config('backpack.base.cachebusting_string') }}">
    @stack('after_styles')
</head>
<body class="antialiased">
    <div id="app_bro_bug" class="d-none">
        <nav class="navbar navbar-light bg-white border-bottom py-3">
            <div class="container d-block">
                <div class="row gy-3 align-items-center">
                    <div class="col-md-3 order-5 order-md-first">
                        <div class="d-md-flex">
                            <div class="position-relative align-self-center search-input-wrapper">
                                <input class="form-control me-2 rounded-pill search-input" type="search" placeholder="Search..." aria-label="Search">
                                <i class="las la-search search-input-icon position-absolute"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex justify-content-md-center">
                            <a class="navbar-brand m-0 align-self-center" href="{{ url('/') }}">
                                {!! config('backpack.base.project_logo') !!}
                            </a>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="d-flex flex-row-reverse">
                            <button
                                class="btn btn-default p-0"
                                type="button"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#menu-sidebar-canvas"
                                aria-controls="menu-sidebar-canvas"
                            >
                                <i class="las la-bars la-3x"></i>
                            </button>
                            <div
                                class="offcanvas offcanvas-end border-0 shadow menu-sidebar-canvas"
                                data-bs-scroll="true"
                                data-bs-backdrop="false"
                                tabindex="-1"
                                id="menu-sidebar-canvas"
                                aria-labelledby="menu-sidebar-canvas"
                            >
                                <div class="offcanvas-header justify-content-end">
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <nav class="nav flex-column">
                                        <a class="nav-link text-dark{{ request()->segment(1) == 'homepage' ? ' active' : '' }}" href="{{ url('/') }}">Home</a>
                                        <a class="nav-link text-dark{{ request()->segment(1) == 'articles' ? ' active' : '' }}" href="{{ url('/articles') }}">Category</a>
                                        <a class="nav-link text-dark" href="#">Sport</a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="content-wrapper">
            @yield('content')
        </div>

        <footer class="bg-white py-4">
            <div class="container">
                <span>
                    Copyright &copy;2022 All rights reserved.
                    <div class="d-inline bro-bug-logo">
                        {!! config('backpack.base.project_logo') !!}
                    </div>
                </span>
            </div>
        </footer>

        <a href="#" id="back_to_top" class="btn btn-outline-secondary rounded-circle border-2 d-none">
            <i class="las la-angle-up"></i>
        </a>
    </div>

    @stack('before_scripts')
    <script src="{{ asset('js/app.js') . '?v=' . config('backpack.base.cachebusting_string') }}"></script>
    @stack('after_scripts')
</body>
</html>
