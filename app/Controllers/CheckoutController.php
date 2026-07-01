<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class CheckoutController
{
    // Página do checkout
    public function index()
    {
        $idReserva = $_GET['id'] ?? null;
        if (!$idReserva) {
            throw new Exception("Reserva não encontrada.");
        }

        $db = App::get('database');

        // Buscar reserva
        $reserva = $db->selectWhere('reserva', 'id', $idReserva)[0] ?? null;
        if (!$reserva) {
            throw new Exception("Reserva não encontrada.");
        }

        // Buscar hóspede
        $hospede = $db->selectWhere('hospede', 'id', $reserva->idHospede)[0] ?? null;

        // Buscar quarto
        $quarto = $db->selectWhere('quarto', 'numero', $reserva->idQuarto)[0] ?? null;

        // Buscar conta
        $conta = $db->selectWhere('conta', 'idReserva', $reserva->id)[0] ?? null;

        // Se não existir conta, criar uma
        if (!$conta) {
            $db->insert('conta', [
                'valorTotal' => 0,
                'STATUS'     => 'ABERTA',
                'idReserva'  => $reserva->id
            ]);
            $conta = $db->selectWhere('conta', 'idReserva', $reserva->id)[0];
        }

        // Buscar consumos da conta
        $consumos = $conta ? $db->selectWhere('itemconsumo', 'idConta', $conta->id) : [];

        // Calcular diárias e valor da hospedagem
        $dataEntrada = new \DateTime($reserva->dataEntradaPrevista);
        $dataSaida = new \DateTime($reserva->dataSaidaPrevista);
        $diarias = $dataSaida->diff($dataEntrada)->days;
        $valorHospedagem = $quarto->precoDiaria ?? 0;

        // Total consumos iniciais
        $totalConsumos = 0;
        foreach ($consumos as $item) {
            $totalConsumos += $item->quantidade * $item->valorUnitario;
        }

        return view('admin/checkout', [
            'reserva'         => $reserva,
            'hospede'         => $hospede,
            'quarto'          => $quarto,
            'conta'           => $conta,
            'consumos'        => $consumos,
            'diarias'         => $diarias,
            'valorHospedagem' => $valorHospedagem,
            'totalConsumos'   => $totalConsumos
        ]);
    }

    // Confirmar checkout
    public function confirmar()
    {
        $idReserva = $_POST['idReserva'] ?? null;
        if (!$idReserva) {
            throw new Exception("Reserva inválida.");
        }

        $db = App::get('database');

        $reserva = $db->selectWhere('reserva', 'id', $idReserva)[0];

        // Atualizar reserva como finalizada
        $db->update('reserva', [
            'STATUS'       => 'FINALIZADA',
            'dataCheckout' => date('Y-m-d H:i:s')
        ], 'id', $idReserva);

        // Atualizar conta como paga E registrar data do pagamento
        $db->update('conta', [
            'STATUS'       => 'PAGA',
            'dataPagamento'=> date('Y-m-d H:i:s')
        ], 'idReserva', $idReserva);

        // Liberar quarto
        $db->update('quarto', [
            'STATUS' => 'DISPONIVEL'
        ], 'numero', $reserva->idQuarto);

        // Redirecionar para lista de reservas
        $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
                    . "://{$_SERVER['HTTP_HOST']}";
        header("Location: {$baseUrl}/admin/reservas");
        exit;
    }

    // Adicionar item de consumo
    public function adicionarConsumo()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $descricao     = $data['descricao'] ?? null;
        $quantidade    = isset($data['quantidade']) ? (int)$data['quantidade'] : 0;
        $valorUnitario = isset($data['valorUnitario']) ? (float) str_replace(',', '.', $data['valorUnitario']) : 0;
        $idConta       = isset($data['idConta']) ? (int)$data['idConta'] : 0;

        if (!$descricao || $quantidade <= 0 || $valorUnitario <= 0 || !$idConta) {
            return json_encode(['status' => 'error', 'msg' => 'Dados incompletos ou inválidos']);
        }

        $db = App::get('database');

        try {
            $db->insert('itemconsumo', [
                'descricao'    => $descricao,
                'quantidade'   => $quantidade,
                'valorUnitario'=> $valorUnitario,
                'idConta'      => $idConta
            ]);
        } catch (\Exception $e) {
            return json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
        }

        // Buscar consumos atualizados
        $itens = $db->selectWhere('itemconsumo', 'idConta', $idConta);

        $totalConsumos = 0;
        foreach ($itens as $item) {
            $totalConsumos += $item->quantidade * $item->valorUnitario;
        }

        // Atualizar valor total da conta
        $db->update('conta', ['valorTotal' => $totalConsumos], 'id', $idConta);

        return json_encode([
            'status'   => 'success',
            'consumos' => $itens,
            'total'    => $totalConsumos
        ]);
    }
}
