@extends(backpack_view('layouts.plain'))

@section('content_lft')
    <img src="{{ asset('assets/forgot-password-v2.svg') }}" alt="login-v2.svg" class="img-fluid login-pic">
@endsection

@section('content_rgt')
    <h4 class="mb-3">
        {{ trans('backpack::base.choose_new_password') }}
    </h4>
    <span class="text-muted">
        Enter your email and we'll send you instructions to reset your password
    </span>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form class="mt-3" role="form" method="POST" action="{{ route('backpack.auth.password.reset') }}">
        {!! csrf_field() !!}

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label class="control-label" for="email">{{ trans('backpack::base.email_address') }}</label>

            <div>
                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="email" value="{{ $email ?? old('email') }}">

                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label class="control-label" for="password">{{ trans('backpack::base.new_password') }}</label>

            <div>
                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password">

                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label class="control-label" for="password_confirmation">{{ trans('backpack::base.confirm_new_password') }}</label>
            <div>
                <input type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" id="password_confirmation">

                @if ($errors->has('password_confirmation'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group mb-3">
            <div>
                <button type="submit" class="btn btn-block btn-primary">
                    {{ trans('backpack::base.change_password') }}
                </button>
            </div>
        </div>
    </form>
@endsection
