<div class="checkout-layout">
  <div class="checkout-formularios">

    <div class="checkout-secao etapa-checkout ativo" id="conteudo-etapa-1">
      <h3><i class="ph ph-map-pin"></i> 1. Onde vamos entregar?</h3>
      <div class="form-grid">
        <div class="input-group">
          <label for="cep">CEP</label>
          <input type="text" id="cep" placeholder="Ex: 01001-000" maxlength="9" />
        </div>
        <div class="input-group">
          <label for="endereco_sp">Endereço em São Paulo</label>
          <input type="text" id="endereco_sp" placeholder="Rua, Avenida, Alameda..." />
        </div>
        <div class="input-group">
          <label for="numero_casa">Número</label>
          <input type="text" id="numero_casa" placeholder="Número da casa ou prédio" />
        </div>
        <div class="input-group">
          <label for="bairro_cond">Bairro / Condomínio</label>
          <input type="text" id="bairro_cond" placeholder="Seu bairro ou condomínio" />
        </div>
        <div class="input-group">
          <label for="apto_ref">APTO / Referência / Complemento</label>
          <input type="text" id="apto_ref" placeholder="Apto, bloco, ponto de referência..." />
        </div>
      </div>
      <div class="botoes-etapa">
        <button class="btn-proximo" onclick="irParaEtapa(2)">
          Avançar para Entrega <i class="ph ph-arrow-right"></i>
        </button>
      </div>
    </div>

    <div class="checkout-secao etapa-checkout" id="conteudo-etapa-2">
      <h3><i class="ph ph-moped"></i> 2. Tipo de Entrega e Pagamento</h3>

      <h4 class="subtitulo-checkout">Tipo de Pedido</h4>
      <div class="radio-group-horizontal">
        <label class="radio-customizado">
          <input type="radio" name="tipo_pedido" value="delivery" checked />
          <i class="ph ph-motorcycle"></i> Delivery
        </label>
      </div>

      <h4 class="subtitulo-checkout" style="margin-top: 20px">
        Forma de Pagamento
      </h4>
      <div class="opcoes-pagamento">
        <label class="opcao-card">
          <input type="radio" name="pagamento" value="dinheiro" />
          <div class="opcao-conteudo"><span>Dinheiro</span></div>
        </label>
        <label class="opcao-card">
          <input type="radio" name="pagamento" value="pix" checked />
          <div class="opcao-conteudo">
            <span>PIX (Chave exibida após o envio)</span>
          </div>
        </label>
        <label class="opcao-card">
          <input type="radio" name="pagamento" value="debito" />
          <div class="opcao-conteudo">
            <span>Cartão de Débito - Maquininha</span>
          </div>
        </label>
        <div class="step" id="step-2">
          <label class="opcao-card">
            <input type="radio" name="pagamento" value="credito" />
            <div class="opcao-conteudo">
              <span>Cartão de Crédito - Maquininha</span>
            </div>
          </label>
        </div>

        <div class="botoes-etapa">
          <button class="btn-voltar" onclick="irParaEtapa(1)">
            <i class="ph ph-arrow-left"></i> Voltar
          </button>
          <button class="btn-proximo" onclick="irParaEtapa(3)">
            Avançar para Dados Pessoais <i class="ph ph-arrow-right"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="checkout-secao etapa-checkout" id="conteudo-etapa-3">
      <h3><i class="ph ph-user"></i> 3. Seus Dados Pessoais</h3>
      <div class="form-grid">
        <div class="input-group">
          <label for="nome_titular">Nome (apenas 1ª vez)</label>
          <input type="text" id="nome_titular" placeholder="Seu nome completo" />
        </div>
        <div class="input-group">
          <label for="whatsapp">Seu WhatsApp (somente dígitos)</label>
          <input type="tel" id="whatsapp" placeholder="Ex: 11999998888" />
        </div>
        <div class="input-group">
          <label for="aniversario">Aniversário (opcional, para brindes)</label>
          <input type="text" id="aniversario" placeholder="dd/mm" />
        </div>
      </div>
      <div class="botoes-etapa">
        <button class="btn-voltar" onclick="irParaEtapa(2)">
          <i class="ph ph-arrow-left"></i> Voltar
        </button>
        <button class="btn-proximo" onclick="irParaEtapa(4)">
          Avançar para Revisão <i class="ph ph-arrow-right"></i>
        </button>
      </div>
    </div>

    <div class="checkout-secao etapa-checkout" id="conteudo-etapa-4">
      <h3><i class="ph ph-calculator"></i> 4. Revisão Final</h3>

      <div class="input-group">
        <label for="cupom">Possui Cupom de Desconto?</label>
        <div class="cupom-container">
          <input type="text" id="cupom" placeholder="Cupom de desconto" />
          <button class="btn-cupom">Aplicar</button>
        </div>
      </div>

      <div class="input-group" style="margin-top: 20px">
        <label for="observacoes">OBSERVAÇÕES / CPF NA NOTA</label>
        <input type="text" id="observacoes" placeholder="Ex: Sem cebola, deixar na portaria..." />
      </div>

      <div class="botoes-etapa">
        <button class="btn-voltar" onclick="irParaEtapa(3)">
          <i class="ph ph-arrow-left"></i> Voltar
        </button>
      </div>
    </div>
  </div>

  <div class="checkout-resumo">
    <h3>Resumo do Pedido</h3>
    <div class="resumo-valores">
      <div class="resumo-linha">
        <span>Subtotal:</span>
        <span>R$ 56,00</span>
      </div>
      <div class="resumo-linha">
        <span>Taxa de entrega:</span>
        <span class="destaque-verde">A calcular</span>
      </div>
      <hr class="divisor" />
      <div class="resumo-linha total">
        <span>Total:</span>
        <span>R$ 56,00</span>
      </div>
    </div>

    <button class="btn-confirmar" id="btn-finalizar-checkout" disabled style="opacity: 0.5; cursor: not-allowed">
      ENVIAR PEDIDO <i class="ph ph-arrow-right"></i>
    </button>
  </div>
</div>


{{-- POP-UP DE SUCESSO INTELIGENTE (ADICIONAR/REMOVER) --}}
    @if(session('success'))
        @php
            $mensagem = session('success');
            // Verifica se a palavra "removido" está na mensagem do Controller
            $ehRemocao = str_contains(strtolower($mensagem), 'removid');
            
            // Define as cores e textos dinamicamente
            $titulo = $ehRemocao ? 'Item Removido' : 'Adicionado ao carrinho';
            $cor = $ehRemocao ? '#ef4444' : '#059669'; // Vermelho para remover, Verde para adicionar
            $icone = $ehRemocao ? 'ph-trash' : 'ph-check-circle';
        @endphp

        <div id="toast-sucesso" style="position: fixed; top: 20px; right: 20px; background: white; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); display: flex; align-items: center; gap: 15px; padding: 15px 25px; z-index: 10000; border-left: 5px solid {{ $cor }}; transform: translateX(120%); transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
            
            <i class="ph {{ $icone }}" style="color: {{ $cor }}; font-size: 28px;"></i>
            
            <div>
                <h4 style="margin: 0; color: #1f2937; font-size: 16px;">{{ $titulo }}</h4>
                <p style="margin: 2px 0 0 0; color: #6b7280; font-size: 13px;">{{ $mensagem }}</p>
            </div>
            
            <button onclick="document.getElementById('toast-sucesso').style.display='none'" style="background: none; border: none; cursor: pointer; color: #9ca3af; margin-left: 15px; font-size: 20px;">
                <i class="ph ph-x"></i>
            </button>
        </div>

        <script>
            // Faz o popup deslizar para dentro da tela logo que a página carrega
            setTimeout(() => {
                const toast = document.getElementById('toast-sucesso');
                if(toast) toast.style.transform = 'translateX(0)';
            }, 100);

            // Faz o popup ir embora sozinho depois de 4 segundos
            setTimeout(() => {
                const toast = document.getElementById('toast-sucesso');
                if(toast) toast.style.transform = 'translateX(120%)';
            }, 4000);
        </script>
    @endif

<script>
  document.getElementById("cep").addEventListener("blur", function() {
    let cepDigitado = this.value.replace(/\D/g, "");

    if (cepDigitado.length === 8) {
      fetch(`https://viacep.com.br/ws/${cepDigitado}/json/`)
        .then((resposta) => resposta.json())
        .then((dados) => {
          if (!dados.erro) {
            document.getElementById("endereco_sp").value = dados.logradouro;
            document.getElementById("bairro_cond").value = dados.bairro;
            document.getElementById("numero_casa").focus();
          } else {
            alert("CEP não encontrado. Por favor, verifique.");
          }
        })
        .catch((erro) => console.error("Erro na busca do CEP:", erro));
    }
  });
</script>

<script>
  function irParaEtapa(numeroEtapa) {
    // 1. Esconde todas as seções de formulário
    document.querySelectorAll(".etapa-checkout").forEach((secao) => {
      secao.classList.remove("ativo");
    });

    // 2. Mostra apenas a seção da etapa clicada
    document
      .getElementById(`conteudo-etapa-${numeroEtapa}`)
      .classList.add("ativo");

    // 3. Atualiza os estilos visuais da barra de progresso (stepper)
    document.querySelectorAll(".step").forEach((passo, index) => {
      if (index + 1 <= numeroEtapa) {
        passo.classList.add("ativo");
      } else {
        passo.classList.remove("ativo");
      }
    });

    // 4. Se chegou na última etapa (4), libera o botão de enviar o pedido
    const btnFinalizar = document.getElementById("btn-finalizar-checkout");
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
    window.scrollTo({
      top: 0,
      behavior: "smooth"
    });
  }
</script>