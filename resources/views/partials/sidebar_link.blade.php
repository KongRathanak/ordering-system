@php
    $isRoleOrPermissionOrNoneLink = true;
    $wrapTag = 'li';
    $user = backpack_user();
    if (isset($roles)) {
        if (is_array($roles)) {
            $isRoleOrPermissionOrNoneLink = $user->hasAnyRole($roles);
        } elseif (is_string($roles) && method_exists($user, $roles)) {
            $isRoleOrPermissionOrNoneLink = $user->{$roles}();
        }
    } elseif (isset($permission) && $permission) {
        $isRoleOrPermissionOrNoneLink = $user->hasPermissionTo("list {$permission}");
    }
@endphp

@if($isRoleOrPermissionOrNoneLink)
    @if(!isset($nolink)) <{{ $wrapTag }} class="nav-item"> @endif
        <a
            href="{!! isset($nolink) ? '#' : $entry[0] !!}"
            class="nav-link {{ !isset($nolink) ? '' : 'nav-dropdown-toggle'  }} text-truncate"
            data-toggle="tooltip"
            data-placement="bottom"
            title="{!! $entry[1] !!}"
        >
            <em class="nav-icon {!! isset($entry[2]) && $entry[2] ? $entry[2] : 'la la-angle-right' !!}"></em>

            @if(!isset($nolink)) <span> @endif
                {!! $entry[1] !!}
            @if(!isset($nolink)) </span> @endif
        </a>
    @if(!isset($nolink)) </{{ $wrapTag }}> @endif
@endif
