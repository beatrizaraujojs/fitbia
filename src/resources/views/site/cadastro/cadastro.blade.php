@extends('layout.site')

@push('css')
    <link rel="stylesheet" href="{{ asset('fitbia/css/cadastro.css') }}">
@endpush

@section('content')
@include('site.cadastro.cadastro-box')

@endsection