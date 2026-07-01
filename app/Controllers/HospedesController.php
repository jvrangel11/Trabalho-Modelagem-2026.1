<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class HospedesController
{
    public function index()
    {
        $dados_hospedes = App::get('database')->selectAll('hospede');

        return view('admin/hospedes', [
            'hospedes' => $dados_hospedes 
        ]);
    }

    public function store()
    {

        if (empty($_POST['nome'])) {
            return redirect('admin/hospedes');
        }

        $dados = [
            'nome' => $_POST['nome'],
            'cpf' => $_POST['cpf'],
            'email' => $_POST['email'],
            'telefone' => $_POST['telefone']
        ];

        if (!empty($_POST['id'])) {
            App::get('database')->update('hospede', $dados, 'id', $_POST['id']);
        } else {
            App::get('database')->insert('hospede', $dados);
        }

        return redirect('admin/hospedes');
    }

    public function update()
    {
        $id = $_POST['id']; 
        
        $dados = [
            'nome' => $_POST['nome'],
            'cpf' => $_POST['cpf'],
            'email' => $_POST['email'],
            'telefone' => $_POST['telefone']
        ];

        App::get('database')->update('hospede', $dados, 'id', $id);

        return redirect('admin/hospedes');
    }

    public function delete()
    {
        if (isset($_POST['id'])) {
            App::get('database')->delete('hospede', $_POST['id']);
        }

        return redirect('admin/hospedes');
    }

      public function buscar()
    {
        header('Content-Type: application/json');

        $cpf = $_GET['cpf'] ?? null;

        if (!$cpf) {
            echo json_encode(null);
            return;
        }

        $db = App::get('database');

        $hospede = $db->selectWhere('hospede', 'cpf', $cpf);

        echo json_encode(!empty($hospede) ? $hospede[0] : null);
    }

}