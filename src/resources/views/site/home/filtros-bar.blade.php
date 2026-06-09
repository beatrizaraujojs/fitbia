<div class="filtros-bar">
    <div class="container filtros-container">
        
        <a href="{{ route('site.cardapio') }}" class="filtro-btn ativo" data-id="todos">
            Todos
        </a>

        @foreach($categorias as $categoria)
            <a href="{{ route('site.cardapio') }}?cat={{ $categoria->id_categoria }}" class="filtro-btn" data-id="{{ $categoria->id_categoria }}">
                {{ $categoria->nome_categoria }}
            </a>
        @endforeach

    </div>
</div>