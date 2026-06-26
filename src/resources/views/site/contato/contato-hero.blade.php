{{-- ======================================================== --}}
{{-- CSS PARA LIMPAR O AZUL AUTOMÁTICO DO NAVEGADOR            --}}
{{-- ======================================================== --}}
<style>
    /* Remove o azul automático que celulares/servidores colocam em números de telefone */
    .dado-item-card p, 
    .dado-item-card strong,
    .dados-card a {
        color: #374151 !important; /* Cor cinza escuro normal do seu layout */
        text-decoration: none !important;
    }

    /* Caso queira colocar um efeito de hover no botão do Zap */
    .btn-clean-zap {
        transition: all 0.3s ease;
    }
    .btn-clean-zap:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
</style>

{{-- ======================================================== --}}
{{-- ESTRUTURA HTML DA SEÇÃO DE CONTATO                        --}}
{{-- ======================================================== --}}
<section class="contato-hero" id="fale-conosco">
    <div class="container contato-wrapper">
        
        <div class="contato-card">
            
            <div class="card-info">
                <span class="subtitulo-card">Mande um Zap</span>
                <h1 class="titulo-card">Fale com a <br>nossa cozinha</h1>
                <p class="desc-card">
                    Tem dúvidas sobre o cardápio, quer fazer uma encomenda especial ou propor uma parceria? Estamos prontos para te atender.
                </p>

                <div class="dados-card">
                    <div class="dado-item-card">
                        <i class="ph ph-whatsapp-logo"></i>
                        <div>
                            <strong>WhatsApp</strong>
                            <p>(11) 95426-6504</p>
                        </div>
                    </div>
                    <div class="dado-item-card">
                        <i class="ph ph-map-pin"></i>
                        <div>
                            <strong>Nossa Casinha</strong>
                            <p>Vila Jacuí, São Paulo - SP</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-form">
                <form id="form-zap" class="form-clean" onsubmit="event.preventDefault(); enviarParaWhatsApp();">
                    <div class="form-group-clean">
                        <label for="zap-nome">Seu nome</label>
                        <input type="text" id="zap-nome" placeholder="Como gosta de ser chamado?" required>
                    </div>
                    
                    <div class="form-group-clean">
                        <label for="zap-assunto">Assunto</label>
                        <input type="text" id="zap-assunto" placeholder="Sobre o que vamos falar?" required>
                    </div>
                    
                    <div class="form-group-clean">
                        <label for="zap-mensagem">Sua mensagem</label>
                        <textarea id="zap-mensagem" rows="3" placeholder="Digite os detalhes aqui..." required></textarea>
                    </div>
                    
                    {{-- Mudei para submit para respeitar a validação nativa do HTML --}}
                    <button type="submit" class="btn-clean-zap">
                        Enviar para o WhatsApp <i class="ph ph-paper-plane-right"></i>
                    </button>
                </form>
            </div>

        </div> 
    </div>
</section>

{{-- ======================================================== --}}
{{-- LÓGICA JAVASCRIPT: REDIRECIONAMENTO COM TEXTO PRONTO     --}}
{{-- ======================================================== --}}
<script>
    function enviarParaWhatsApp() {
        // 1. Pega os dados digitados pelo usuário
        const nome = document.getElementById('zap-nome').value.trim();
        const assunto = document.getElementById('zap-assunto').value.trim();
        const mensagem = document.getElementById('zap-mensagem').value.trim();

        // Validação extra caso os campos estejam vazios
        if (!nome || !assunto || !mensagem) {
            alert('Por favor, preencha todos os campos antes de enviar.');
            return;
        }

        // 2. Configurações de envio (Número da cozinha Fit Bia)
        const telefoneLoja = '5511954266504'; 

        // 3. Monta o texto com a introdução sobre o tema da seção
        let texto = "Olá Fit Bia! *Desejo falar com vocês* sobre a cozinha funcional.\n\n";
        texto += "*Meu Nome:* " + nome + "\n";
        texto += "*Assunto:* " + assunto + "\n";
        texto += "*Mensagem:* " + mensagem;

        // 4. Codifica o texto para formato de URL e abre o WhatsApp
        const urlFinal = "https://api.whatsapp.com/send?phone=" + telefoneLoja + "&text=" + encodeURIComponent(texto);
        
        window.open(urlFinal, '_blank');
    }
</script>