<?php

namespace App\Controllers;

use App\Core\App;
require_once __DIR__ . '/../Libs/fpdf186/fpdf.php';
use FPDF;

class FinanceiroController
{
    // Página principal do financeiro
    public function index()
    {
        $db = App::get('database');
        $idFuncionario = $_SESSION['idFuncionario'] ?? 1;

        // Pega o último caixa do funcionário
        $caixas = $db->selectWhere('caixadiario', 'idFuncionario', $idFuncionario);
        $caixa = $caixas ? end($caixas) : null;

        $saldoInicial = 0;
        $saldoAtualCalculado = 0;
        $movimentacoes = [];

        // Data de hoje
        $hoje = date('Y-m-d');

        if ($caixa && $caixa->STATUS === 'ABERTO') {
            $saldoInicial = (float)$caixa->saldoInicial;

            // Movimentações do caixa abertas hoje
            $todosMovs = $db->selectWhere('movimentacaocaixa', 'idCaixaDiario', $caixa->id);
            foreach ($todosMovs as $m) {
                $dataMov = date('Y-m-d', strtotime($m->dataHora));
                if ($dataMov === $hoje) {
                    $movimentacoes[] = [
                        'descricao' => $m->descricao,
                        'tipo' => $m->tipo,
                        'valor' => (float)$m->valor,
                        'dataHora' => $m->dataHora
                    ];
                }
            }

            // Calcula saldo atual a partir das movimentações do caixa
            $entradasDia = 0;
            $saidasDia = 0;
            foreach ($movimentacoes as $m) {
                if ($m['tipo'] === 'ENTRADA') $entradasDia += $m['valor'];
                elseif ($m['tipo'] === 'SAIDA') $saidasDia += $m['valor'];
            }
            $saldoAtualCalculado = $saldoInicial + $entradasDia - $saidasDia;
        }

        return view('admin/financeiro', compact(
            'caixa',
            'saldoInicial',
            'saldoAtualCalculado',
            'movimentacoes'
        ));
    }

    // Abrir caixa
    public function abrirCaixa()
    {
        $dados = json_decode(file_get_contents('php://input'), true);
        $valorInicial = (float)($dados['valor'] ?? 0);
        $idFuncionario = $_SESSION['idFuncionario'] ?? 1;

        $campos = [
            'DATA' => date('Y-m-d H:i:s'),
            'saldoInicial' => $valorInicial,
            'saldoFinal' => $valorInicial,
            'STATUS' => 'ABERTO',
            'idFuncionario' => $idFuncionario
        ];

        try {
            $db = App::get('database');
            $caixas = $db->selectWhere('caixadiario', 'idFuncionario', $idFuncionario);
            $ultimoCaixa = $caixas ? end($caixas) : null;
            if ($ultimoCaixa && $ultimoCaixa->STATUS === 'ABERTO') {
                echo json_encode(['success' => false, 'message' => 'Já existe um caixa aberto. Feche-o antes de abrir outro.']);
                return;
            }

            $idCaixa = $db->insert('caixadiario', $campos);
            echo json_encode(['success' => true, 'valor' => $valorInicial, 'idCaixa' => $idCaixa]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Registrar sangria
    public function sangria()
    {
        $dados = json_decode(file_get_contents('php://input'), true);
        $valor = floatval($dados['valor'] ?? 0);
        $idFuncionario = $_SESSION['idFuncionario'] ?? 1;

        if ($valor <= 0) {
            echo json_encode(['success' => false, 'message' => 'Valor inválido']);
            return;
        }

        $db = App::get('database');
        $caixas = $db->selectWhere('caixadiario', 'idFuncionario', $idFuncionario);
        $caixa = $caixas ? end($caixas) : null;

        if (!$caixa || $caixa->STATUS !== 'ABERTO') {
            echo json_encode(['success' => false, 'message' => 'Nenhum caixa aberto']);
            return;
        }

        $campos = [
            'descricao' => 'Sangria',
            'tipo' => 'SAIDA',
            'valor' => $valor,
            'idCaixaDiario' => $caixa->id,
            'dataHora' => date('Y-m-d H:i:s')
        ];

        try {
            $db->insert('movimentacaocaixa', $campos);
            $caixaAtual = $db->selectWhere('caixadiario', 'id', $caixa->id)[0] ?? null;
            $novoSaldo = $caixaAtual ? ((float)$caixaAtual->saldoFinal - $valor) : ((float)$caixa->saldoFinal - $valor);
            $db->update('caixadiario', ['saldoFinal' => $novoSaldo], 'id', $caixa->id);
            echo json_encode(['success' => true, 'dataHora' => date('H:i')]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Fechar caixa
    public function fecharCaixa()
    {
        $db = App::get('database');
        $idFuncionario = $_SESSION['idFuncionario'] ?? 1;

        $caixas = $db->selectWhere('caixadiario', 'idFuncionario', $idFuncionario);
        $caixa = $caixas ? end($caixas) : null;

        if (!$caixa || $caixa->STATUS !== 'ABERTO') {
            echo json_encode(['success' => false, 'message' => 'Não há caixa aberto']);
            return;
        }

        $hoje = date('Y-m-d');

        // Movimentações do dia atual
        $movimentacoes = [];
        $todosMovs = $db->selectWhere('movimentacaocaixa', 'idCaixaDiario', $caixa->id);
        foreach ($todosMovs as $m) {
            if (date('Y-m-d', strtotime($m->dataHora)) === $hoje) {
                $movimentacoes[] = $m;
            }
        }

        // Contas pagas hoje que não estão contabilizadas
        $contas = $db->selectWhere('conta', 'STATUS', 'PAGA');
        foreach ($contas as $conta) {
            $dataPagamento = date('Y-m-d', strtotime($conta->dataPagamento ?? ''));
            $descricaoMov = "Pagamento Reserva #{$conta->idReserva}";
            $jaContabilizada = $db->selectWhere('movimentacaocaixa', 'descricao', $descricaoMov);
            if (!$jaContabilizada && $dataPagamento === $hoje) {
                $movimentacoes[] = (object)[
                    'descricao' => $descricaoMov,
                    'tipo' => 'ENTRADA',
                    'valor' => (float)$conta->valorTotal,
                    'dataHora' => $conta->dataPagamento
                ];
            }
        }

        // Calcula saldo final
        $entradas = 0;
        $saidas = 0;
        foreach ($movimentacoes as $m) {
            if ($m->tipo === 'ENTRADA') $entradas += (float)$m->valor;
            elseif ($m->tipo === 'SAIDA') $saidas += (float)$m->valor;
        }
        $saldoFinal = $caixa->saldoInicial + $entradas - $saidas;

        // Atualiza caixa como fechado
        $db->update('caixadiario', ['STATUS' => 'FECHADO', 'saldoFinal' => $saldoFinal], 'id', $caixa->id);

        // Gera PDF do dia atual
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Fechamento de Caixa', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(5);

        foreach ($movimentacoes as $m) {
            $pdf->Cell(0, 8, "{$m->descricao} | {$m->tipo} | R$ " . number_format($m->valor, 2, ',', '.'), 0, 1);
        }

        $pdfDir = __DIR__ . '/../../public/relatorios';
        if (!is_dir($pdfDir)) mkdir($pdfDir, 0777, true);
        $pdfPath = 'public/relatorios/caixa_' . date('Ymd_His') . '.pdf';
        $pdf->Output('F', __DIR__ . '/../../' . $pdfPath);

        echo json_encode(['success' => true, 'saldoFinal' => $saldoFinal, 'pdf' => $pdfPath]);
    }
}