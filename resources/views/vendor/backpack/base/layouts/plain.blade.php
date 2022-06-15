<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">
<head>
    @include(backpack_view('inc.head'))
    <link rel="stylesheet" type="text/css" href="{{ asset("css/auth.css").'?v='.config('backpack.base.cachebusting_string') }}">
</head>
<body class="app flex-row align-items-center">
    @yield('header')

    <div class="container-fluid h-100">
        <div class="row justify-content-center justify-content-sm-between h-100">
            <div class="d-none d-md-block col-md-7 col-lg-8 p-0 h-100">
                <div class="d-flex justify-content-center h-100">
                    @yield('content_lft')
                </div>
            </div>
            <div class="col-12 col-md-5 col-lg-4 p-0 h-100">
                <div class="card h-100 rounded-0 border-0 overflow-auto">
                    <div class="card-body w-100">
                        <div class="d-flex h-100 p-4">
                            <div class="align-self-center w-100">
                                @yield('content_rgt')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('before_scripts')
    @stack('before_scripts')

    @include(backpack_view('inc.scripts'))

    @yield('after_scripts')
    @stack('after_scripts')
</body>
</html>
