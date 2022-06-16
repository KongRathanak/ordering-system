<!-- text input -->
@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')

    @if(isset($field['prefix']) || isset($field['suffix'])) <div class="input-group"> @endif
        @if(isset($field['prefix'])) <div class="input-group-prepend"><span class="input-group-text">{!! $field['prefix'] !!}</span></div> @endif
        <input
            type="text"
            name="{{ $field['name'] }}"
            data-init-function="bpFieldInitFlexiPhone"
            value="{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}"
            {{-- @include('crud::fields.inc.attributes') --}}
            class="js-keypress-number form-control @error( $field['name']) is-invalid @enderror"
        >
        {{-- @if($errors->has($field['name']))<span style="font-size: 80%">{{ $errors->first($field['name']) }}</span>@endif --}}
        @if(isset($field['suffix'])) <div class="input-group-append"><span class="input-group-text">{!! $field['suffix'] !!}</span></div> @endif
    @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')

{{--  Prevent script load multiple time in backpack crud --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    @push('crud_fields_styles')
        <link rel="stylesheet" href="{{ asset('assets/libraries/intl-tel-input/css/intlTelInput.min.css') }}?v=0.0.2">
        <style>.intl-tel-input{width: 100%;}</style>
    @endpush


    @push('crud_fields_scripts')
        {{-- move utilsScript out  of js to fix load from ajax not work --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@15.0.2/build/js/utils.js"></script> --}}

        <script src="{{ asset('assets/libraries/intl-tel-input/js/utils.js') }}?v=0.0.1"></script>
        <script src="{{ asset('assets/libraries/intl-tel-input/js/intlTelInput.min.js') }}?v=0.0.1"></script>

        <script>
            function itiCallback(elem, iti) {
                elem.val(iti.getNumber());
            }

            function bpFieldInitFlexiPhone(element) {
                // must be define as var instead of const
                var iti = window.intlTelInput(element[0], {
                    preferredCountries: ['kh'],
                    autoFormat: false,
                    // formatOnInit:true,
                    formatOnDisplay: false,
                    customPlaceholder: function () {
                        return '{{ $field['placeholder'] ?? $field['label'] ?? 'Phone'}}';
                    },
                    // utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@15.0.2/build/js/utils.js",
                })

                // register country change select
                element.on('countrychange', function () {
                    itiCallback(element, iti)
                })

                // register any keypress event
                element.on('keyup', function () {
                    itiCallback(element, iti)
                })
            }
            // $(function () {
            //     var input = 'input_'+ '{{ $field['name'] }}'
            //     var iti = 'iti_'+ '{{ $field['name'] }}'
            //     var myHandle = 'myHandle_'+ '{{ $field['name'] }}'


            //     input = document.querySelector("#{{ $field['name'] }}");
            //          iti = intlTelInput(input, {
            //             preferredCountries: ['kh'],
            //             autoFormat: false,
            //             // formatOnInit:true,
            //             formatOnDisplay: false,
            //             customPlaceholder: function () {
            //                 return 'Phone';
            //             },
            //             utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@15.0.2/build/js/utils.js",
            //         })

            //         window.iti = iti;

            //         myHandle = function ()  { $('#{{ $field['name'] }}').val(iti.getNumber()); }

            //         input.addEventListener("countrychange", function() {
            //             window[myHandle]();
            //         });

            //         input.addEventListener('change', myHandle);
            //         input.addEventListener('keyup', myHandle);

            // });
        </script>
    @endpush
@endif
{{-- Note: you can use @if ($crud->checkIfFieldIsFirstOfItsType($field, $fields)) to only load some CSS/JS once, even though there are multiple instances of it --}}
