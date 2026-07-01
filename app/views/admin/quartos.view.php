<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quartos - Pousada Pedra Talhada</title>
    <link rel="stylesheet" href="/public/css/index.css">
    <link rel="stylesheet" href="/public/css/quartos.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
   
    </style>
</head>
<body>
   <div class="app-container">
        <?php require 'app/views/admin/sidebar.html'; ?>
        <main>
            <header class="header">
                <h1>Gerenciamento de Quartos</h1>
                <div class="legenda">
                    <div class="legenda-item">
                        <span class="status disponivel"></span> Disponível
                    </div>
                    <div class="legenda-item">
                        <span class="status ocupado"></span> Ocupado
                    </div>
                    <div class="legenda-item">
                        <span class="status manutencao"></span> Manutenção
                    </div>
                </div>
            </header>

           <section class="quartos-container">
                <?php foreach ($quarto as $quart): ?>
                    <?php $statusLower = strtolower($quart->STATUS); ?>
        
                    <article id="card-<?= $quart->numero ?>" class="card <?= $statusLower ?>">
            
                        <div class="card-header">
                            <span id="icon-<?= $quart->numero ?>" class="material-icons-round">
                                <?php 
                                if($statusLower == 'disponivel') echo 'meeting_room';
                                elseif($statusLower == 'ocupado') echo 'person';
                                else echo 'build';
                                ?>
                            </span>
                            <span id="text-<?= $quart->numero ?>"><?= ucfirst($statusLower) ?></span>
                        </div>

                        <div class="room-num"><?= $quart->numero ?></div>

                        <div class="card-footer">
                        <div class="guest-info"><?= $quart->tipo ?></div>
                        <button type="button" class="btn-icon" onclick="openStatusModal('<?= $quart->numero ?>')">
                            <span class="material-icons-round card-edit">edit</span>
                        </button>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        </main>
    </div>

    <?php include 'app/views/admin/Modais/Quartos/modal_mudar_status.view.php'; ?>
    <script src="/public/js/quartos.js"></script>

</body>
</html>