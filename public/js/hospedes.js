/* public/js/hospedes.js */


function openModal(modalId) {
   const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
    }
}


function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

function prepararNovoHospede() {

    const form = document.getElementById('guestForm');
    if (form) form.reset();

  
    const inputId = document.getElementById('guestId');
    if (inputId) inputId.value = '';

  
    openModal('guestModal');
}

function editGuest(id, nome, cpf, email, telefone) {
    console.log('editGuest chamada', id);

    document.getElementById('editId').value = id;
    document.getElementById('editNome').value = nome;
    document.getElementById('editCpf').value = cpf;
    document.getElementById('editEmail').value = email;
    document.getElementById('editTelefone').value = telefone;

    document.getElementById('editModal').style.display = 'flex';
}


window.onclick = function(event) {
    const modal = document.getElementById('guestModal');
    if (event.target === modal) {
        closeModal('guestModal');
    }
}