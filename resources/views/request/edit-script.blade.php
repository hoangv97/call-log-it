@extends('request.create-script')

@section('extended-style')
<style>
    .tt-menu {
        top: 130% !important;
        left: -3% !important;
    }
</style>
@endsection

@section('extended-script')

    initEmployeesSearch('#search-employee')

@endsection