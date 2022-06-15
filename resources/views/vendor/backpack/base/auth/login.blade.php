@extends(backpack_view('layouts.plain'))

@section('content_lft')
    <img src="{{ asset('assets/login-v2.svg') }}" alt="login-v2.svg" class="img-fluid login-pic">
@endsection

@section('content_rgt')
    <div id="login_form">
        <h4 class="mb-3">
            Welcome to
            <a href="{{ url('/') }}">
                {!! config('backpack.base.project_logo') !!}
            </a>!
        </h4>
        <span class="text-muted">
            Please sign-in to your account and start the adventure
        </span>
        @if ($errors->has('message'))
            <span class="d-block alert alert-danger mt-3">
                {{ $errors->first('message') }}
            </span>
        @endif
        <form class="mt-3" role="form" method="POST" action="{{ route('backpack.auth.login') }}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label class="control-label" for="{{ $username }}">{{ config('backpack.base.authentication_column_name') }}</label>
                <div>
                    <input type="text" class="form-control{{ $errors->has($username) ? ' is-invalid' : '' }}" name="{{ $username }}" value="{{ old($username) }}" id="{{ $username }}">
                    @if ($errors->has($username))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first($username) }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="password">{{ trans('backpack::base.password') }}</label>
                <div class="position-relative">
                    <input :type="is_visible ? 'text' : 'password'" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password">
                    <button
                        class="position-absolute btn btn-link shadow-none text-secondary"
                        type="button"
                        style="top: 0; right: 0;"
                        @click="passwordVisible"
                    >
                        <i :class="`las la-eye${is_visible ? '-slash' : ''}`"></i>
                    </button>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div>
                    <div class="checkbox">
                        <label class="m-0">
                            <input type="checkbox" name="remember"> {{ trans('backpack::base.remember_me') }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="mb-2">
                    <button type="submit" class="btn btn-block btn-primary font-weight-bold">
                        <i class="las la-sign-in-alt"></i>
                        {{ trans('backpack::base.login') }}
                    </button>
                </div>
                @if (backpack_users_have_email() && config('backpack.base.setup_password_recovery_routes', true))
                    <div class="text-center"><a href="{{ route('backpack.auth.password.reset') }}">{{ trans('backpack::base.forgot_your_password') }}</a></div>
                @endif
            </div>
        </form>
    </div>
@endsection

@push('after_scripts')
    <script>
        new Vue({
            el: '#login_form',
            data() {
                return {
                    is_visible: false,
                };
            },
            methods: {
                passwordVisible() {
                    this.is_visible = !this.is_visible;
                }
            },
        });
    </script>
@endpush
