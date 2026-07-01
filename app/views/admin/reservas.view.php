<?php
// ADICIONE ISTO NA PRIMEIRA LINHA DO ARQUIVO
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas - Pousada Pedra Talhada</title>

    <link rel="stylesheet" href="/public/css/index.css">
    <link rel="stylesheet" href="/public/css/reservas.css">
    <link rel="stylesheet" href="/public/css/Modais/Reserva/modal_nova_reserva.css">
    <link rel="stylesheet" href="/public/css/Modais/Reserva/modal_editar_reserva.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="app-container">
    <?php require 'app/views/admin/sidebar.html'; ?>

    <main>
        <div class="page-header">
            <h1>Gerenciamento de reservas</h1>
            <div class="page-header-actions">
                <button class="btn btn-primary" id="btnAbrirModal">
                    <span class="material-icons-round">add</span>
                    Nova Reserva
                </button>
            </div>
        </div>


        <?php if (isset($_SESSION['mensagem-erro'])): ?>
            <div class="alert alert-danger">
                <span class="material-icons-round" style="margin-right: 8px;">error</span>
                <?= $_SESSION['mensagem-erro']; ?>
            </div>
            <?php unset($_SESSION['mensagem-erro']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['mensagem-sucesso'])): ?>
            <div class="alert alert-success">
                <span class="material-icons-round" style="margin-right: 8px;">check_circle</span>
                <?= $_SESSION['mensagem-sucesso']; ?>
            </div>
            <?php unset($_SESSION['mensagem-sucesso']); ?>
        <?php endif; ?>

        <div class="table-container">
            <table id="reservasTable">
                <thead>
                    <tr>
                        <th>Hóspede</th>
                        <th>Quarto</th>
                        <th>Entrada</th>
                        <th>Saída</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($reservas as $reserva) : ?>
                    <tr>
                        <td><?= $reserva->nome ?? $reserva->idHospede ?></td>
                        <td><?= $reserva->idQuarto ?></td>
                        <td><?= date('d/m/Y', strtotime($reserva->dataEntradaPrevista)) ?></td>
                        <td><?= date('d/m/Y', strtotime($reserva->dataSaidaPrevista)) ?></td>

                        <td>
                            <span class="status-badge status-<?= strtolower($reserva->STATUS) ?>">
                                <?= ucfirst(strtolower($reserva->STATUS)) ?>
                            </span>
                        </td>

                        <td>
                            <div class="action-buttons">

                                <?php if ($reserva->STATUS === 'RESERVADA') : ?>
                                    <form action="/admin/reservas/checkin" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $reserva->id ?>">
                                        <button type="submit" class="btn btn-checkin btn-small">
                                            <span class="material-icons-round" style="font-size:16px;">check_circle</span>
                                            Check-in
                                        </button>
                                    </form>
                                <?php endif; ?>

                               <?php if ($reserva->STATUS === 'HOSPEDADA') : ?>
                                    <a href="/admin/checkout?id=<?= $reserva->id ?>" class="btn btn-checkout btn-small">
                                        <span class="material-icons-round" style="font-size:16px;">exit_to_app</span>
                                        Checkout
                                    </a>
                                <?php endif; ?>


                                <?php if ($reserva->STATUS !== 'CANCELADA') : ?>
                                    <button class="btn btn-edit btn-small"
                                        onclick='abrirModalEditar(<?= json_encode($reserva) ?>)'>
                                        <span class="material-icons-round" style="font-size:16px;">edit</span>
                                        Editar
                                    </button>
                                <?php endif; ?>

                                <?php if ($reserva->STATUS === 'RESERVADA') : ?>
                                    <form action="/admin/reservas/deletar"
                                          method="POST"
                                          style="display:inline;"
                                          onsubmit="return confirm('Tem certeza que deseja cancelar esta reserva?');">
                                        <input type="hidden" name="id" value="<?= $reserva->id ?>">
                                        <button type="submit" class="btn btn-cancel btn-small">
                                            <span class="material-icons-round" style="font-size:16px;">delete</span>
                                            Cancelar
                                        </button>
                                    </form>
                                <?php endif; ?>

                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <a href="?page=<?= $paginaAtual - 1 ?>" class="pagination-btn">« Anterior</a>

            <span style="font-size: 12px; color: #666;"> Página <?= $paginaAtual ?> de <?= $totalPaginas ?></span>

            <a href="?page=<?= $paginaAtual + 1 ?>" class="pagination-btn">Próxima »</a>
        </div>

    </main>
</div>

<?php require 'app/views/admin/Modais/Reservas/modal_nova_reserva.view.php'; ?>
<?php require 'app/views/admin/Modais/Reservas/modal_editar_reserva.view.php'; ?>

<script src="/public/js/modais_reserva.js"></script>
<script src="/public/js/criar_reserva.js" defer></script>

</body>
</html>
