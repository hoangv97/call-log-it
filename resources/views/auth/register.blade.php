@extends('auth.base')

@section('body.form')
    <form class="register-form" action="{{ route('register') }}" method="post">
        {{ csrf_field() }}
        <h3 class="font-green">Sign Up</h3>
        <p class="hint"> Enter your personal details below: </p>
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="control-label visible-ie8 visible-ie9">Full Name</label>
            <input id="name" value="{{ old('name') }}" required autofocus class="form-control placeholder-no-fix" type="text" placeholder="Name" name="name" />
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <input id="email" value="{{ old('email') }}" required class="form-control placeholder-no-fix" type="email" placeholder="Email" name="email" />
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9" for="team">Team</label>
            <select name="team" class="form-control">
                <option value="1">IT Hanoi</option>
                <option value="2">IT Danang</option>
                <option value="0">Other</option>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9" for="role">Role</label>
            <select name="role" class="form-control">
                <option value="0">Member</option>
                <option value="1">Sub-lead</option>
                <option value="2">Leader</option>
            </select>
        </div>

        <p class="hint"> Enter your account details below: </p>
        <div class="form-group">
            <label for="username" class="control-label visible-ie8 visible-ie9">Username</label>
            <input id="username" class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" />
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="control-label visible-ie8 visible-ie9">Password</label>
            <input class="form-control placeholder-no-fix" required type="password" id="password" placeholder="Password" name="password" />
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="password-confirm" class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
            <input class="form-control placeholder-no-fix" id="rpassword" type="password" placeholder="Re-type Your Password" name="rpassword" />
        </div>
        <div class="form-group margin-top-20 margin-bottom-20">
            <label class="mt-checkbox mt-checkbox-outline">
                <input type="checkbox" name="tnc" /> I agree to the
                <a href="javascript:">Terms of Service </a> &
                <a href="javascript:">Privacy Policy </a>
                <span></span>
            </label>
            <div id="register_tnc_error"></div>
        </div>
        <div class="form-actions">
            <a href="{{ route('login') }}" id="register-back-btn" class="btn green btn-outline">Back</a>
            <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">Submit</button>
        </div>
    </form>
@endsection