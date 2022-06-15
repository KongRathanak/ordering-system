@if (config('backpack.base.breadcrumbs') && isset($breadcrumbs) && is_array($breadcrumbs) && count($breadcrumbs))
	<nav aria-label="breadcrumb">
        <ol class="breadcrumb rounded shadow-sm justify-content-end">
            <li class="flex-fill">
                <div>
                    <h5 class="m-0 text-muted text-uppercase breadcrumb-title">
                        @php
                            $title = $crud->entity_name_plural ?? trans('backpack::base.dashboard');
                            if (strtolower(request()->segment(2)) == 'log') {
                                $title = trans('backpack::logmanager.log_manager');
                            }
                        @endphp
                        {{ $title }}
                    </h5>
                </div>
            </li>
            @foreach ($breadcrumbs as $label => $link)
                @if ($link)
                    <li class="breadcrumb-item text-capitalize"><a href="{{ $link }}">{{ $label }}</a></li>
                @else
                    <li class="breadcrumb-item text-capitalize active" aria-current="page">{{ $label }}</li>
                @endif
            @endforeach
        </ol>
	</nav>
@endif
