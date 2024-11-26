-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/11/2024 às 21:55
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
-- Banco de dados: `exe16mysql`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `descricao`) VALUES
(1, 'Esportes Aquáticos', 'Produtos relacionados a esportes e atividades aquáticas'),
(2, 'Eletrônicos', 'Dispositivos e equipamentos eletrônicos'),
(3, 'Vestuário', 'Roupas e acessórios'),
(4, 'Automotivo', 'Produtos e acessórios para veículos'),
(5, 'Esportes Aquáticos', 'Produtos relacionados a esportes e atividades aquáticas'),
(6, 'Eletrônicos', 'Dispositivos e equipamentos eletrônicos'),
(7, 'Vestuário', 'Roupas e acessórios'),
(8, 'Automotivo', 'Produtos e acessórios para veículos');

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cpf_cnpj` varchar(20) DEFAULT NULL,
  `rg` varchar(20) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL,
  `estado_civil` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `endereco`, `numero`, `bairro`, `cidade`, `estado`, `email`, `cpf_cnpj`, `rg`, `telefone`, `celular`, `data_nasc`, `salario`, `sexo`, `estado_civil`) VALUES
(8, 'Carlos Mendes', 'Rua da Paz', '345', 'Centro', 'São Paulo', 'SP', 'carlos.mendes@email.com', '123.456.789-10', 'MG-11.222.333', '11 3344-5566', '11 98765-4321', '1985-06-15', 5500.00, 'M', 'Casado'),
(9, 'Juliana Ferreira', 'Av. Principal', '678', 'Jardins', 'Curitiba', 'PR', 'juliana.ferreira@email.com', '987.654.321-00', 'PR-44.555.666', '41 2233-4455', '41 97654-3210', '1990-09-20', 4800.00, 'F', 'Solteiro'),
(10, 'Carlos Mendes', 'Rua da Paz', '345', 'Centro', 'São Paulo', 'SP', 'carlos.mendes@email.com', '123.456.789-10', 'MG-11.222.333', '11 3344-5566', '11 98765-4321', '1985-06-15', 5500.00, 'M', 'Casado'),
(11, 'Juliana Ferreira', 'Av. Principal', '678', 'Jardins', 'Curitiba', 'PR', 'juliana.ferreira@email.com', '987.654.321-00', 'PR-44.555.666', '41 2233-4455', '41 97654-3210', '1990-09-20', 4800.00, 'F', 'Solteiro'),
(12, 'Rafael Oliveira', 'Rua das Acácias', '250', 'Jardim América', 'Campinas', 'SP', 'rafael.oliveira@email.com', '456.789.123-45', 'SP-22.333.444', '19 3322-5544', '19 99876-5432', '1988-03-17', 6500.00, 'M', 'Casado'),
(13, 'Amanda Rodrigues', 'Av. Paulista', '1000', 'Bela Vista', 'São Paulo', 'SP', 'amanda.rodrigues@email.com', '789.012.345-67', 'SP-55.666.777', '11 4455-6677', '11 98765-1234', '1992-11-25', 4200.00, 'F', 'Solteiro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `forma_pagto`
--

CREATE TABLE `forma_pagto` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `nome` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `forma_pagto`
--

INSERT INTO `forma_pagto` (`id`, `data`, `nome`) VALUES
(3, '2024-11-25', 'crédito'),
(4, '2024-11-26', 'pix'),
(5, '2024-11-27', 'transferência bancária');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `id_item` int(11) NOT NULL,
  `qtde` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens_pedido`
--

INSERT INTO `itens_pedido` (`id_item`, `qtde`, `id_produto`, `id_pedido`) VALUES
(3, 10, 7, 40),
(4, 5, 5, 41);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `observacao` varchar(255) DEFAULT NULL,
  `forma_pagto` varchar(50) DEFAULT NULL,
  `prazo_entrega` date DEFAULT NULL,
  `id_vendedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `data`, `id_cliente`, `observacao`, `forma_pagto`, `prazo_entrega`, `id_vendedor`) VALUES
(40, '2024-11-26', 9, 'observações', '4', '2024-11-26', 10),
(41, '2024-11-26', 10, 'novo pedido', '3', '2024-11-26', 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `qtde_estoque` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `unidade_medida` varchar(45) NOT NULL,
  `promocao` char(1) DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id`, `nome`, `qtde_estoque`, `preco`, `unidade_medida`, `promocao`) VALUES
(5, 'Prancha de Surf', 0, 1599.00, '1', 'N'),
(6, 'Drone', 3, 3499.00, '1', 'N'),
(7, 'Camisa Polo', 10, 89.90, '1', 'S'),
(8, 'Pneu Michelin', 10, 499.00, '1', 'N'),
(9, 'Prancha de Surf', 5, 1599.00, '1', 'N'),
(10, 'Drone', 3, 3499.00, '1', 'N'),
(11, 'Camisa Polo', 20, 89.90, '1', 'S'),
(12, 'Pneu Michelin', 10, 499.00, '1', 'N'),
(13, 'Smartphone Galaxy', 15, 2999.00, '1', 'N'),
(14, 'Bicicleta Mountain Bike', 8, 1599.00, '1', 'S'),
(15, 'Notebook Dell', 10, 4799.00, '1', 'N'),
(16, 'Tênis de Corrida', 25, 299.90, '1', 'S');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendedor`
--

CREATE TABLE `vendedor` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `perc_comissa` decimal(5,2) DEFAULT NULL,
  `setor` varchar(50) DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vendedor`
--

INSERT INTO `vendedor` (`id`, `nome`, `endereco`, `cidade`, `estado`, `celular`, `email`, `perc_comissa`, `setor`, `sexo`) VALUES
(4, 'Maria Silva', 'Av. Paulista', 'São Paulo', 'SP', '11 98765-4321', 'maria.silva@empresa.com', 15.50, 'Eletrônicos', 'F'),
(5, 'João Santos', 'Rua Augusta', 'São Paulo', 'SP', '11 97654-3210', 'joao.santos@empresa.com', 18.00, 'Automotivo', 'M'),
(6, 'Ana Oliveira', 'Rua das Flores', 'Curitiba', 'PR', '41 96543-2109', 'ana.oliveira@empresa.com', 22.50, 'Esportes', 'F'),
(7, 'Pedro Souza', 'Av. Copacabana', 'Rio de Janeiro', 'RJ', '21 95432-1098', 'pedro.souza@empresa.com', 17.75, 'Vestuário', 'M'),
(8, 'Carlos Eduardo', 'Rua Principal', 'Belo Horizonte', 'MG', '31 94321-0987', 'carlos.eduardo@empresa.com', 20.25, 'Tecnologia', 'M'),
(9, 'Fernanda Costa', 'Av. Brasil', 'Salvador', 'BA', '71 93210-9876', 'fernanda.costa@empresa.com', 16.50, 'Vendas Externas', 'F'),
(10, 'Ricardo Almeida', 'Rua do Comércio', 'Porto Alegre', 'RS', '51 92109-8765', 'ricardo.almeida@empresa.com', 19.00, 'Varejo', 'M'),
(11, 'Maria Silva', 'Av. Paulista', 'São Paulo', 'SP', '11 98765-4321', 'maria.silva@empresa.com', 15.50, 'Eletrônicos', 'F'),
(12, 'João Santos', 'Rua Augusta', 'São Paulo', 'SP', '11 97654-3210', 'joao.santos@empresa.com', 18.00, 'Automotivo', 'M'),
(13, 'Ana Oliveira', 'Rua das Flores', 'Curitiba', 'PR', '41 96543-2109', 'ana.oliveira@empresa.com', 22.50, 'Esportes', 'F');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `forma_pagto`
--
ALTER TABLE `forma_pagto`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `id_produto` (`id_produto`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_vendedor` (`id_vendedor`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `vendedor`
--
ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `forma_pagto`
--
ALTER TABLE `forma_pagto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `vendedor`
--
ALTER TABLE `vendedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `itens_pedido_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id`),
  ADD CONSTRAINT `itens_pedido_ibfk_2` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`);

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`id_vendedor`) REFERENCES `vendedor` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
