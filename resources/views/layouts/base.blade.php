@extends('layouts.app')

@section('page.container')
    <div class="page-container">
        @include('partials.sidebar')

        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="page-head">
                    <div class="page-title">
                        <h1>Request IT</h1>
                    </div>
                    <a href="{{ route('request.create') }}" class="btn red-haze btn-sm pull-right">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        <span class="uppercase">Thêm yêu cầu</span>
                    </a>
                </div>

                @include('partials.breadcrumb')

                <!-- PAGE CONTENT-->
                <div class="row">
                    <div class="col-sm-12">
                        @yield('page.content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection