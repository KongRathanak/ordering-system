@extends(backpack_view('layouts.top_left'))

@php
  $breadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard'),
    trans('backpack::logmanager.log_manager') => backpack_url('log'),
    trans('backpack::logmanager.preview') => false,
  ];
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <small class="p-0 text-muted">{{ trans('backpack::logmanager.file_name') }}: <em>{{ $file_name }}</em></small>
            <small><a href="{{ backpack_url('log') }}" class="hidden-print font-sm"><em class="la la-angle-double-left"></em> {{ trans('backpack::logmanager.back_to_all_logs') }}</a></small>
        </h2>
    </section>
@endsection

@section('content')
  <div id="accordion" role="tablist" aria-multiselectable="true">
    @forelse($logs as $key => $log)
        <div class="card mb-0 pb-0">
            <div class="card-header bg-{{ $log['level_class'] }}" role="tab" id="heading{{ $key }}">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $key }}" aria-expanded="true" aria-controls="collapse{{ $key }}" class="text-white">
                    <em class="la la-{{ $log['level_img'] }}"></em>
                    <span>[{{ $log['date'] }}]</span>
                    {{ Str::limit($log['text'], 150) }}
                </a>
            </div>
            <div id="collapse{{ $key }}" class="panel-collapse collapse p-3" role="tabpanel" aria-labelledby="heading{{ $key }}">
            <div class="panel-body">
                <p>{{$log['text']}}</p>
                <pre>
                    <code class="php">
                        {{ trim($log['stack']) }}
                    </code>
                </pre>
            </div>
            </div>
        </div>
    @empty
        <h3 class="text-center">{{__('zpoin.no_logs_to_display')}}</h3>
    @endforelse
  </div>

@endsection

@section('after_scripts')
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/default.min.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js"></script>
  <script>hljs.initHighlightingOnLoad();</script>
@endsection
