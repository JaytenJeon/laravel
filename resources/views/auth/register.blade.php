@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="id" class="col-md-4 col-form-label">{{ __('아이디') }}</label>

                            <div class="col-md">
                                <input id="login_id" placeholder="아이디를 입력 해주세요." type="text" class="form-control{{ $errors->has('login_id') ? ' is-invalid' : '' }}" name="login_id" value="{{ old('login_id') }}" required autofocus>

                                @if ($errors->has('login_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('login_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nickname" class="col-md col-form-label">{{ '닉네임' }}</label>

                            <div class="row col-md pr-0 mb-2">
                                <div class="col-md-8 pr-0">
                                    <input id="fixed_nickname" type="text" placeholder="닉네임을 입력 해주세요." class="form-control{{ $errors->has('fixed_nickname') ? ' is-invalid' : '' }}" name="fixed_nickname" value="{{ old('fixed_nickname') }}" required >

                                    @if ($errors->has('fixed_nickname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fixed_nickname') }}</strong>
                                        </span>
                                    @endif

                                </div>

                                <div class="input-group col-md-4 pr-0">

                                    <select class="custom-select bg-light" id="inputGroupSelect01">
                                        <option selected value="1">고정닉</option>
                                        <option value="2">비고정닉</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md">
                                <span class="col-md badge badge-light pt-2 pb-2">고정닉은 중복이 불가능하며, 비고정닉은 중복이 가능합니다</span>

                            </div>

                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 col-form-label">{{ __('E-Mail Address') }}</label>

                            <div class="col-md">
                                <input id="email" type="email" placeholder="example@example.com" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 col-form-label">{{ __('Password') }}</label>

                            <div class="col-md">
                                <input id="password" type="password" placeholder="비밀번호를 입력 해주세요." class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 col-form-label">{{ __('Confirm Password') }}</label>

                            <div class="col-md">
                                <input id="password-confirm" type="password" placeholder="비밀번호를 한번 더 입력해주세요." class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group  mb-0">
                            <div class="col-md">
                                <button type="submit" class="col-md btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
