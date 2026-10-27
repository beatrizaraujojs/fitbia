{{-- === MODAL DE EDITAR CUPOM PAINEL ADMIN === --}}
<div class="admin-modal-overlay" id="modal-editar-cupom" style="display: none;">
    <div class="admin-modal-box">

        <div class="admin-modal-header">
            <h2>Editar Cupom</h2>
            <button type="button" class="fechar-modal" id="btn-fechar-editar-cupom">&times;</button>
        </div>

        <form action="#" method="POST" class="admin-form" id="form-editar-cupom">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="edit_codigo_cupom">Código do Cupom *</label>
                <input type="text" id="edit_codigo_cupom" name="codigo_cupom" style="text-transform: uppercase;" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="edit_porcentagem_desconto">Desconto (%) *</label>
                    <input type="number" step="0.01" min="0.01" max="100" id="edit_porcentagem_desconto" name="porcentagem_desconto" required>
                </div>

                <div class="form-group">
                    <label for="edit_status_cupom">Status</label>
                    <select id="edit_status_cupom" name="status_cupom">
                        <option value="ATIVO">Ativo</option>
                        <option value="INATIVO">Inativo</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-salvar">Atualizar Cupom</button>
        </form>

    </div>
</div>