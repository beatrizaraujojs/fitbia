<div class="checkout-formularios">
                
    <div class="checkout-secao etapa-checkout ativo" id="conteudo-etapa-1">
        <h3><i class="ph ph-map-pin"></i> 1. Onde vamos entregar?</h3>
        <div class="form-grid">
            <div class="input-group">
                <label for="cep">CEP</label>
                <input type="text" id="cep" placeholder="Ex: 01001-000" maxlength="9">
            </div>
            <div class="input-group">
                <label for="endereco_sp">Endereço em São Paulo</label>
                <input type="text" id="endereco_sp" placeholder="Rua, Avenida, Alameda...">
            </div>
            <div class="input-group">
                <label for="numero_casa">Número</label>
                <input type="text" id="numero_casa" placeholder="Número da casa ou prédio">
            </div>
            <div class="input-group">
                <label for="bairro_cond">Bairro / Condomínio</label>
                <input type="text" id="bairro_cond" placeholder="Seu bairro ou condomínio">
            </div>
            <div class="input-group">
                <label for="apto_ref">APTO / Referência / Complemento</label>
                <input type="text" id="apto_ref" placeholder="Apto, bloco, ponto de referência...">
            </div>
        </div>
        <div class="botoes-etapa">
            <button class="btn-proximo" onclick="irParaEtapa(2)">Avançar para Entrega <i class="ph ph-arrow-right"></i></button>
        </div>
    </div>

    <div class="checkout-secao etapa-checkout" id="conteudo-etapa-2">
        <h3><i class="ph ph-moped"></i> 2. Tipo de Entrega e Pagamento</h3>
        
        <h4 class="subtitulo-checkout">Tipo de Pedido</h4>
        <div class="radio-group-horizontal">
            <label class="radio-customizado">
                <input type="radio" name="tipo_pedido" value="delivery" checked>
                <i class="ph ph-motorcycle"></i> Delivery
            </label>
        </div>

        <h4 class="subtitulo-checkout" style="margin-top: 20px;">Forma de Pagamento</h4>
        <div class="opcoes-pagamento">
            <label class="opcao-card">
                <input type="radio" name="pagamento" value="dinheiro">
                <div class="opcao-conteudo"><span>Dinheiro</span></div>
            </label>
            <label class="opcao-card">
                <input type="radio" name="pagamento" value="pix" checked>
                <div class="opcao-conteudo"><span>PIX (Chave exibida após o envio)</span></div>
            </label>
            <label class="opcao-card">
                <input type="radio" name="pagamento" value="debito">
                <div class="opcao-conteudo"><span>Cartão de Débito - Maquininha</span></div>
            </label>
            <label class="opcao-card">
                <input type="radio" name="pagamento" value="credito">
                <div class="opcao-conteudo"><span>Cartão de Crédito - Maquininha</span></div>
            </label>
        </div>
        <div class="botoes-etapa">
            <button class="btn-voltar" onclick="irParaEtapa(1)"><i class="ph ph-arrow-left"></i> Voltar</button>
            <button class="btn-proximo" onclick="irParaEtapa(3)">Avançar para Dados Pessoais <i class="ph ph-arrow-right"></i></button>
        </div>
    </div>

    <div class="checkout-secao etapa-checkout" id="conteudo-etapa-3">
        <h3><i class="ph ph-user"></i> 3. Seus Dados Pessoais</h3>
        <div class="form-grid">
            <div class="input-group">
                <label for="nome_titular">Nome (apenas 1ª vez)</label>
                <input type="text" id="nome_titular" placeholder="Seu nome completo">
            </div>
            <div class="input-group">
                <label for="whatsapp">Seu WhatsApp (somente dígitos)</label>
                <input type="tel" id="whatsapp" placeholder="Ex: 11999998888">
            </div>
            <div class="input-group">
                <label for="aniversario">Aniversário (opcional, para brindes)</label>
                <input type="text" id="aniversario" placeholder="dd/mm">
            </div>
        </div>
        <div class="botoes-etapa">
            <button class="btn-voltar" onclick="irParaEtapa(2)"><i class="ph ph-arrow-left"></i> Voltar</button>
            <button class="btn-proximo" onclick="irParaEtapa(4)">Avançar para Revisão <i class="ph ph-arrow-right"></i></button>
        </div>
    </div>

    <div class="checkout-secao etapa-checkout" id="conteudo-etapa-4">
        <h3><i class="ph ph-calculator"></i> 4. Revisão Final</h3>
        
        <div class="input-group">
            <label for="cupom">Possui Cupom de Desconto?</label>
            <div class="cupom-container">
                <input type="text" id="cupom" placeholder="Cupom de desconto">
                <button class="btn-cupom">Aplicar</button>
            </div>
        </div>
        <div class="input-group" style="margin-top: 20px;">
            <label for="observacoes">OBSERVAÇÕES / CPF NA NOTA</label>
            <input type="text" id="observacoes" placeholder="Ex: Sem cebola, deixar na portaria...">
        </div>
        <div class="botoes-etapa">
            <button class="btn-voltar" onclick="irParaEtapa(3)"><i class="ph ph-arrow-left"></i> Voltar</button>
        </div>
    </div>

</div>