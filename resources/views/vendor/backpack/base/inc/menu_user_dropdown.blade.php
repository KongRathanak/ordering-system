<li class="nav-item dropdown" id="nav_avatar_top">
    <a class="nav-link m-0 mr-1" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="position: relative;margin: 0 10px;">
        <div class="d-flex align-items-center avatar_wrapper shadow-xs">
            <div>
                @if (backpack_auth()->user()->avatarOriginal)
                    <img class="img-avatar shadow-xs border-0" style="width: 35px;height: 35px;" src="{{ backpack_avatar_url(backpack_auth()->user()) }}" alt="{{ backpack_auth()->user()->name }}" onerror="this.style.display='none'" style="margin: 0;position: absolute;left: 0;z-index: 1;">
                @else
                    <div class="text-uppercase backpack-avatar-menu-container shadow-xs text-muted border-0" style="width: 35px;height:35px;border-radius: 50%;color: #FFF;line-height: 35px;">
                        {{backpack_user()->getAttribute('name') ? mb_substr(backpack_user()->name, 0, 1, 'UTF-8') : 'A'}}
                    </div>
                @endif
            </div>
            <label class="m-0 pl-2 text-muted d-none d-sm-block">{{ backpack_user()->name ?? '' }}</label>
        </div>
    </a>
    <div class="dropdown-menu border-0 shadow-sm {{ config('backpack.base.html_direction') == 'rtl' ? 'dropdown-menu-left' : 'dropdown-menu-right' }} mr-3 p-0">
        <a class="dropdown-item py-2" href="{{ backpack_url('edit-account-info') }}">
            <i class="la la-user"></i>
            {{ trans('backpack::base.my_account') }}
        </a>
        <a class="dropdown-item py-2 d-block d-md-none" href="{{ url($themeLink) }}">
            @if (config('backpack.base.theme') == 'light')
                <i class="las la-moon"></i>
                Dark
            @else
                <i class="las la-sun"></i>
                Light
            @endif
        </a>
        <a class="dropdown-item py-2 d-block d-md-none" href="{{ url($langLink) }}">
            <i class="las la-language"></i>
            @if(App::isLocale('kh'))
                English
            @else
                Khmer
            @endif
        </a>
        <a class="dropdown-item py-2" href="{{ backpack_url('logout') }}">
            <i class="la la-lock"></i>
            {{ trans('backpack::base.logout') }}
        </a>
    </div>
</li>
<li class="pr-md-4"></li>

@push('after_scripts')
    <script type="text/javascript">
        $(function() {
            function checkWidth() {
                var width = $(window).width();
                var ele = $('#nav_avatar_top');
                if (width < 768) {
                    ele.addClass('pr-4');
                } else {
                    ele.removeClass('pr-4');
                }
            }
            checkWidth();
            $(window).resize(checkWidth);
        });
    </script>
@endpush
