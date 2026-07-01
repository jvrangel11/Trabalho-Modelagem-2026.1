// ====== ELEMENTOS ======
const btnAbrir = document.getElementById('btn-abrir-caixa');
const modalAbrir = document.getElementById('modal-abrir-caixa');
const valorInicialInput = document.getElementById('valor-inicial');
const confirmarAbrir = document.getElementById('confirmar-abrir-caixa');

const btnSangria = document.getElementById('btn-sangria');
const modalSangria = document.getElementById('sangria-modal');
const cancelarSangria = document.getElementById('cancelar-sangria');
const confirmarSangria = document.getElementById('confirmar-sangria');
const valorSangriaInput = document.getElementById('sangria-valor');

const btnFechar = document.getElementById('btn-fechar-caixa');
const saldoAtualEl = document.getElementById('saldo-atual');
const entradasDiaEl = document.getElementById('entradas-dia');
const tbodyMovimentacoes = document.getElementById('movimentacoes-body');

let saldoAtual = parseFloat(saldoAtualEl.textContent.replace('R$ ','').replace('.','').replace(',','.')) || 0;
let entradasDia = parseFloat(entradasDiaEl.textContent.replace('R$ ','').replace('.','').replace(',','.')) || 0;

// ====== ABRIR CAIXA ======
btnAbrir.addEventListener('click', () => {
    if(modalAbrir) modalAbrir.style.display = 'flex';
});

modalAbrir.addEventListener('click', (e) => {
    if(e.target === modalAbrir){
        modalAbrir.style.display = 'none';
        if(valorInicialInput) valorInicialInput.value = '';
    }
});

confirmarAbrir.addEventListener('click', async () => {
    const valorRaw = valorInicialInput.value.replace('.', '').replace(',', '.').trim();
    const valor = parseFloat(valorRaw);

    if (isNaN(valor) || valor < 0) {
        alert('Digite um valor válido.');
        return;
    }

    try {
        const response = await fetch('/admin/financeiro/abrir-caixa', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ valor })
        });
        const result = await response.json();

        if(result.success){
            saldoAtual = valor;
            entradasDia = 0;
            saldoAtualEl.textContent = 'R$ ' + saldoAtual.toFixed(2).replace('.',',');
            entradasDiaEl.textContent = 'R$ 0,00';
            tbodyMovimentacoes.innerHTML = ''; // limpa movimentações antigas

            alert('Caixa aberto com sucesso!');
            modalAbrir.style.display = 'none';
            valorInicialInput.value = '';
        } else {
            alert('Erro ao abrir caixa: ' + result.message);
        }
    } catch (err) {
        console.error(err);
        alert('Erro de conexão com o servidor.');
    }
});

// ====== SANGRIA ======
btnSangria.addEventListener('click', () => {
    if(modalSangria) modalSangria.style.display = 'flex';
});

cancelarSangria.addEventListener('click', () => {
    modalSangria.style.display = 'none';
    valorSangriaInput.value = '';
});

confirmarSangria.addEventListener('click', async () => {
    const valorRaw = valorSangriaInput.value.replace(',', '.').replace('R$', '').trim();
    const valor = parseFloat(valorRaw);

    if(isNaN(valor) || valor <= 0){
        alert('Informe um valor válido');
        return;
    }

    try {
        const response = await fetch('/admin/financeiro/sangria', {
            method: 'POST',
            headers: {'Content-Type':'application/json'},
            body: JSON.stringify({ valor })
        });
        const data = await response.json();

        if(data.success){
            const novaLinha = document.createElement('tr');
            novaLinha.innerHTML = `
                <td>Sangria</td>
                <td><span class="tag saida">SAÍDA</span></td>
                <td class="negativo">R$ ${valor.toFixed(2).replace('.',',')}</td>
                <td>${data.dataHora}</td>
            `;
            tbodyMovimentacoes.prepend(novaLinha);

            saldoAtual -= valor;
            saldoAtualEl.textContent = 'R$ ' + saldoAtual.toFixed(2).replace('.',',');

            modalSangria.style.display = 'none';
            valorSangriaInput.value = '';
        } else {
            alert('Erro ao registrar sangria: ' + (data.message ?? ''));
        }
    } catch (err) {
        console.error(err);
        alert('Erro de conexão com o servidor.');
    }
});

// ====== FECHAR CAIXA ======
btnFechar.addEventListener('click', async () => {
    if(!confirm('Deseja realmente fechar o caixa e gerar o relatório do dia?')) return;

    try {
        const response = await fetch('/admin/financeiro/fechar-caixa', {
            method: 'POST',
            headers: {'Content-Type':'application/json'},
            body: JSON.stringify({})
        });
        const data = await response.json();

        if(data.success){
            alert('Caixa fechado! PDF gerado: ' + data.pdf);
            saldoAtual = 0;
            entradasDia = 0;
            saldoAtualEl.textContent = 'R$ 0,00';
            entradasDiaEl.textContent = 'R$ 0,00';
            tbodyMovimentacoes.innerHTML = '';
        } else {
            alert('Erro ao fechar o caixa: ' + (data.message ?? ''));
        }
    } catch (err) {
        console.error(err);
        alert('Erro de conexão com o servidor.');
    }
});
