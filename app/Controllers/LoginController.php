<?php
namespace App\Controllers;
use App\Core\App;
use Exception;

class LoginController 
{

      public function index()
    {
       if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['id'])) {
            header('Location: /quartos');
            exit;
        }

        return view('site/login');
    }

    public function exibirLogin(): mixed
    {
    
   if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $name = $_POST['name'] ?? null;
        $senha = $_POST['senha'] ?? null;

        $user = App::get('database')->verificaLogin($email, $senha);

        if ($user) {
            $_SESSION['id'] = $user->id;
            $_SESSION['user'] = $user;
            header('Location: /quartos');
            exit;
        }
              $_SESSION['mensagem-erro'] = "Usuário e/ou senha incorretos";
        header('Location: /login');
        exit;
 }
    

    public function exibirQuartos(): mixed
    {
        return view(name: 'admin/quartos');
    }
    
   public function efetuaLogin()
{
    $login = $_POST['login'] ?? null;
    $senha = $_POST['senha'] ?? null;

    if ($login && $senha) {
        
        // CORREÇÃO AQUI:
        // Em vez de $this->app->database, usamos App::get('database')
        $usuario = App::get('database')->verificaLogin($login, $senha);

        if ($usuario) {
            // Login sucesso
            // Recomendado: iniciar sessão aqui
            session_start();
            $_SESSION['usuario'] = $usuario;

            $_SESSION['cargo'] = $usuario->cargo ?? $usuario['cargo'];

            header('Location: admin/quartos');
            exit;
            
        } else {
            echo "Login ou senha incorretos.";
        }
    } else {
        echo "Preencha todos os campos.";
    }
}

    public function logout(): void
    {
        session_start();
        session_unset();
        session_destroy();
        header(header: 'Location: /login');
        exit();
    }
}
?>