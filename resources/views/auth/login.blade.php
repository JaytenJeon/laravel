@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md">
                                    <input id="login_id" type="text" placeholder="아이디" class="form-control{{ $errors->has('login_id') ? ' is-invalid' : '' }}" name="login_id" value="{{ old('login_id') }}" required autofocus>

                                @if ($errors->has('login_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('login_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-md">
                                <input id="password" type="password" placeholder={{__("Password")}} class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md" >
                                <button type="submit" class="btn btn-primary col-md">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>

                            @if (Route::has('password.request'))
                                <a class="col-md text-md-right" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
