@extends('errors.layout')

@php
    $error_number = 404;
@endphp

@section('title')
    Page not found.
@endsection

@section('description')
    @php
        $default_error_message = "Please <a href='javascript:history.back()''>go back</a> or return to <a href='".url('/admin')."'>our homepage</a>.";
        $error_message = $default_error_message;
        if (isset($exception) && $exception->getMessage()) {
            $error_message = $exception->getMessage();
        }
    @endphp
    {!! $error_message !!}
@endsection
