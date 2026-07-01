<?php

namespace App\Core\Database;

use PDO;
use Exception;

class QueryBuilder
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // --------------------
    // Métodos genéricos
    // --------------------
    public function selectAll($table)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$table}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function insert($table, $parameters)
    {
        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($parameters);
            return $this->pdo->lastInsertId();
        } catch (Exception $e) {
            die('Erro ao inserir: ' . $e->getMessage());
        }
    }

    public function selectWhere($table, $column, $value)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE {$column} = :val");
        $stmt->execute(['val' => $value]);
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectWhereNot($table, $column, $value)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE {$column} != :val");
        $stmt->execute(['val' => $value]);
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function update($table, $parameters, $identifierColumn, $identifierValue)
    {
        $setClause = implode(', ', array_map(fn($col) => "{$col} = :{$col}", array_keys($parameters)));
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$identifierColumn} = :id_val";

        try {
            $stmt = $this->pdo->prepare($sql);
            $parameters['id_val'] = $identifierValue;
            $stmt->execute($parameters);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function delete($table, $id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$table} WHERE id = :id");
        try {
            $stmt->execute(['id' => $id]);
        } catch (Exception $e) {
            die('Erro ao excluir: ' . $e->getMessage());
        }
    }

    public function count($table)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM {$table} WHERE STATUS != 'CANCELADA'");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

    public function selectPaginated($table, $limit, $offset)
    {
        $sql = "SELECT * FROM {$table} WHERE STATUS != 'CANCELADA' ORDER BY dataEntradaPrevista DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    // --------------------
    // Métodos de login e usuário
    // --------------------
    public function verificaLogin($login, $senha)
    {
        // Login completo com funcionário e cargo
        $sql = "SELECT 
                    u.id AS id_usuario,
                    u.senha,
                    f.id AS id_funcionario,
                    f.nome,
                    f.cargo,
                    f.email
                FROM usuario u
                INNER JOIN funcionario f ON u.id = f.id_usuario
                WHERE u.login = :login AND f.STATUS = 'ATIVO'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':login', $login);
        $stmt->execute();

        $dadosUsuario = $stmt->fetch(PDO::FETCH_OBJ);

        if ($dadosUsuario && $dadosUsuario->senha == $senha) {
            return $dadosUsuario;
        }

        return false;
    }

    // --------------------
    // Métodos de reserva e quarto
    // --------------------
    public function existeConflitoReserva($idQuarto, $dataEntrada, $dataSaida)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM reserva
                WHERE idQuarto = :idQuarto
                  AND STATUS IN ('RESERVADA','HOSPEDADA')
                  AND dataEntradaPrevista < :dataSaida
                  AND dataSaidaPrevista > :dataEntrada";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'idQuarto' => $idQuarto,
            'dataEntrada' => $dataEntrada,
            'dataSaida' => $dataSaida
        ]);
        return $stmt->fetch(PDO::FETCH_OBJ)->total > 0;
    }

    public function quartosDisponiveisPorPeriodo($dataEntrada, $dataSaida)
    {
        $sql = "SELECT * FROM quarto
                WHERE STATUS = 'DISPONIVEL'
                  AND numero NOT IN (
                    SELECT idQuarto FROM reserva
                    WHERE STATUS IN ('RESERVADA','HOSPEDADA')
                      AND dataEntradaPrevista < :dataSaida
                      AND dataSaidaPrevista > :dataEntrada
                  )";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'dataEntrada' => $dataEntrada,
            'dataSaida' => $dataSaida
        ]);
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function countReservasAtivas()
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM reserva WHERE STATUS NOT IN ('CANCELADA','FINALIZADA')");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

    public function selectReservasAtivasPaginated($limit, $offset)
    {
        $sql = "SELECT * FROM reserva
                WHERE STATUS NOT IN ('CANCELADA','FINALIZADA')
                ORDER BY dataEntradaPrevista DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
}
