<link rel="stylesheet" href="public/css/Modais/Reserva/modal_editar_reserva.css">

<div class="editar-reserva-container" id="modalEditarReserva" style="display: none;">
    <form action="/admin/reservas/atualizar" method="POST" class="modal-editar-reserva">

        <input type="hidden" name="id" id="edit-id">

        <h2>Editar Reserva</h2>

        <div class="editar-reserva-input-container">
            <div class="editar-reserva-input">
                <label>Data de Entrada</label>
                <input type="date" name="dataEntradaPrevista" id="edit-dataEntrada" required>
            </div>

            <div class="editar-reserva-input">
                <label>Data de Saída</label>
                <input type="date" name="dataSaidaPrevista" id="edit-dataSaida" required>
            </div>
        </div>

        <div class="editar-reserva-input-quarto">
            <label>Quarto</label>
            <select name="idQuarto" id="edit-quarto-select" required>
                <?php foreach ($quartos as $quarto): ?>
                    <option value="<?= $quarto->numero ?>">
                        Quarto <?= $quarto->numero ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <h2>Dados do Hóspede</h2>

        <div class="editar-reserva-input-container">
            <div class="editar-reserva-input">
                <label>Nome Completo</label>
                <input type="text" name="nome" id="edit-nome" required>
            </div>

            <div class="editar-reserva-input">
                <label>CPF</label>
                <input type="text" name="cpf" id="edit-cpf" readonly>
            </div>
        </div>

        <h2>Informações Adicionais</h2>

        <div class="editar-reserva-input-quarto">
            <label>Observações</label>
            <textarea name="observacoes" id="edit-observacoes"
                placeholder="Notas, pedidos especiais, alergias, etc..."></textarea>
        </div>

        <div class="editar-reserva-acoes">
            <button type="button" class="btn-cancelar" onclick="fecharModalEditar()">
                Cancelar
            </button>

            <button type="submit" class="btn-salvar">
                Salvar Alterações
            </button>
        </div>

    </form>
</div>
