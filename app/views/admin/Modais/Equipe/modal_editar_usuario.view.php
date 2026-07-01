<link rel="stylesheet" href="/public/css/modal_editar_usuario.css">
<link rel="stylesheet" href="/public/css/index.css">
<div class="editar-usuario-overlay" id="modal_editar_usuario_<?= $funcionario->id ?>">
    <div class="modal-editar-usuario">
        <h2>Editar Usuário</h2>

        <form action="/admin/equipe/edit" method="POST">
            <input type="hidden" name="id_funcionario" value="<?= $funcionario->id ?>">
            <input type="hidden" name="id_usuario" value="<?= $funcionario->id_usuario ?>">

            <div class="editar-usuario-input-container">
                <div class="editar-usuario-input">
                    <label>Nome Completo</label>
                    <input type="text" name="nome" value="<?= htmlspecialchars($funcionario->nome) ?>" required>
                </div>

                <div class="editar-usuario-input">
                    <label>Usuário</label>
                    <input type="text" name="login" value="<?php 
                        foreach ($usuarios as $u) { 
                            if ($u->id == $funcionario->id_usuario) { echo htmlspecialchars($u->login); break; } 
                        } ?>" required>
                </div>
                
                <div class="editar-usuario-input">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($funcionario->email) ?>" required>
                </div>

                <div class="editar-usuario-input">
                    <label>Senha (deixe em branco para não alterar)</label>
                    <div class="input-senha-wrapper">
                        <input 
                            type="password" 
                            name="senha" 
                            id="senha_<?= $funcionario->id ?>" 
                            placeholder="Nova senha se desejar alterar"
                            value="" 
                        >
                        <i class="fa-solid fa-eye-slash" onclick="toggleSenha('senha_<?= $funcionario->id ?>', this)"></i>
                    </div>
                </div>

                <div class="editar-usuario-input">
                    <label>Cargo</label>
                    <select name="cargo" required>
                        <option value="Recepcionista" <?= $funcionario->cargo === 'Recepcionista' ? 'selected' : '' ?>>Recepcionista</option>
                        <option value="Gerente" <?= $funcionario->cargo === 'Gerente' ? 'selected' : '' ?>>Gerente</option>
                    </select>
                </div>
            </div>

            <div class="editar-usuario-btn-container">
                <button type="button" class="btn-cancelar-editar-usuario" 
                        onclick="fecharModalEditarUsuario('modal_editar_usuario_<?= $funcionario->id ?>')">
                    Cancelar
                </button>
                <button type="submit" class="btn-salvar-editar-usuario">Salvar</button>
            </div>
        </form>
    </div>
</div>