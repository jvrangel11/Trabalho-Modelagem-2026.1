<link rel="stylesheet" href="../../../../../public/css/index.css">
<link rel="stylesheet" href="../../../../../public/css/modal_inativar.css">

<div class="inativar-container" id="modal_inativar_usuario_<?= $funcionario->id ?>" style="display:none;">
    <div class="modal-inativar">
        <h2>Tem certeza que deseja inativar o usuário "<?= htmlspecialchars($funcionario->nome) ?>"?</h2>
        
        <form action="/admin/equipe/delete" method="POST">
            <input type="hidden" name="id_funcionario" value="<?= $funcionario->id ?>">
            <input type="hidden" name="id_usuario" value="<?= $funcionario->id_usuario ?>">

            <div class="inativar-btn-container">
                <button type="button" 
                        class="btn-cancelar-inativar" 
                        onclick="fecharModalInativar('modal_inativar_usuario_<?= $funcionario->id ?>')">
                    Cancelar
                </button>
                <button type="submit" class="btn-salvar-inativar">Confirmar</button>
            </div>
        </form>
    </div>
</div>