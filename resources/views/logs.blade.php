@extends(backpack_view('layouts.top_left'))

@php
  $breadcrumbs = [
    trans('backpack::crud.admin') => backpack_url('dashboard'),
    trans('backpack::logmanager.log_manager') => backpack_url('log'),
    trans('backpack::logmanager.existing_logs') => false,
  ];
@endphp

@section('header')
    <section class="container-fluid mb-3">
        <a href="{{ route('log.delete_all') }}" class="btn btn-danger" id="delete_all" title="{{ trans('flexi.delete') }}">
            <em class="la la-trash"></em>
            {{ trans('Delete All') }}
        </a>
        <h2 class="d-inline text-muted"><small>{{ trans('backpack::logmanager.log_manager_description') }}</small></h2>
    </section>
@endsection

@section('content')

<!-- Default box -->
  <div class="card">
    <div class="card-body p-0 table-responsive">
      <table class="table table-hover table-condensed pb-0 mb-0" description="" aria-label="">
        <thead>
          <tr>
            <th scope>#</th>
            <th scope>{{ trans('backpack::logmanager.file_name') }}</th>
            <th scope>{{ trans('backpack::logmanager.date') }}</th>
            <th scope>{{ trans('backpack::logmanager.last_modified') }}</th>
            <th scope class="text-right">{{ trans('backpack::logmanager.file_size') }}</th>
            <th scope>{{ trans('backpack::logmanager.actions') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($files as $key => $file)
          <tr>
            <th scope="row">{{ $key + 1 }}</th>
            <td>{{ $file['file_name'] }}</td>
            <td>{{ \Carbon\Carbon::createFromTimeStamp($file['last_modified'])->formatLocalized('%d %B %Y') }}</td>
            <td>{{ \Carbon\Carbon::createFromTimeStamp($file['last_modified'])->formatLocalized('%H:%M') }}</td>
            <td class="text-right">{{ round((int)$file['file_size']/1048576, 2).' MB' }}</td>
            <td>
                <a class="btn btn-sm btn-link" href="{{ url(config('backpack.base.route_prefix', 'admin').'/log/preview/'. encrypt($file['file_name'])) }}"><em class="la la-eye"></em> {{ trans('backpack::logmanager.preview') }}</a>
                <a class="btn btn-sm btn-link" href="{{ url(config('backpack.base.route_prefix', 'admin').'/log/download/'.encrypt($file['file_name'])) }}"><em class="la la-cloud-download"></em> {{ trans('backpack::logmanager.download') }}</a>
                <a class="btn btn-sm btn-link" data-button-type="delete" href="{{ url(config('backpack.base.route_prefix', 'admin').'/log/delete/'.encrypt($file['file_name'])) }}"><em class="la la-trash-o"></em> {{ trans('backpack::logmanager.delete') }}</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

    </div><!-- /.box-body -->
  </div><!-- /.box -->

@endsection

@section('after_styles')
    <style>
        table.table thead tr th {
            min-width: 150px;
        }

        table.table thead tr th:first-child {
            min-width: 50px;
        }
    </style>
@endsection

@section('after_scripts')
<script>
  jQuery(document).ready(function($) {
    $(document).on('click', '#delete_all', function(e) {
        e.preventDefault();
        if (confirm("{{ trans('zpoin.are_you_sure_you_want_to_delete_all_items') }}") == true) {
            window.location.href = $(this).attr('href');
        }
    })
    // capture the delete button
    $("[data-button-type=delete]").click(function(e) {
        e.preventDefault();
        var delete_button = $(this);
        var delete_url = $(this).attr('href');

        if (confirm("{{ trans('backpack::logmanager.delete_confirm') }}") == true) {
            $.ajax({
                url: delete_url,
                type: 'DELETE',
                data: {
                  _token: "{{ csrf_token() }}"
                },
                success: function(result) {
                    // delete the row from the table
                    delete_button.parentsUntil('tr').parent().remove();

                    // Show an alert with the result
                    new Noty({
                        text: "<strong>{{ trans('backpack::logmanager.delete_confirmation_title') }}</strong><br>{{ trans('backpack::logmanager.delete_confirmation_message') }}",
                        type: "success"
                    }).show();
                },
                error: function(result) {
                    // Show an alert with the result
                    new Noty({
                        text: "<strong>{{ trans('backpack::logmanager.delete_error_title') }}</strong><br>{{ trans('backpack::logmanager.delete_error_message') }}",
                        type: "warning"
                    }).show();
                }
            });
        } else {
            new Noty({
                text: "<strong>{{ trans('backpack::logmanager.delete_cancel_title') }}</strong><br>{{ trans('backpack::logmanager.delete_cancel_message') }}",
                type: "info"
            }).show();
        }
      });

  });
</script>
@endsection
