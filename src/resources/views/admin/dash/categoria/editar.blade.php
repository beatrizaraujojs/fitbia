<div class="admin-modal-overlay" id="modal-editar">
        <div class="admin-modal-box">
            
            <div class="admin-modal-header">
                <h2>Editar Categoria</h2>
                <button class="fechar-modal" id="btn-fechar-editar">&times;</button>
            </div>

            <form action="#" method="POST" class="admin-form" id="form-editar">
                @csrf
                @method('PUT') <div class="form-group">
                    <label for="edit_nome_categoria">Nome da Categoria *</label>
                    <input type="text" id="edit_nome_categoria" name="nome_categoria" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_ordem">Ordem de Exibição</label>
                        <input type="number" id="edit_ordem" name="ordem_exibicao_categoria">
                    </div>

                    <div class="form-group">
                        <label for="edit_status">Status</label>
                        <select id="edit_status" name="ativa_categoria">
                            <option value="ATIVO">Ativo</option>
                            <option value="INATIVO">Inativo</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-salvar">Atualizar Categoria</button>
            </form>

        </div>
    </div>