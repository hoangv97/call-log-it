@extends('layouts.master')

@section('page-level-styles')
    @parent
    {{Html::style('metronic/pages/css/error.min.css')}}
@endsection

@section('body')
    <div class="row">
        <div class="col-md-12 page-@yield('error')">
            <div class="number font-red"> @yield('error') </div>
            <div class="details">
                <h3>Oops! Something went wrong.</h3>
                <p> We are fixing it! Please come back in a while.
                    <br/> </p>
                <p>
                    <a href="{{ route('home') }}" class="btn red btn-outline"> Return home </a>
                    <br>
                </p>
            </div>
        </div>
    </div>
@endsection

