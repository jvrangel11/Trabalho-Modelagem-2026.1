<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pousada Pedra Talhada</title>
    <link rel="stylesheet" href="./../../../public/css/Login.css">
     <script src="https://kit.fontawesome.com/bf586e4b37.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body class="login-page">

    <div class="logo"></div>
    
    <div class="login-container">
        <h1>Início</h1>
      

        <form action="/login" method="POST">
            <div class="input-name">
            <label>Usuário</label>
            <input type="text" name="login" id="login" placeholder="Digite seu usuário" required>
            </div>

            <label>Senha</label>
            <div class="input-senha">

            <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>
            <button class="botao-ver" type="button" id="toggleSenha"><i class="fa-regular fa-eye-slash"></i></button>

            </div>
            <button class="entrar" type="submit">Entrar</button>
        </form>
    </div>

      <div class="mensagem-erro">
                        <p>
                            <?php
                            if(isset($_SESSION['mensagem-erro'])){
                                echo $_SESSION['mensagem-erro'];
                                unset($_SESSION['mensagem-erro']);
                            }
                            ?>
                        </p>
                    </div>

    <script>

        // 1. Seleciona os elementos pelo ID
const campoSenha = document.getElementById('senha');
const botaoToggle = document.getElementById('toggleSenha');
const icone = botaoToggle.querySelector('i'); // Seleciona o ícone dentro do botão

// 2. Adiciona um "ouvinte de eventos" (event listener) ao botão
botaoToggle.addEventListener('click', function (e) {
    // 3. Verifica o tipo atual do campo: "password" ou "text"
    const type = campoSenha.getAttribute('type') === 'password' ? 'text' : 'password';
    
    // 4. Alterna o atributo 'type' do campo de entrada
    campoSenha.setAttribute('type', type);
    
    // 5. Opcional: Altera o ícone para refletir o novo estado
    if (type === 'text') {
        // Se a senha está visível (type="text"), muda o ícone para olho aberto
        icone.classList.remove('fa-eye-slash');
        icone.classList.add('fa-eye');
    } else {
        // Se a senha está oculta (type="password"), muda o ícone para olho riscado
        icone.classList.remove('fa-eye');
        icone.classList.add('fa-eye-slash');
    }
});

    </script>
</body>
</html>