<link rel="stylesheet" href="/public/css/Modais/Reserva/modal_nova_reserva.css">
<link rel="stylesheet" href="/public/css/index.css">

<div class="nova-reserva-container" id="modalNovaReserva" style="display: none;">
    <form action="/admin/reservas/criar" method="POST" class="modal-nova-reserva">

        <h2>Seleção de Quarto</h2>

        <div class="nova-reserva-input-container">
            <div class="nova-reserva-input">
                <label>Data de Entrada <span class="required">*</span></label>
                <input type="date"
                       name="dataEntradaPrevista"
                       id="dataEntrada"
                       value="<?= $_GET['dataEntrada'] ?? '' ?>"
                       required>
            </div>

            <div class="nova-reserva-input">
                <label>Data de Saída <span class="required">*</span></label>
                <input type="date"
                       name="dataSaidaPrevista"
                       id="dataSaida"
                       value="<?= $_GET['dataSaida'] ?? '' ?>"
                       required>
            </div>
        </div>

        <div class="nova-reserva-input-quarto">
            <label>Quarto <span class="required">*</span></label>

            <select name="idQuarto" id="quarto-select" required>
                <option value="" disabled selected>
                    -- Selecione um quarto disponível --
                </option>

                <?php if (!empty($quartos)): ?>
                    <?php foreach ($quartos as $quarto): ?>
                        <option value="<?= $quarto->numero ?>"
                                data-preco="<?= $quarto->precoDiaria ?>">
                            Quarto <?= $quarto->numero ?>
                            - <?= $quarto->tipo ?>
                            (R$ <?= number_format($quarto->precoDiaria, 2, ',', '.') ?>)
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="" disabled>
                        Nenhum quarto disponível para o período selecionado
                    </option>
                <?php endif; ?>
            </select>
        </div>

        <h2>Dados do Hóspede</h2>

        <div class="nova-reserva-input-container">
            <div class="nova-reserva-input">
                <label>Nome Completo <span class="required">*</span></label>
                <input type="text"
                       name="nome"
                       placeholder="Ex: João Silva"
                       required>
            </div>

            <div class="nova-reserva-input">
                <label>CPF <span class="required">*</span></label>
                <input type="text"
                       name="cpf"
                       id="cpf_hospede"
                       placeholder="Ex: 000.000.000-00"
                       required>
            </div>
        </div>

        <div class="nova-reserva-input-container">
            <div class="nova-reserva-input">
                <label>E-mail <span class="required">*</span></label>
                <input type="email"
                       name="email"
                       placeholder="Ex: joao@email.com"
                       required>
            </div>

            <div class="nova-reserva-input">
                <label>Telefone <span class="required">*</span></label>
                <input type="tel"
                       name="telefone"
                       placeholder="Ex: (11) 99999-9999"
                       required>
            </div>
        </div>

        <h2>Informações Adicionais</h2>

        <div class="nova-reserva-input-quarto">
            <label>Observações</label>
            <textarea name="observacoes"
                      placeholder="Notas especiais, requisições, alergias, etc..."></textarea>
        </div>

        <input type="hidden" name="STATUS" value="RESERVADA">
        <input type="hidden" name="valorTotal" id="input-valor-total" value="0">

        <div class="resumo-reserva-container">
            <h3>Resumo da Reserva</h3>

            <div class="resumo-item">
                <span>Valor da Diária:</span>
                <span id="valor-diaria">R$ 0,00</span>
            </div>

            <div class="resumo-item">
                <span>Quantidade de Diárias:</span>
                <span id="qtd-diarias">0</span>
            </div>

            <div class="resumo-item">
                <span>Subtotal:</span>
                <span id="subtotal">R$ 0,00</span>
            </div>

            <div class="resumo-item">
                <span>Taxa de Serviço (10%):</span>
                <span id="taxa-servico">R$ 0,00</span>
            </div>

            <div class="resumo-item total">
                <strong>Total:</strong>
                <strong id="valor-total-display">R$ 0,00</strong>
            </div>
        </div>

        <div class="nova-reserva-acoes">
            <button type="button" class="btn-cancelar" id="btnFecharModal">
                Cancelar
            </button>

            <button type="submit" class="btn-salvar"
                <?= empty($quartos) ? 'disabled' : '' ?>>
                Salvar Reserva
            </button>
        </div>

    </form>
</div>
