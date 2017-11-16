@extends('layouts.master')

@section('page-level-plugins.styles')
    {{Html::style('metronic/global/plugins/select2/css/select2.min.css')}}
    {{Html::style('metronic/global/plugins/select2/css/select2-bootstrap.min.css')}}
@endsection

@section('page-level-styles')
    {{Html::style('css/login.min.css')}}
    <style>
        .logo a,
        .logo a:hover,
        .logo a:active {
            text-decoration: none;
        }
        .logo a:hover {
            color: #337ab7;
        }
        .register-form, .forget-form {
            display: block !important;
        }
    </style>
@endsection

@section('page-level-plugins.scripts')
    {{Html::script('metronic/global/plugins/jquery-validation/js/jquery.validate.min.js')}}
    {{Html::script('metronic/global/plugins/jquery-validation/js/additional-methods.min.js')}}
    {{Html::script('metronic/global/plugins/select2/js/select2.full.min.js')}}
@endsection

@section('body.class')login
@endsection

@section('body')
    <div class="logo">
        <a href="{{ route('home') }}">
            <h1 class="uppercase logo-default">Call Log IT</h1>
        </a>
    </div>
    <div class="content">
        @yield('body.form')
    </div>
@endsection