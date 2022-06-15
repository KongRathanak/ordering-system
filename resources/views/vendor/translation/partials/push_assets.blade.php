@push('before_styles')
    <link rel="stylesheet" href="{{ asset('/vendor/translation/css/main.css') }}">
    <style>
        .panel {
            margin: 0;
        }

        .panel, .panel-body th {
            color: #495057!important;
        }

        .sidebar li.nav-item {
            padding: 0 !important;
        }

        ul {
            display: block;
        }

        li {
            padding: 0;
        }

        .search-input {
            padding: 0.3rem 1rem 0.2rem 2.5rem;
        }
    </style>
@endpush

@push('after_scripts')
    <script src="{{ asset('/vendor/translation/js/app.js') }}"></script>
@endpush
