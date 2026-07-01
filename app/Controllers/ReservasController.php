<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class ReservasController
{
    public function index()
    {
        $db = App::get('database');

        $porPagina = 5;
        $paginaAtual = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($paginaAtual - 1) * $porPagina;

        $totalReservas = $db->countReservasAtivas();
        $totalPaginas = ceil($totalReservas / $porPagina);

        $reservas = $db->selectReservasAtivasPaginated($porPagina, $offset);
        $quartos  = $db->selectAll('quarto');

        $reservasAtivas = [];

        foreach ($reservas as $reserva) {
            $hospede = $db->selectWhere('hospede', 'id', $reserva->idHospede);

            if (!empty($hospede)) {
                $reserva->nome        = $hospede[0]->nome;
                $reserva->cpf         = $hospede[0]->cpf;
                $reserva->observacoes = $hospede[0]->observacoes ?? '';
            } else {
                $reserva->nome        = 'Não encontrado';
                $reserva->cpf         = '';
                $reserva->observacoes = '';
            }

            $reservasAtivas[] = $reserva;
        }

        return view('admin/reservas', [
            'reservas'     => $reservasAtivas,
            'quartos'      => $quartos,
            'paginaAtual'  => $paginaAtual,
            'totalPaginas' => $totalPaginas
        ]);
    }

    public function criar()
    {


    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    try {
        $db = App::get('database');

        $dataEntrada = $_POST['dataEntradaPrevista'] . ' 14:00:00';
        $dataSaida   = $_POST['dataSaidaPrevista']   . ' 12:00:00';
        $idQuarto    = $_POST['idQuarto'];

        if ($dataEntrada >= $dataSaida) {
            throw new Exception('Data de saída deve ser maior que a de entrada.');
        }

        if ($db->existeConflitoReserva($idQuarto, $dataEntrada, $dataSaida)) {
            throw new Exception('Este quarto já está reservado nesse período.');
        }

        $hospedeExistente = $db->selectWhere('hospede', 'cpf', $_POST['cpf']);

        if (!empty($hospedeExistente)) {
            $idHospede = $hospedeExistente[0]->id;
        } else {
            $idHospede = $db->insert('hospede', [
                'nome'        => $_POST['nome'],
                'cpf'         => $_POST['cpf'],
                'email'       => $_POST['email'],
                'telefone'    => $_POST['telefone'],
                'observacoes' => $_POST['observacoes'] ?? null
            ]);
        }

        $idReserva = $db->insert('reserva', [
            'dataEntradaPrevista' => $dataEntrada,
            'dataSaidaPrevista'   => $dataSaida,
            'idQuarto'            => $idQuarto,
            'idHospede'           => $idHospede,
            'STATUS'              => 'RESERVADA'
        ]);

        $db->insert('conta', [
            'idReserva'  => $idReserva,
            'valorTotal' => $_POST['valorTotal'] ?? 0,
            'STATUS'     => 'ABERTA'
        ]);

     
        $_SESSION['mensagem-sucesso'] = "Reserva realizada com sucesso!";
        header('Location: /admin/reservas');
        exit;

    } catch (Exception $e) {
       
        $_SESSION['mensagem-erro'] = $e->getMessage();
        
        header('Location: /admin/reservas');
        exit;
    }

    }





    public function checkin()
    {
        $db = App::get('database');
        $idReserva = $_POST['id'];
        $reserva = $db->selectWhere('reserva', 'id', $idReserva);

        if (empty($reserva)) {
            throw new Exception('Reserva não encontrada.');
        }

        $idQuarto = $reserva[0]->idQuarto;

        $db->update('reserva', [
            'STATUS'      => 'HOSPEDADA',
            'dataCheckin' => date('Y-m-d H:i:s')
        ], 'id', $idReserva);

        $db->update('quarto', [
            'STATUS' => 'OCUPADO'
        ], 'numero', $idQuarto);

        return redirect('admin/reservas');
    }

    public function deletar()
    {
        $db = App::get('database');

        $db->update('reserva', [
            'STATUS' => 'CANCELADA'
        ], 'id', $_POST['id']);

        return redirect('admin/reservas');
    }

    public function atualizar()
    {
        try {
            $db = App::get('database');

            $id          = $_POST['id'] ?? null;
            $dataEntrada = $_POST['dataEntradaPrevista'] ?? null;
            $dataSaida   = $_POST['dataSaidaPrevista'] ?? null;
            $idQuarto    = $_POST['idQuarto'] ?? null;
            $nome        = $_POST['nome'] ?? null;
            $cpf         = $_POST['cpf'] ?? null;
            $observacoes = $_POST['observacoes'] ?? null;

            if (!$id || !$idQuarto || !$cpf) {
                throw new Exception('Dados obrigatórios não informados.');
            }

            $db->update('reserva', [
                'dataEntradaPrevista' => $dataEntrada,
                'dataSaidaPrevista'   => $dataSaida,
                'idQuarto'            => $idQuarto
            ], 'id', $id);

            $db->update('hospede', [
                'nome'        => $nome,
                'observacoes' => $observacoes
            ], 'cpf', $cpf);

            return redirect('admin/reservas');

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function checkout()
    {
        $id = $_POST['id'];
        $db = App::get('database');

        $db->update('reserva', [
            'STATUS' => 'FINALIZADA'
        ], 'id', $id);

        header('Location: /admin/checkout');
        exit;
    }
}
