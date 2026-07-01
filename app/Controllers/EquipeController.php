<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class EquipeController
{
    public function index()
    {
        $funcionarios = App::get('database')->selectAll('funcionario');
        $usuarios = App::get('database')->selectAll('usuario');

        return view('admin/equipe', compact('funcionarios', 'usuarios'));
    }
    
    public function edit()
    {
        $idFuncionario = $_POST['id_funcionario'];
        $idUsuario     = $_POST['id_usuario'];

        App::get('database')->update(
            'funcionario',
            [
                'nome'  => $_POST['nome'],
                'email' => $_POST['email'],
                'cargo' => $_POST['cargo']
            ],
            'id',
            $idFuncionario
        );

        $dadosUsuario = [
            'login' => $_POST['login']
        ];

        if (!empty($_POST['senha'])) {
            $dadosUsuario['senha'] = $_POST['senha'];
        }

        App::get('database')->update('usuario', $dadosUsuario, 'id', $idUsuario);

        header('Location: /admin/equipe');
        exit;
    }

public function create()
{
    $idUsuario = App::get('database')->insert('usuario', [
        'login' => $_POST['login'],
        'senha' => $_POST['senha']
    ]);

    App::get('database')->insert('funcionario', [
        'nome'       => $_POST['nome'],
        'email'      => $_POST['email'],
        'cargo'      => $_POST['cargo'],
        'STATUS'     => 'ATIVO',  
        'id_usuario' => $idUsuario
    ]);

    header('Location: /admin/equipe');
    exit;
}


    public function delete()
    {
        $idFuncionario = $_POST['id_funcionario'];
        $idUsuario = $_POST['id_usuario'];

        App::get('database')->delete('funcionario', $idFuncionario);
        App::get('database')->delete('usuario', $idUsuario);

        header('Location: /admin/equipe');
        exit;
    }
}