-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/01/2026 às 16:49
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `pousada_pedra_talhada_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `caixadiario`
--

CREATE TABLE `caixadiario` (
  `id` int(11) NOT NULL,
  `DATA` datetime DEFAULT NULL,
  `saldoInicial` decimal(10,2) DEFAULT NULL,
  `saldoFinal` decimal(10,2) DEFAULT NULL,
  `STATUS` enum('ABERTO','FECHADO') DEFAULT NULL,
  `idFuncionario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `caixadiario`
--

INSERT INTO `caixadiario` (`id`, `DATA`, `saldoInicial`, `saldoFinal`, `STATUS`, `idFuncionario`) VALUES
(1, '2026-01-22 13:08:05', 200.00, 1584.00, 'FECHADO', 1),
(2, '2026-01-22 13:18:28', 200.00, 200.00, 'FECHADO', 1),
(3, '2026-01-22 13:28:16', 200.00, 200.00, 'FECHADO', 1),
(4, '2026-01-22 13:33:53', 200.00, 200.00, 'FECHADO', 1),
(5, '2026-01-22 13:36:58', 200.00, 200.00, 'FECHADO', 1),
(6, '2026-01-22 13:56:36', 200.00, 200.00, 'FECHADO', 1),
(7, '2026-01-22 13:57:42', 200.00, 10450.50, 'FECHADO', 1),
(8, '2026-01-22 16:07:56', 200.00, 10450.50, 'FECHADO', 1),
(9, '2026-01-22 16:17:56', 200.00, 12232.50, 'FECHADO', 1),
(10, '2026-01-22 16:27:23', 200.00, 1784.00, 'FECHADO', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `conta`
--

CREATE TABLE `conta` (
  `id` int(11) NOT NULL,
  `valorTotal` decimal(10,2) DEFAULT NULL,
  `STATUS` enum('ABERTA','FECHADA','PAGA') DEFAULT NULL,
  `idReserva` int(11) DEFAULT NULL,
  `dataPagamento` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `conta`
--

INSERT INTO `conta` (`id`, `valorTotal`, `STATUS`, `idReserva`, `dataPagamento`) VALUES
(1, 1980.00, 'PAGA', 7, NULL),
(2, 1584.00, 'ABERTA', 8, NULL),
(3, 396.00, 'PAGA', 9, NULL),
(4, 1584.00, 'PAGA', 10, '2026-01-22 13:13:13'),
(5, 3080.00, 'PAGA', 11, NULL),
(6, 1386.00, 'PAGA', 12, NULL),
(7, 1782.00, 'PAGA', 13, NULL),
(8, 42.50, 'PAGA', 14, NULL),
(9, 1782.00, 'ABERTA', 15, NULL),
(10, 1782.00, 'PAGA', 16, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `STATUS` enum('ATIVO','INATIVO') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionario`
--

INSERT INTO `funcionario` (`id`, `id_usuario`, `nome`, `cpf`, `cargo`, `email`, `STATUS`) VALUES
(1, 1, 'Ana Carolina Junqueira', '000.000.000-00', 'Gerente', 'ana@email.com', 'ATIVO'),
(2, 2, 'Breno Reis Machado', NULL, 'Recepcionista', 'breno@email.com', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `hospede`
--

CREATE TABLE `hospede` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `observacoes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `hospede`
--

INSERT INTO `hospede` (`id`, `nome`, `cpf`, `email`, `telefone`, `observacoes`) VALUES
(1, 'Júlia Junqueira e Silva', '000.000.000-00', 'julia@gmail.com', '0000000000', 'Alergia a camarão'),
(2, 'Ana Carolina Junqueira', '000.000.000-01', 'ana@gmail.com', '0000000000', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itemconsumo`
--

CREATE TABLE `itemconsumo` (
  `id` int(11) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `valorUnitario` decimal(10,2) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `idConta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itemconsumo`
--

INSERT INTO `itemconsumo` (`id`, `descricao`, `valorUnitario`, `quantidade`, `idConta`) VALUES
(1, 'Cerveja', 8.50, 1, 1),
(3, 'Cerveja', 8.50, 1, 8),
(4, 'Cerveja', 8.50, 1, 8),
(5, 'Coca', 6.00, 1, 8),
(6, 'Ovo', 2.50, 1, 8),
(7, 'Cerveja', 8.50, 1, 8),
(8, 'Cerveja', 8.50, 1, 8),
(9, 'Cerveja', 8.50, 1, 10);

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacaocaixa`
--

CREATE TABLE `movimentacaocaixa` (
  `id` int(11) NOT NULL,
  `tipo` enum('ENTRADA','SAIDA') DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `dataHora` datetime DEFAULT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `idCaixaDiario` int(11) DEFAULT NULL,
  `idConta` int(11) DEFAULT NULL,
  `idFuncionario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `movimentacaocaixa`
--

INSERT INTO `movimentacaocaixa` (`id`, `tipo`, `valor`, `dataHora`, `descricao`, `idCaixaDiario`, `idConta`, `idFuncionario`) VALUES
(1, 'SAIDA', 200.00, '2026-01-22 13:13:27', 'Sangria', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `quarto`
--

CREATE TABLE `quarto` (
  `numero` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `precoDiaria` decimal(10,2) DEFAULT NULL,
  `STATUS` enum('DISPONIVEL','OCUPADO','MANUTENCAO') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `quarto`
--

INSERT INTO `quarto` (`numero`, `tipo`, `precoDiaria`, `STATUS`) VALUES
(101, 'Standard', 180.00, 'DISPONIVEL'),
(102, 'Standard', 180.00, 'DISPONIVEL'),
(103, 'Standard', 180.00, 'DISPONIVEL'),
(104, 'Standard', 180.00, 'DISPONIVEL'),
(105, 'Standard', 180.00, 'DISPONIVEL'),
(201, 'Luxo', 250.00, 'DISPONIVEL'),
(202, 'Luxo', 250.00, 'DISPONIVEL'),
(203, 'Luxo', 250.00, 'DISPONIVEL'),
(204, 'Luxo', 250.00, 'DISPONIVEL'),
(205, 'Luxo', 250.00, 'DISPONIVEL'),
(301, 'Suíte', 350.00, 'DISPONIVEL'),
(302, 'Suíte', 350.00, 'DISPONIVEL'),
(303, 'Suíte', 350.00, 'DISPONIVEL'),
(304, 'Luxo', 350.00, 'DISPONIVEL'),
(305, 'Suíte', 350.00, 'DISPONIVEL');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reserva`
--

CREATE TABLE `reserva` (
  `id` int(11) NOT NULL,
  `dataEntradaPrevista` datetime DEFAULT NULL,
  `dataSaidaPrevista` datetime DEFAULT NULL,
  `dataCheckin` datetime DEFAULT NULL,
  `dataCheckout` datetime DEFAULT NULL,
  `STATUS` enum('RESERVADA','HOSPEDADA','FINALIZADA','CANCELADA') DEFAULT NULL,
  `idQuarto` int(11) NOT NULL,
  `idHospede` int(11) NOT NULL,
  `idFuncionario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `reserva`
--

INSERT INTO `reserva` (`id`, `dataEntradaPrevista`, `dataSaidaPrevista`, `dataCheckin`, `dataCheckout`, `STATUS`, `idQuarto`, `idHospede`, `idFuncionario`) VALUES
(7, '2026-01-21 00:00:00', '2026-01-31 00:00:00', '2026-01-21 22:13:35', '2026-01-22 13:08:13', 'FINALIZADA', 101, 1, NULL),
(8, '2026-02-18 14:00:00', '2026-02-26 12:00:00', NULL, NULL, 'CANCELADA', 102, 1, NULL),
(9, '2026-01-22 14:00:00', '2026-01-24 12:00:00', '2026-01-22 13:08:51', '2026-01-22 13:08:53', 'FINALIZADA', 101, 1, NULL),
(10, '2026-01-22 14:00:00', '2026-01-30 12:00:00', '2026-01-22 13:11:55', '2026-01-22 13:13:13', 'FINALIZADA', 101, 1, NULL),
(11, '2026-01-23 14:00:00', '2026-01-31 12:00:00', '2026-01-22 13:28:39', '2026-01-22 13:28:51', 'FINALIZADA', 302, 1, NULL),
(12, '2026-01-22 14:00:00', '2026-01-29 12:00:00', '2026-01-22 13:58:43', '2026-01-22 13:58:45', 'FINALIZADA', 101, 1, NULL),
(13, '2026-01-22 14:00:00', '2026-01-31 12:00:00', '2026-01-22 14:06:19', '2026-01-22 14:06:24', 'FINALIZADA', 101, 1, NULL),
(14, '2026-01-22 14:00:00', '2026-01-31 12:00:00', '2026-01-22 14:19:17', '2026-01-22 15:18:31', 'FINALIZADA', 102, 1, NULL),
(15, '2026-01-22 14:00:00', '2026-01-31 12:00:00', NULL, NULL, 'CANCELADA', 105, 2, NULL),
(16, '2026-01-22 14:00:00', '2026-01-31 12:00:00', '2026-01-22 16:18:37', '2026-01-22 16:18:51', 'FINALIZADA', 101, 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `login`, `senha`) VALUES
(1, 'ana202335002', '123'),
(2, 'breno202376025', '123');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `caixadiario`
--
ALTER TABLE `caixadiario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idFuncionario` (`idFuncionario`);

--
-- Índices de tabela `conta`
--
ALTER TABLE `conta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idReserva` (`idReserva`);

--
-- Índices de tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `hospede`
--
ALTER TABLE `hospede`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `itemconsumo`
--
ALTER TABLE `itemconsumo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idConta` (`idConta`);

--
-- Índices de tabela `movimentacaocaixa`
--
ALTER TABLE `movimentacaocaixa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCaixaDiario` (`idCaixaDiario`),
  ADD KEY `idConta` (`idConta`),
  ADD KEY `idFuncionario` (`idFuncionario`);

--
-- Índices de tabela `quarto`
--
ALTER TABLE `quarto`
  ADD PRIMARY KEY (`numero`);

--
-- Índices de tabela `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idQuarto` (`idQuarto`),
  ADD KEY `idHospede` (`idHospede`),
  ADD KEY `idFuncionario` (`idFuncionario`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `caixadiario`
--
ALTER TABLE `caixadiario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `conta`
--
ALTER TABLE `conta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `hospede`
--
ALTER TABLE `hospede`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `itemconsumo`
--
ALTER TABLE `itemconsumo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `movimentacaocaixa`
--
ALTER TABLE `movimentacaocaixa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `caixadiario`
--
ALTER TABLE `caixadiario`
  ADD CONSTRAINT `caixadiario_ibfk_1` FOREIGN KEY (`idFuncionario`) REFERENCES `funcionario` (`id`);

--
-- Restrições para tabelas `conta`
--
ALTER TABLE `conta`
  ADD CONSTRAINT `conta_ibfk_1` FOREIGN KEY (`idReserva`) REFERENCES `reserva` (`id`);

--
-- Restrições para tabelas `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `funcionario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Restrições para tabelas `itemconsumo`
--
ALTER TABLE `itemconsumo`
  ADD CONSTRAINT `itemconsumo_ibfk_1` FOREIGN KEY (`idConta`) REFERENCES `conta` (`id`);

--
-- Restrições para tabelas `movimentacaocaixa`
--
ALTER TABLE `movimentacaocaixa`
  ADD CONSTRAINT `movimentacaocaixa_ibfk_1` FOREIGN KEY (`idCaixaDiario`) REFERENCES `caixadiario` (`id`),
  ADD CONSTRAINT `movimentacaocaixa_ibfk_2` FOREIGN KEY (`idConta`) REFERENCES `conta` (`id`),
  ADD CONSTRAINT `movimentacaocaixa_ibfk_3` FOREIGN KEY (`idFuncionario`) REFERENCES `funcionario` (`id`);

--
-- Restrições para tabelas `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`idQuarto`) REFERENCES `quarto` (`numero`),
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`idHospede`) REFERENCES `hospede` (`id`),
  ADD CONSTRAINT `reserva_ibfk_3` FOREIGN KEY (`idFuncionario`) REFERENCES `funcionario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
