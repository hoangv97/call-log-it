<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    @section('global-mandatory-styles')
        {{Html::style('https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all')}}
        {{Html::style('metronic/global/plugins/font-awesome/css/font-awesome.min.css')}}
        {{Html::style('metronic/global/plugins/simple-line-icons/simple-line-icons.min.css')}}
        {{Html::style('metronic/global/plugins/bootstrap/css/bootstrap.min.css')}}
        {{Html::style('metronic/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}
    @show

    @section('page-level-plugins.styles')
        {{Html::style('metronic/global/plugins/morris/morris.css')}}
    @show

    @section('theme-global-styles')
        {{Html::style('metronic/global/css/components.min.css', ['id' => 'style_components'])}}
        {{Html::style('metronic/global/css/plugins.min.css')}}
    @show

    @yield('page-level-styles')

    @section('theme-layout-styles')
        {{Html::style('metronic/layouts/layout4/css/layout.min.css')}}
        {{Html::style('metronic/layouts/layout4/css/themes/default.min.css', ['id' => 'style_color'])}}
    @show
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">

    @include('partials.header')

    @yield('page.container')

    @include('partials.footer')

    <!-- Scripts -->
    @section('core-plugins')
        {{Html::script('metronic/global/plugins/jquery.min.js')}}
        {{Html::script('metronic/global/plugins/bootstrap/js/bootstrap.min.js')}}
        {{Html::script('metronic/global/plugins/js.cookie.min.js')}}
        {{Html::script('metronic/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}
        {{Html::script('metronic/global/plugins/jquery.blockui.min.js')}}
        {{Html::script('metronic/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}
    @show

    @section('page-level-plugins.scripts')
        {{Html::script('metronic/global/plugins/morris/morris.min.js')}}
        {{Html::script('metronic/global/plugins/morris/raphael-min.js')}}
    @show

    @section('theme-global-scripts')
        {{Html::script('metronic/global/scripts/app.min.js')}}
    @show

    @section('page-level-scripts')
        {{Html::script('metronic/pages/scripts/dashboard.min.js')}}
    @show

    @section('theme-layout-scripts')
        {{Html::script('metronic/layouts/layout4/scripts/layout.min.js')}}
        {{Html::script('metronic/layouts/layout4/scripts/demo.min.js')}}
        {{Html::script('metronic/layouts/global/scripts/quick-sidebar.min.js')}}
        {{Html::script('metronic/layouts/global/scripts/quick-nav.min.js')}}
    @show
</body>
</html>
