<link rel="stylesheet" href="/public/css/modal_novo_hospede.css">
<link rel="stylesheet" href="/public/css/index.css">

<div id="guestModal" class="novo-hospede-container" style="display: none;">
    
    <div class="modal-novo-hospede">
        <h2 id="modalTitle">Novo Hóspede</h2>
        
        <form action="/admin/hospedes" method="POST" id="guestForm">
            
            <input type="hidden" id="guestId" name="id" value="">
            
            <div class="novo-hospede-input-container">
                <div class="novo-hospede-input">
                    <label>Nome Completo<span class="required">*</span></label>
                    <input type="text" name="nome" id="nome" required>
                </div>

                <div class="novo-hospede-input">
                    <label>CPF<span class="required">*</span></label>
                    <input type="text" name="cpf" id="cpf" required>
                </div>

                <div class="novo-hospede-input">
                    <label>Email<span class="required">*</span></label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="novo-hospede-input">
                    <label>Telefone<span class="required">*</span></label>
                    <input type="text" name="telefone" id="telefone" required>
                </div>
            </div>

            <div class="novo-hospede-btn-container">
                <button type="button" class="btn-cancelar-novo-hospede" onclick="closeModal('guestModal')">Cancelar</button>
                
                <button type="submit" class="btn-salvar-novo-hospede">Salvar</button>
            </div>
        </form>
    </div>
    
    </div>