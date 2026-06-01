
    <section class="contato-hero">
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
                <form id="form-zap" class="form-clean">
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
                    
                    <button type="button" onclick="enviarParaWhatsApp()" class="btn-clean-zap">
                        Enviar para o WhatsApp <i class="ph ph-paper-plane-right"></i>
                    </button>
                </form>
            </div>

        </div> </div>
</section>
