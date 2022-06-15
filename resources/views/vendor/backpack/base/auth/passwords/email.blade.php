@extends(backpack_view('layouts.plain'))

@section('content_lft')
    <img src="{{ asset('assets/forgot-password-v2.svg') }}" alt="login-v2.svg" class="img-fluid login-pic">
@endsection

@section('content_rgt')
    <h4 class="mb-3">
        {{ trans('backpack::base.confirm_email') }}
    </h4>
    <span class="text-muted">
        Enter your email and we'll send you instructions to reset your password
    </span>
    @if (session('status'))
        <div class="alert alert-success mt-3">
            {{ session('status') }}
        </div>
    @else
        <form class="mt-3" role="form" method="POST" action="{{ route('backpack.auth.password.email') }}">
            {!! csrf_field() !!}

            <div class="form-group">
                <label class="control-label" for="email">{{ trans('backpack::base.email_address') }}</label>

                <div>
                    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="email" value="{{ old('email') }}">

                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group mb-3">
                <div>
                    <button type="submit" class="btn btn-block btn-primary">
                        {{ trans('backpack::base.send_reset_link') }}
                    </button>
                </div>
            </div>
        </form>
    @endif
    <div class="text-center mt-2">
        <a href="{{ route('backpack.auth.login') }}">
            <i class="las la-angle-left"></i>
            Back to login
        </a>
    </div>
@endsection
