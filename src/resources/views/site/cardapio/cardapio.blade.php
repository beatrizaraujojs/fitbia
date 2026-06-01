@extends('layout.site')

@push('css')
    <link rel="stylesheet" href="{{ asset('fitbia/css/cardapio.css') }}">
@endpush

@section('content')
@include('site.cardapio.pagina-header')
@include('site.home.filtros-bar')
@include('site.cardapio.cardapio-completo')
  
@endsection