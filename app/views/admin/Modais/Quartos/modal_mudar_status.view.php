<link rel="stylesheet" href="/public/css/modal_mudar_status.css">
<link rel="stylesheet" href="/public/css/index.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<div class="mudar-status-container" id="statusModal" style="display: none;">
    <div class="modal-status">
        
        <div class="modal-status-header">
            <h2>Escolha o status do quarto: </h2>
            
            <button type="button" class="status-exit" onclick="closeModal('statusModal')">
                <span class="material-icons-round">close</span>
            </button>
        </div>

        <form action="/admin/quartos/status" method="POST">
            
            <input type="hidden" name="id" id="statusRoomId">
            <input type="hidden" name="status" id="inputStatusValue">
            
            <div class="btn-container-status">
                <button type="submit" class="btn-disponivel" onclick="setStatus('disponivel')">
                    Disponível
                </button>
                
                <button type="submit" class="btn-manutencao" onclick="setStatus('manutencao') ">
                    Manutenção
                </button>
            
            </div>
        </form>

    </div>
</div>