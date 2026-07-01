<div class="novo-usuario-overlay" id="modal_novo_usuario">
    <div class="modal-novo-usuario">
        <h2>Cadastrar Novo Usuário</h2>
        
        <form action="/admin/equipe/create" method="POST">
            <div class="novo-usuario-input-container">
                
                <div class="novo-usuario-input">
                    <label>Nome Completo<span class="required">*</span></label>
                    <input type="text" name="nome" placeholder="Digite o nome completo" required>
                </div>

                <div class="novo-usuario-input">
                    <label>Email<span class="required">*</span></label>
                    <input type="email" name="email" placeholder="exemplo@email.com" required>
                </div>

                <div class="novo-usuario-input">
                    <label>Usuário (Login)<span class="required">*</span></label>
                    <input type="text" name="login" placeholder="Nome de usuário" required>
                </div>

                <div class="novo-usuario-input">
                    <label>Senha<span class="required">*</span></label>
                    <div class="input-senha-wrapper">
                        <input type="password" name="senha" id="senha_novo_usuario" required>
                        <i class="fa-solid fa-eye-slash" onclick="toggleSenha('senha_novo_usuario', this)"></i>
                    </div>
                </div>

                <div class="novo-usuario-input">
                    <label>Cargo<span class="required">*</span></label>
                    <select name="cargo" required>
                        <option value="" disabled selected>Selecione um cargo</option>
                        <option value="Recepcionista">Recepcionista</option>
                        <option value="Gerente">Gerente</option>
                    </select>
                </div>

            </div>

            <div class="novo-usuario-btn-container">
                <button type="button" class="btn-cancelar-novo-usuario" onclick="fecharModalNovoUsuario('modal_novo_usuario')">
                    Cancelar
                </button>
                <button type="submit" class="btn-salvar-novo-usuario">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>