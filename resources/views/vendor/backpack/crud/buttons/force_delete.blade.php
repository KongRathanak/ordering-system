@php
    $operation = '';
    if (method_exists($crud, 'getCurrentOperation')) {
        $operation = trim($crud->getCurrentOperation());
    }

    $isRoleOrPermissionOrNone = true;
    if (isset($roles) && $roles) {
        if (isset($rolePermissionDefaul) && $rolePermissionDefaul) {
            $isRoleOrPermissionOrNone = backpack_user()->hasAnyRole($roles);
        } else {
            $isRoleOrPermissionOrNone = backpack_user()->{$roles}();
        }

    }

    if (!isset($roles) && isset($permission) && $permission) {
        if (isset($rolePermissionDefaul) && $rolePermissionDefaul) {
            $isRoleOrPermissionOrNone = backpack_user()->can($permission);
        } else {
            $isRoleOrPermissionOrNone = backpack_user()->{$permission}();
        }
    }

    $trans = 'custom.';
    $cancelTrans = trans($trans.'cancel');
    $failDeleteTrans =  trans($trans.'delete_confirmation_not_message');
    $buttonText = trans($trans.'delete');
    $buttonName = 'deleteEntry';
    $method = 'DELETE';
    $btnColor = 'danger';
    $btnForceDelete = '<em class="la la-times"></em>';
    $btnForceDeleteTitle = trans('custom.force_delete');
    $urlQuery = [];

    if (in_array('force_delete', $props)) {
        $buttonName = 'forceDelete';
        $urlQuery[] = 'force_delete=1';
        $urlQuery[] = 'operation=' . $crud->getCurrentOperation();
        $buttonText = trans($trans.'force_delete');
    }

    if (in_array('restore_delete', $props)) {
        $buttonName = 'restoreDelete';
        $buttonText = trans($trans.'restore');
        $method = 'POST';
        $btnColor = 'success';
        $btnForceDelete = '<em class="la la-undo"></em>';
        $btnForceDeleteTitle = trans('custom.restore');
    }

    if (in_array('color_default', $props)) $btnColor = 'default';
@endphp

@if($isRoleOrPermissionOrNone)
    @if(in_array('button', $props))
        <a
            href="javascript:void(0)"
            onclick="{!! $buttonName !!}(this)"
            data-route="{{ $url }}?{!! implode('&', $urlQuery) !!}"
            class="{!! $wrapperClass ?? 'btn btn-sm btn-link text-'.$btnColor !!} tooltip-selector"
            data-button-type="{{ mb_strtolower($buttonName) }}"
            data-toggle="tooltip"
            data-placement="bottom"
            title="{!! $btnForceDeleteTitle !!}"
        >
            {!! $btnForceDelete !!}
        </a>
    @endif

    @php
        $titleWarning = trans($trans.'warning');
        $textWarning = trans($trans.'you_about_to_permanently_delete_this');
        $titleFail = trans($trans.'item_not_deleted');
        $textFail = trans($trans.'your_item_might_not_have_deleted');
        $titleSuccess = trans($trans.'item_deleted');
        $textSuccess = trans($trans.'item_has_been_deleted_successfully');
        $buttonAction = 'bg-danger';
        $icon = 'warning';

        if (in_array('restore_delete', $props)) {
            $titleWarning = trans($trans.'info');
            $textWarning = trans($trans.'are_you_sure_to_restore_this_item');
            $titleFail = trans($trans.'item_not_restored');
            $textFail = trans($trans.'your_item_might_not_have_restored');
            $titleSuccess = trans($trans.'item_restored');
            $textSuccess = trans($trans.'item_has_been_restored_successfully');
            $buttonAction = 'bg-success';
            $icon = 'info';
        }
    @endphp

    @push('after_scripts') @if ($operation == 'list') @endpush @endif
        <script type="text/javascript">
            if (typeof {{ $buttonName }} != 'function') {
                tooltipTrigger();
                $("[data-button-type={{ mb_strtolower($buttonName) }}]").unbind('click');

                function {{ $buttonName }}(button) {
                    var button = $(button);
                    var route = button.attr('data-route');
                    var row = $("a[data-route='"+route+"']").closest('tr');

                    swal({
                        title: "{!! $titleWarning !!}",
                        text: "{!! $textWarning !!}",
                        icon: "{!! $icon !!}",
                        buttons: {
                            cancel: {
                            text: "{!! $cancelTrans !!}",
                            value: null,
                            visible: true,
                            className: "bg-secondary",
                            closeModal: true,
                        },
                            delete: {
                            text: "{!! $buttonText !!}",
                            value: true,
                            visible: true,
                            className: "{{ $buttonAction }}",
                        }
                        },
                    }).then((value) => {
                        if (value) {
                            $.ajax({
                                url: route,
                                type: '{{ $method }}',
                                success: function(result) {
                                    if (result instanceof Object && result.success) {
                                        // Show a success message
                                        swal({
                                            title: "{!! $titleSuccess !!}",
                                            text: "{!! $textSuccess !!}",
                                            icon: "success",
                                            timer: 4000,
                                            buttons: false,
                                        });

                                        // Hide the modal, if any
                                        $('.modal').modal('hide');

                                        // Remove the details row, if it is open
                                        if (row.hasClass("shown")) {
                                            row.next().remove();
                                        }

                                        // Remove the row from the datatable
                                        row.remove();

                                        if (result instanceof Object && result.redirect) {
                                            setTimeout(() => window.location.href = result.redirect, 1000);
                                            return false;
                                        }
                                    } else {
                                        // Show an error alert
                                        swal({
                                            title: "{!! $titleFail !!}",
                                            text: "{!! $textFail !!}",
                                            icon: "error",
                                            timer: 2000,
                                            buttons: false,
                                        });
                                    }
                                },
                                error: function(result) {
                                    // Show an alert with the result
                                    var $errors = result.responseJSON.errors;
                                    var defaultMessage= "{!! $failDeleteTrans !!}";

                                    defaultMessage = $errors ? defaultMessage : (
                                    result.responseJSON.message ? result.responseJSON.message : defaultMessage);
                                    swal({
                                        title: "{!! $titleFail !!}",
                                        text: defaultMessage,
                                        icon: "error",
                                        timer: 4000,
                                        buttons: false,
                                    });
                                }
                            });
                        }
                    });
                }
            }
        </script>
    @if ($operation != 'list') @endpush @endif
@endif
