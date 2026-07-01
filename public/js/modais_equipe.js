function abrirModalEditarUsuario(idModal) {
    const modal = document.getElementById(idModal);
    if (modal) {
        modal.style.display = 'flex';
        // Se você usa o filtro separado:
        const filtro = document.getElementById('filtro');
        if(filtro) filtro.style.display = 'block';
    } else {
        console.error("Não encontrei o modal com ID:", idModal);
    }
}

function fecharModalEditarUsuario(idModal) {
    const modal = document.getElementById(idModal);
    if (modal) {
        modal.style.display = 'none';
        const filtro = document.getElementById('filtro');
        if(filtro) filtro.style.display = 'none';
    }
}

function abrirModalNovoUsuario(idModal) {
    const modal = document.getElementById(idModal);
    if (modal) {
        modal.style.display = 'flex';
    }
}

function fecharModalNovoUsuario(idModal) {
    const modal = document.getElementById(idModal);
    if (modal) {
        modal.style.display = 'none';
    }
}
function abrirModalInativar(idModal) {
    const modal = document.getElementById(idModal);
    if (modal) {
        modal.style.display = 'flex';
    }
}

function fecharModalInativar(idModal) {
    const modal = document.getElementById(idModal);
    if (modal) {
        modal.style.display = 'none';
    }
}

function toggleSenha(inputId, icon) {
    const input = document.getElementById(inputId);
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    }
}