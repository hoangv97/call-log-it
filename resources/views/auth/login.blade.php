@extends('auth.base')

@section('body.form')
    <form class="login-form" action="{{ route('login') }}" method="post">
        <h3 class="form-title font-green">Đăng nhập</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> Nhập email và mật khẩu của bạn.</span>
        </div>
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9" for="email">E-Mail Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="form-control form-control-solid placeholder-no-fix" placeholder="Email" />
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="control-label visible-ie8 visible-ie9" for="password">Password</label>
            <input type="password" id="password" required placeholder="Mật khẩu" name="password" class="form-control form-control-solid placeholder-no-fix" />
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-actions">
            <button type="submit" class="btn green uppercase">Đăng nhập</button>
            <label class="rememberme check mt-checkbox mt-checkbox-outline">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} />Nhớ phiên đăng nhập
                <span></span>
            </label>
        </div>
        <div class="login-options">
            <h4>Hoặc đăng nhập bằng</h4>
            <ul class="social-icons">
                <li>
                    <a class="social-icon-color facebook" data-original-title="facebook" href="javascript:"></a>
                </li>
                <li>
                    <a class="social-icon-color twitter" data-original-title="Twitter" href="javascript:"></a>
                </li>
                <li>
                    <a class="social-icon-color googleplus" data-original-title="Goole Plus" href="javascript:"></a>
                </li>
                <li>
                    <a class="social-icon-color linkedin" data-original-title="Linkedin" href="javascript:"></a>
                </li>
            </ul>
        </div>
        <div class="create-account">
            <p>
                <a href="{{ route('register') }}" id="register-btn" class="uppercase">Tạo tài khoản</a>
            </p>
        </div>
    </form>
@endsection