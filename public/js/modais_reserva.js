document.addEventListener('DOMContentLoaded', function() {
    const modalNovaReserva = document.getElementById('modalNovaReserva');
    const btnAbrir = document.getElementById('btnAbrirModal');
    const btnFechar = document.getElementById('btnFecharModal');

    if (btnAbrir) {
        btnAbrir.addEventListener('click', function(e) {
            e.preventDefault();
            modalNovaReserva.style.display = 'flex';
        });
    }

    if (btnFechar) {
        btnFechar.addEventListener('click', function() {
            modalNovaReserva.style.display = 'none';
        });
    }

    window.addEventListener('click', function(event) {
        if (event.target === modalNovaReserva) {
            modalNovaReserva.style.display = 'none';
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const dataEntrada = document.getElementById('dataEntrada');
    const dataSaida = document.getElementById('dataSaida');
    const quartoSelect = document.getElementById('quarto-select');

    const displayDiaria = document.getElementById('valor-diaria');
    const displayQtdDiarias = document.getElementById('qtd-diarias');
    const displaySubtotal = document.getElementById('subtotal');
    const displayTaxa = document.getElementById('taxa-servico');
    const displayTotal = document.getElementById('valor-total-display');
    const inputValorTotal = document.getElementById('input-valor-total');

    function calcularResumo() {
        const dataIn = new Date(dataEntrada.value);
        const dataOut = new Date(dataSaida.value);
        
        const selectedOption = quartoSelect.options[quartoSelect.selectedIndex];
        const precoDiaria = selectedOption ? parseFloat(selectedOption.getAttribute('data-preco')) : 0;

        if (dataEntrada.value && dataSaida.value && precoDiaria > 0) {
            if (dataOut > dataIn) {
                const diffTime = Math.abs(dataOut - dataIn);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                const subtotal = diffDays * precoDiaria;
                const taxa = subtotal * 0.10;
                const totalGeral = subtotal + taxa;

                displayDiaria.innerText = `R$ ${precoDiaria.toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;
                displayQtdDiarias.innerText = diffDays;
                displaySubtotal.innerText = `R$ ${subtotal.toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;
                displayTaxa.innerText = `R$ ${taxa.toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;
                displayTotal.innerText = `R$ ${totalGeral.toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;
                inputValorTotal.value = totalGeral.toFixed(2);
            } else {
                limparResumo();
            }
        }
    }

    function limparResumo() {
        displayDiaria.innerText = "R$ 0,00";
        displayQtdDiarias.innerText = "0";
        displaySubtotal.innerText = "R$ 0,00";
        displayTaxa.innerText = "R$ 0,00";
        displayTotal.innerText = "R$ 0,00";
        inputValorTotal.value = "0";
    }

    dataEntrada.addEventListener('change', calcularResumo);
    dataSaida.addEventListener('change', calcularResumo);
    quartoSelect.addEventListener('change', calcularResumo);
});

function abrirModalEditar(reserva) {
    const modal = document.getElementById('modalEditarReserva');

    document.getElementById('edit-id').value = reserva.id;
    document.getElementById('edit-dataEntrada').value = reserva.dataEntradaPrevista.split(' ')[0];
    document.getElementById('edit-dataSaida').value = reserva.dataSaidaPrevista.split(' ')[0];
    document.getElementById('edit-quarto-select').value = reserva.idQuarto;
    document.getElementById('edit-nome').value = reserva.nome || '';
    document.getElementById('edit-cpf').value = reserva.cpf || '';
    document.getElementById('edit-observacoes').value = reserva.observacoes || '';

    modal.style.display = 'flex';
}


function fecharModalEditar() {
    document.getElementById('modalEditarReserva').style.display = 'none';
}

window.onclick = function(event) {
    const modalEditar = document.getElementById('modalEditarReserva');
    const modalNovo = document.getElementById('modalNovaReserva');
    if (event.target == modalEditar) modalEditar.style.display = "none";
    if (event.target == modalNovo) modalNovo.style.display = "none";
}