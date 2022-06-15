@php
    $themeLink = config('backpack.base.theme') == 'light' ? 'theme/dark' : 'theme/light';
    $langLink = App::isLocale('kh') ? 'lang/en' : 'lang/kh';
@endphp

<!-- =================================================== -->
<!-- ========== Top menu items (ordered left) ========== -->
<!-- =================================================== -->
<ul class="nav navbar-nav d-md-down-none">

    @if (backpack_auth()->check())
        <!-- Topbar. Contains the left part -->
        @include(backpack_view('inc.topbar_left_content'))
    @endif

</ul>
<!-- ========== End of top menu left items ========== -->



<!-- ========================================================= -->
<!-- ========= Top menu right items (ordered right) ========== -->
<!-- ========================================================= -->
<ul class="nav navbar-nav ml-auto @if(config('backpack.base.html_direction') == 'rtl') mr-0 @endif">
    @if (backpack_auth()->guest())
        <li class="nav-item"><a class="nav-link" href="{{ route('backpack.auth.login') }}">{{ trans('backpack::base.login') }}</a>
        </li>
        @if (config('backpack.base.registration_open'))
            <li class="nav-item"><a class="nav-link" href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a></li>
        @endif
    @else
        <!-- Topbar. Contains the right part -->
        @include(backpack_view('inc.topbar_right_content'))
        <li class="nav-item d-none d-md-block">
            <a class="nav-link" href="{{ url($themeLink) }}">
                @if (config('backpack.base.theme') == 'light')
                    Dark
                @else
                    Light
                @endif
            </a>
        </li>
        <li class="nav-item dropdown pr-0 d-none d-md-block">
            <a class="nav-link" href="{{ url($langLink) }}">
                @if(App::isLocale('kh'))
                    EN
                @else
                    KH
                @endif
            </a>
        </li>
        @include(backpack_view('inc.menu_user_dropdown'))
    @endif
</ul>
<!-- ========== End of top menu right items ========== -->
