@php
    $isRoleOrPermissionOrNone = true;
    $wrapTag = 'li';
    $user = backpack_user();
    if (isset($roles)) {
        if (is_array($roles)) {
            $isRoleOrPermissionOrNone = $user->hasAnyRole($roles);
        } elseif (is_string($roles) && method_exists($user, $roles)) {
            $isRoleOrPermissionOrNone = $user->{$roles}();
        }
    } elseif (isset($permissions) && $permissions) {
        collect($permissions)->each(function ($permission) use ($user, &$isRoleOrPermissionOrNone) {
            $isRoleOrPermissionOrNone = $user->hasPermissionTo("list {$permission}");
        });
    }
@endphp

@if ($isRoleOrPermissionOrNone)
    <{{ $wrapTag }} class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="nav-icon {{ $entry[0] }}"></i>
            {{ $entry[1] }}
        </a>
        <ul class="nav-dropdown-items">
            @foreach ($drop_items as $item)
                @include('partials.sidebar_link', $item)
            @endforeach
        </ul>
    </{{ $wrapTag }}>
@endif
