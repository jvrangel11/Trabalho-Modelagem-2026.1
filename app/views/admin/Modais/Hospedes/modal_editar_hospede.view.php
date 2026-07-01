<link rel="stylesheet" href="/public/css/modal_editar_hospede.css">
<link rel="stylesheet" href="/public/css/index.css">
<link rel="stylesheet" href="/public/js/hospedes.js">
 
<div class="editar-hospede-container" id="editModal" display="none">
    <div class="modal-editar-hospede">
        <h2>Editar Hóspede</h2>

        <form action="/admin/hospedes" method="POST">

            <input type="hidden" name="id" id="editId">

            <div class="editar-hospede-input-container">
                <div class="editar-hospede-input">
                    <label>Nome</label>
                    <input type="text" name="nome" id="editNome" required>
                </div>

                <div class="editar-hospede-input">
                    <label>CPF</label>
                    <input type="text" name="cpf" id="editCpf" required>
                </div>

                <div class="editar-hospede-input">
                    <label>Email</label>
                    <input type="email" name="email" id="editEmail" required>
                </div>

                <div class="editar-hospede-input">
                    <label>Telefone</label>
                    <input type="text" name="telefone" id="editTelefone" required>
                </div>
            </div>

            <div class="editar-hospede-btn-container">
                <button type="button" onclick="closeModal('editModal')" class="btn-cancelar-editar-hospede">Cancelar</button>
                <button type="submit" class="btn-salvar-editar-hospede">Salvar</button>
            </div>

        </form>
    </div>
</div>
