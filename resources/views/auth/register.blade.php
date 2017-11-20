@extends('auth.base')

@section('page-level-styles')
    @parent
    {{Html::style('metronic/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}
    <style>
        .fileinput {
            margin-bottom: 0 !important;
        }
        .fileinput-new {
            padding-right: 12px;
        }
    </style>
@endsection

@section('page-level-scripts')
    @parent
    {{Html::script('metronic/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}
@endsection

@section('body.form')
    {!! Form::open(['route' => 'register', 'class' => 'register-form', 'files' => true]) !!}
        <h3 class="font-green">Đăng ký</h3>
        <p class="hint"> Nhập thông tin cá nhân: </p>
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="control-label visible-ie8 visible-ie9">Tên</label>
            <input id="name" value="{{ old('name') }}" required autofocus class="form-control placeholder-no-fix" type="text" placeholder="Tên" name="name" />
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9" for="team">Nhóm</label>
            <select name="team" class="form-control">óm
                <option value="">Nhóm</option>
                <option value="1">IT Hanoi</option>
                <option value="2">IT Danang</option>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9" for="role">Vai trò</label>
            <select name="role" class="form-control">
                <option value="">Vai trò</option>
                <option value="1">Member</option>
                <option value="2">Sub-lead</option>
                <option value="3">Leader</option>
            </select>
        </div>

        <p class="hint"> Tải ảnh đại diện: </p>
        <div class="form-group">
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="input-group input-large">
                    <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                        <span class="fileinput-filename"> </span>
                    </div>
                    <span class="input-group-addon btn default btn-file">
                        <span class="fileinput-new"> Chọn file </span>
                        <span class="fileinput-exists"> Đổi </span>
                        <input type="file" name="image">
                    </span>
                    <a href="javascript:" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Xóa </a>
                </div>
            </div>
            @if ($errors->has('image'))
                <span class="help-block">
                        <strong>{{ $errors->first('image') }}</strong>
                    </span>
            @endif
        </div>

        <p class="hint"> Nhập thông tin tài khoản: </p>
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
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="control-label visible-ie8 visible-ie9">Password</label>
            <input class="form-control placeholder-no-fix" required type="password" id="password" placeholder="Mật khẩu" name="password" />
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="password-confirm" class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
            <input class="form-control placeholder-no-fix" required id="password-confirm" type="password" placeholder="Nhập lại mật khẩu" name="password_confirmation" />
        </div>
        <div class="form-actions">
            <a href="{{ route('login') }}" id="register-back-btn" class="btn green btn-outline">Đăng nhập</a>
            <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">Đăng ký</button>
        </div>
    {!! Form::close() !!}
@endsection