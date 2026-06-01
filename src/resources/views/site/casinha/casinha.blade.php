@extends('layout.site')

@push('css')
    <link rel="stylesheet" href="{{ asset('fitbia/css/casinha.css') }}">
@endpush

@section('content')

@include('site.casinha.proposito-casinha')

@include('site.casinha.local-casinha')

@include('site.casinha.mapa-luxury')


    
@endsection

@push('scripts')
    <script>
        // Esse script vai ser empurrado lá pro final do app.blade.php
        console.log('Script da Home carregado com sucesso!');
    </script>
@endpush