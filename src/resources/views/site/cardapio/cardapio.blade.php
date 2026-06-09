@extends('layout.site')

@section('title', 'Cardápio | FitBia')

@push('css')
    <link rel="stylesheet" href="{{ asset('fitbia/css/cardapio.css') }}">
@endpush

@section('content')
    @include('site.cardapio.pagina-header')
    @include('site.home.filtros-bar')
    @include('site.cardapio.cardapio-completo')


@push('js')
    <script>


function adicionarAoCarrinho(botao) {
    // Pega o ID escondido no botão que foi clicado
    let idProduto = botao.getAttribute('data-id');
    
    let modal = document.getElementById('modal-' + idProduto);
    let observacao = modal.querySelector('.campo-observacao textarea').value;
    
    // ⚠️ ESSA LINHA ABAIXO ESTAVA FALTANDO NO SEU CÓDIGO!
    let adicionaisEscolhidos = []; 
    
    let linhasAdicionais = modal.querySelectorAll('.linha-item');

    linhasAdicionais.forEach(linha => {
        let qtd = parseInt(linha.querySelector('.qtd').innerText);
        if (qtd > 0) {
            let idAdicional = linha.getAttribute('data-id-adicional');
            adicionaisEscolhidos.push({
                id: idAdicional,
                quantidade: qtd
            });
        }
    });


            // 4. Monta o pacote final do item
            let itemCarrinho = {
                produto_id: idProduto,
                adicionais: adicionaisEscolhidos,
                observacao: observacao
            };

            // Imprime no console do navegador para validação
            console.log("Pacote pronto para o carrinho:", itemCarrinho);
            
            // Fecha a janela do modal simulando o clique no botão fechar
            let btnFechar = modal.querySelector('.btn-fechar');
            idProduto = btnFechar.getAttribute('data-id'); 
            document.getElementById('modal-' + idProduto).style.display = 'none';
        }
    </script>
@endpush

@endsection