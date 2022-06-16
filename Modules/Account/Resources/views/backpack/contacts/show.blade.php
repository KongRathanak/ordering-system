@extends(backpack_view('blank'))

@php
$defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.preview') => false,
];

// if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
$breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid d-print-none">
        <div class="float-right">
            @if ($crud->buttons()->where('stack', 'line')->count())
                @include('crud::inc.button_stack', ['stack' => 'line'])
            @endif
            <a href="javascript: window.print();" class="btn btn-link text-black-50 pr-0"
                title="{{ trans('zpoin.print') }}" data-toggle="tooltip" data-placement="bottom">
                <em class="la la-print"></em>
            </a>
        </div>
        <h2>
            <small class="text-muted">
                {!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')) . ' ' . $crud->entity_name !!}.
            </small>
            @if ($crud->hasAccess('list'))
                <small class="">
                    <a href="{{ url($crud->route) }}" class="font-sm">
                        <em class="la la-angle-double-left"></em>
                        {{ trans('backpack::crud.back_to_all') }}
                        <span>{{ $crud->entity_name_plural }}</span>
                    </a>
                </small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('account::backpack.contacts.contact_profile')
        </div>
        <div class="col-md-9">
            <div class="box-box bg-white p-3 border-top border-primary mb-3">
                @include('account::backpack.contacts.my_profile')
            </div>
        </div>
    </div>
@endsection

@push('after_styles')
    @stack('crud_fields_styles')
@endpush
@push('after_scripts')
    @stack('crud_fields_scripts')
    <script> rmInitializeFieldsWithJavascript('body'); </script>
@endpush
