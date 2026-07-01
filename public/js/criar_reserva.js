document.addEventListener('DOMContentLoaded', function () {

    const cpfInput = document.getElementById('cpf_hospede');

    if (!cpfInput) return;

    cpfInput.addEventListener('blur', function () {
        const cpf = this.value;

        fetch(`/admin/hospedes/buscar?cpf=${cpf}`)
            .then(res => res.json())
            .then(hospede => {
                if (hospede) {
                    document.querySelector('input[name="nome"]').value = hospede.nome;
                    document.querySelector('input[name="email"]').value = hospede.email;
                    document.querySelector('input[name="telefone"]').value = hospede.telefone;
                }
            });
    });

});
