@extends('layout.site')

@push('css')
    <link rel="stylesheet" href="{{ asset('fitbia/css/style.css') }}">
@endpush

@section('content')

@include('site.home.filtros-bar')


@include('site.home.hero')

@include('site.home.cardapio-produtos')


@include('site.home.diferenciais-premium')

@include('site.home.como-funciona-v2')

@include('site.home.nossa-casinha')


@include('site.home.depoimentos')

    
@endsection

@push('scripts')
    <!-- <script>
        // Esse script vai ser empurrado lá pro final do app.blade.php
        console.log('Script da Home carregado com sucesso!');
    </script> -->
@endpush


