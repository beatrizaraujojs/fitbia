
    <div id="modalEditarProduto" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 1000; overflow-y: auto;">
    <div class="admin-card" style="margin: 5% auto; width: 90%; max-width: 600px; position: relative;">
        
        <button type="button" onclick="document.getElementById('modalEditarProduto').style.display='none'" style="position: absolute; top: 15px; right: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: #4b5563;">
            <i class="ph ph-x"></i>
        </button>

        <h2 class="card-title">Editar Produto</h2>

        <form id="formEditarProduto" action="" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            @method('PUT') 

            <div class="form-group">
                <label for="edit_nome_produto">Nome do Produto*</label>
                <input type="text" name="nome_produto" id="edit_nome_produto" required>
            </div>

            <div class="form-group">
                <label for="edit_preco_base_produto">Preço Base*</label>
                <input type="number" step="0.01" name="preco_base_produto" id="edit_preco_base_produto" required>
            </div>

            <div class="form-group">
                <label for="edit_descricao_produto">Descrição do Produto</label>
                <input type="text" name="descricao_produto" id="edit_descricao_produto">
            </div>

            <div class="form-group">
                <label for="foto_produto">Nova Foto do Produto (Deixe vazio para manter a atual)</label>
                <input type="file" name="foto_produto" accept="image/*">
            </div>

            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="button" onclick="document.getElementById('modalEditarProduto').style.display='none'" class="admin-filtro-btn" style="flex: 1; text-align: center;">Cancelar</button>
                <button type="submit" class="btn-salvar" style="flex: 2;">Guardar Alterações</button>
            </div>
        </form>
    </div>
</div>