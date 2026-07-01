document.addEventListener('DOMContentLoaded', () => {

    const addItemBtn = document.getElementById('add-item-btn');
    const descricaoInput = document.getElementById('descricao');
    const quantidadeInput = document.getElementById('quantidade');
    const valorUnitarioInput = document.getElementById('valorUnitario');
    const idConta = parseInt(document.getElementById('idConta').value);

    const resumo = document.getElementById('resumo-pagamento');
    const tbody = document.getElementById('consumos-body');

    const diarias = parseInt(resumo.dataset.diarias);
    const valorHospedagem = parseFloat(resumo.dataset.valorHospedagem);
    let totalConsumos = parseFloat(resumo.dataset.totalConsumos);

    // Função para atualizar o resumo de pagamento
    function atualizarResumo() {
        const taxaServico = valorHospedagem * diarias * 0.1;
        const total = valorHospedagem * diarias + taxaServico + totalConsumos;

        resumo.innerHTML = `
            <div class="checkout-summary-line">
                <span>Hospedagem (${diarias} dias):</span>
                <span>R$ ${(valorHospedagem * diarias).toFixed(2).replace('.', ',')}</span>
            </div>
            <div class="checkout-summary-line">
                <span>Consumos:</span>
                <span>R$ ${totalConsumos.toFixed(2).replace('.', ',')}</span>
            </div>
            <div class="checkout-summary-line">
                <span>Taxa de Serviço:</span>
                <span>R$ ${taxaServico.toFixed(2).replace('.', ',')}</span>
            </div>
            <hr class="checkout-divider">
            <div class="checkout-summary-total">
                <span class="checkout-text">TOTAL A PAGAR:</span>
                <span class="checkout-total-value">R$ ${total.toFixed(2).replace('.', ',')}</span>
            </div>
        `;
    }

    // Inicializa o resumo
    atualizarResumo();

    // Evento para adicionar consumo
    addItemBtn.addEventListener('click', () => {
        const descricao = descricaoInput.value.trim();
        const quantidade = parseInt(quantidadeInput.value) || 0;
        const valorUnitario = parseFloat(valorUnitarioInput.value.replace(',', '.')) || 0;

        if (!descricao || quantidade <= 0 || valorUnitario <= 0) {
            alert('Preencha todos os campos corretamente');
            return;
        }

        // Envia para o back-end via fetch JSON
        fetch('/admin/checkout/adicionarConsumo', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ descricao, quantidade, valorUnitario, idConta })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                // Limpa tabela antes de atualizar
                tbody.innerHTML = '';
                totalConsumos = 0;

                // Adiciona cada item novo à tabela
                data.consumos.forEach(item => {
                    const totalItem = item.quantidade * item.valorUnitario;
                    totalConsumos += totalItem;

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${item.descricao}</td>
                        <td>${item.quantidade}</td>
                        <td>R$ ${item.valorUnitario.toFixed(2).replace('.',',')}</td>
                        <td><strong>R$ ${totalItem.toFixed(2).replace('.',',')}</strong></td>
                    `;
                    tbody.appendChild(tr);
                });

                // Atualiza o resumo de pagamento
                atualizarResumo();

                // Limpa inputs
                descricaoInput.value = '';
                quantidadeInput.value = '';
                valorUnitarioInput.value = '';
            } else {
                alert(data.msg || 'Erro ao adicionar consumo');
            }
        })
        .catch(err => {
            console.error(err);
            //alert('Erro na requisição');
        });
    });

});
