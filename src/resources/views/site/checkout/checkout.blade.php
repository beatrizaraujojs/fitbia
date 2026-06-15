@extends('layout.site')

@push('css')
    <link rel="stylesheet" href="{{ asset('fitbia/css/checkout.css') }}">
    
    <link rel="stylesheet" href="{{ asset('fitbia/css/pedidos.css') }}">



@endpush

@section('content')


    @include('site.checkout.pedidos')

    
    <div class="container checkout-container">

     
    @include('site.checkout.layout')


            @include('site.checkout.resumo')
       
    </div>


    
@endsection


@push('scripts')



      <!-- numero etapa -->
    <script>
        function irParaEtapa(numeroEtapa) {
            // 1. Esconde todas as seções de formulário
            document.querySelectorAll('.etapa-checkout').forEach(secao => {
                secao.classList.remove('ativo');
            });

            // 2. Mostra apenas a seção da etapa clicada
            document.getElementById(`conteudo-etapa-${numeroEtapa}`).classList.add('ativo');

            // 3. Atualiza os estilos visuais da barra de progresso (stepper)
            document.querySelectorAll('.step').forEach((passo, index) => {
                if (index + 1 <= numeroEtapa) {
                    passo.classList.add('ativo');
                } else {
                    passo.classList.remove('ativo');
                }
            });

            // 4. Se chegou na última etapa (4), libera o botão de enviar o pedido
            const btnFinalizar = document.getElementById('btn-finalizar-checkout');
            if (numeroEtapa === 4) {
                btnFinalizar.disabled = false;
                btnFinalizar.style.opacity = "1";
                btnFinalizar.style.cursor = "pointer";
            } else {
                btnFinalizar.disabled = true;
                btnFinalizar.style.opacity = "0.5";
                btnFinalizar.style.cursor = "not-allowed";
            }
            
            // Sobe a página suavemente para o topo ao mudar de etapa
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>

<!-- cep -->
<script>
    // Fica de olho no campo com id="cep"
    document.getElementById('cep').addEventListener('blur', function() {
        // Tira o traço se o cliente digitar, deixando só os números
        let cepDigitado = this.value.replace(/\D/g, '');

        // Só faz a busca se tiver exatamente 8 números
        if (cepDigitado.length === 8) {
            fetch(`https://viacep.com.br/ws/${cepDigitado}/json/`)
                .then(resposta => resposta.json())
                .then(dados => {
                    // Se o ViaCEP não retornar erro, preenche os campos do seu HTML
                    if (!dados.erro) {
                        document.getElementById('endereco_sp').value = dados.logradouro;
                        document.getElementById('bairro_cond').value = dados.bairro;
                        
                        // Opcional: Já joga o "cursor" piscando pro cliente digitar o número da casa
                        document.getElementById('numero_casa').focus();
                    } else {
                        alert("CEP não encontrado. Por favor, verifique.");
                    }
                })
                .catch(erro => console.error("Erro na busca do CEP:", erro));
        }
    });
</script>



<!-- proximo passo -->
<script>
        function irParaEtapa(numeroEtapa) {
            // 1. Esconde todas as seções de formulário
            document.querySelectorAll('.etapa-checkout').forEach(secao => {
                secao.classList.remove('ativo');
            });

            // 2. Mostra apenas a seção da etapa clicada
            document.getElementById(`conteudo-etapa-${numeroEtapa}`).classList.add('ativo');

            // 3. Atualiza os estilos visuais da barra de progresso (stepper)
            document.querySelectorAll('.step').forEach((passo, index) => {
                if (index + 1 <= numeroEtapa) {
                    passo.classList.add('ativo');
                } else {
                    passo.classList.remove('ativo');
                }
            });

            // 4. Se chegou na última etapa (4), libera o botão de enviar o pedido
            const btnFinalizar = document.getElementById('btn-finalizar-checkout');
            if (numeroEtapa === 4) {
                btnFinalizar.disabled = false;
                btnFinalizar.style.opacity = "1";
                btnFinalizar.style.cursor = "pointer";
            } else {
                btnFinalizar.disabled = true;
                btnFinalizar.style.opacity = "0.5";
                btnFinalizar.style.cursor = "not-allowed";
            }
            
            // Sobe a página suavemente para o topo ao mudar de etapa
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
@endpush