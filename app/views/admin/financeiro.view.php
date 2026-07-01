<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Caixa</title>
    <link rel="stylesheet" href="/public/css/financeiro.css">
    <link rel="stylesheet" href="/public/css/modal_abrir_caixa.css">
    <link rel="stylesheet" href="/public/css/modal_sangria.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <?php require 'app/views/admin/sidebar.html'; ?>

    <?php
        // Garantir que todos os itens de movimentacoes sejam objetos
        foreach ($movimentacoes as $i => $m) {
            $movimentacoes[$i] = (object)$m;
        }

        // Calcular entradas do dia
        $entradasDia = 0;
        $saldoAtualCalculado = $saldoInicial;
        foreach ($movimentacoes as $m) {
            if ($m->tipo === 'ENTRADA') {
                $entradasDia += $m->valor;
                $saldoAtualCalculado += $m->valor;
            } else {
                $saldoAtualCalculado -= $m->valor;
            }
        }
    ?>

    <main class="conteudo">
        <header class="cabecalho">
            <h1>Controle de Caixa</h1>
        </header>

        <section class="informacoes">
            <article class="informacoes-card">
                <div class="icon verde"><i class="fa-solid fa-wallet"></i></div>
                <span class="label">Saldo Inicial</span>
                <strong id="saldo-inicial">R$ <?= number_format($saldoInicial, 2, ',', '.') ?></strong>
            </article>

            <article class="informacoes-card">
                <div class="icon verde"><i class="fa-solid fa-arrow-trend-up"></i></div>
                <span class="label">Entradas do Dia</span>
                <strong id="entradas-dia">R$ <?= number_format($entradasDia, 2, ',', '.') ?></strong>
            </article>

            <article class="informacoes-card">
                <div class="icon verde"><i class="fa-solid fa-dollar-sign"></i></div>
                <span class="label">Saldo Atual</span>
                <strong id="saldo-atual">R$ <?= number_format($saldoAtualCalculado, 2, ',', '.') ?></strong>
            </article>
        </section>

        <section class="acoes">
            <button class="btn abrir" id="btn-abrir-caixa">Abrir Caixa</button>
            <button class="btn sangria" id="btn-sangria">Registrar Sangria</button>
            <button class="btn fechar" id="btn-fechar-caixa">Fechar Caixa</button>
        </section>

        <h3 class="titulo-tabela">Movimentações Recentes</h3>
        <section class="secao-tabela">
            <table class="tabela">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Horário</th>
                    </tr>
                </thead>
                <tbody id="movimentacoes-body">
                    <?php foreach($movimentacoes as $m): ?>
                        <tr>
                            <td><?= htmlspecialchars($m->descricao) ?></td>
                            <td><span class="tag <?= strtolower($m->tipo) ?>"><?= htmlspecialchars($m->tipo) ?></span></td>
                            <td class="<?= $m->tipo === 'ENTRADA' ? 'positivo' : 'negativo' ?>">
                                R$ <?= number_format($m->valor, 2, ',', '.') ?>
                            </td>
                            <td><?= date('H:i', strtotime($m->dataHora)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <?php require 'app/views/admin/Modais/Financeiro/modal_abrir_caixa.view.php'; ?>
    <?php require 'app/views/admin/Modais/Financeiro/modal_sangria.view.php'; ?>
    <script src="/public/js/caixa.js"></script>
</body>
</html>