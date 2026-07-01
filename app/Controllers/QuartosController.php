<?php

namespace App\Controllers;

use App\Core\App;
use Exception;


class QuartosController
{
 public function index()
    {
        $dados = App::get('database')->selectAll('quarto');
        return view('admin/quartos', ['quarto' => $dados]);
    }

    public function updateStatus()
{
    $numeroQuarto = $_POST['id'];
    $novoStatus = $_POST['status'];

    $statusPermitidos = ['DISPONIVEL', 'MANUTENCAO', 'OCUPADO'];

    if (in_array($novoStatus, $statusPermitidos)) {
        try {
            App::get('database')->update('quarto', [
                'STATUS' => $novoStatus
            ], 'numero', $numeroQuarto);

            header('Location: /admin/quartos');
            exit;

        } catch (Exception $e) {
            die("Erro ao atualizar o status: " . $e->getMessage());
        }
    } else {
        die("Status inválido enviado.");
    }
}
}