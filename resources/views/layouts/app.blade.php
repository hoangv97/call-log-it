@extends('layouts.master')

@section('page-level-plugins.styles')
    {{Html::style('metronic/global/plugins/morris/morris.css')}}
@endsection

@section('theme-layout-styles')
    {{Html::style('metronic/layouts/layout4/css/layout.min.css')}}
    {{Html::style('metronic/layouts/layout4/css/themes/default.min.css', ['id' => 'style_color'])}}
@endsection

@section('body.class')page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo
@endsection

@section('body')
    @include('partials.header')

    @yield('content')

    @include('partials.footer')
@endsection

@section('page-level-plugins.scripts')
    {{Html::script('metronic/global/plugins/morris/morris.min.js')}}
    {{Html::script('metronic/global/plugins/morris/raphael-min.js')}}

    @include('extends.read-tickets-menu')
@endsection

@section('theme-layout-scripts')
    {{Html::script('metronic/layouts/layout4/scripts/layout.min.js')}}
    {{Html::script('metronic/layouts/layout4/scripts/demo.min.js')}}
    {{Html::script('metronic/layouts/global/scripts/quick-sidebar.min.js')}}
    {{Html::script('metronic/layouts/global/scripts/quick-nav.min.js')}}
@endsection
