<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link rel="icon" href="favicon.png">

    <!-- Styles -->
    @section('global-mandatory-styles')
        {{Html::style('https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all')}}
        {{Html::style('metronic/global/plugins/font-awesome/css/font-awesome.min.css')}}
        {{Html::style('metronic/global/plugins/simple-line-icons/simple-line-icons.min.css')}}
        {{Html::style('metronic/global/plugins/bootstrap/css/bootstrap.min.css')}}
        {{Html::style('metronic/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}
    @show

    @yield('page-level-plugins.styles')

    @yield('theme-global-styles')
        {{Html::style('metronic/global/css/components.min.css', ['id' => 'style_components'])}}
        {{Html::style('metronic/global/css/plugins.min.css')}}

    @yield('page-level-styles')

    @yield('theme-layout-styles')

    @section('scripts-top')
        <script>
            window.Laravel = {csrfToken: '{{csrf_token()}}'};
        </script>
    @show
</head>
<body class="@yield('body.class')">

@yield('body')

<!-- Scripts -->
@section('core-plugins')
    {{Html::script('metronic/global/plugins/jquery.min.js')}}
    {{Html::script('metronic/global/plugins/bootstrap/js/bootstrap.min.js')}}
    {{Html::script('metronic/global/plugins/js.cookie.min.js')}}
    {{Html::script('metronic/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}
    {{Html::script('metronic/global/plugins/jquery.blockui.min.js')}}
    {{Html::script('metronic/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}
@show

@yield('page-level-plugins.scripts')

@section('theme-global-scripts')
    {{Html::script('metronic/global/scripts/app.min.js')}}
@show

@yield('page-level-scripts')

@yield('theme-layout-scripts')

</body>
</html>
