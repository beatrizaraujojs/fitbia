@extends('layout.site')

@push('css')
    <link rel="stylesheet" href="{{ asset('fitbia/css/contato.css') }}">
@endpush

@section('content')

@include('site.contato.contato-hero')

@include('site.contato.faq-section')

    
@endsection

@push('scripts')
    <script>
        // Esse script vai ser empurrado lá pro final do app.blade.php
        console.log('Script da Home carregado com sucesso!');
    </script>
@endpush

