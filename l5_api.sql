-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.7.36 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.4.0.6659
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para l5_api
DROP DATABASE IF EXISTS `l5_api`;
CREATE DATABASE IF NOT EXISTS `l5_api` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `l5_api`;

-- Copiando estrutura para tabela l5_api.clientes
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome_razao` varchar(255) NOT NULL,
  `cpf_cnpj` varchar(14) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela l5_api.clientes: ~10 rows (aproximadamente)
DELETE FROM `clientes`;
INSERT INTO `clientes` (`id`, `nome_razao`, `cpf_cnpj`, `created_at`, `updated_at`) VALUES
	(1, 'João Silva', '12345678901', '2024-06-22 02:12:20', NULL),
	(2, 'Maria Oliveira', '23456789012', '2024-06-22 02:12:20', NULL),
	(3, 'Empresa ABC Ltda', '12345678000190', '2024-06-22 02:12:20', NULL),
	(4, 'Carlos Pereira', '34567890123', '2024-06-22 02:12:20', NULL),
	(5, 'Ana Costa', '45678901234', '2024-06-22 02:12:20', NULL),
	(6, 'Empresa XYZ S.A.', '98765432000177', '2024-06-22 02:12:20', NULL),
	(7, 'Fernanda Lima', '56789012345', '2024-06-22 02:12:20', NULL),
	(8, 'José Santos', '67890123456', '2024-06-22 02:12:20', NULL),
	(9, 'Lucas Souza', '78901234567', '2024-06-22 02:12:20', NULL),
	(10, 'Carla Mota', '89012345678', '2024-06-22 02:12:20', NULL);

-- Copiando estrutura para tabela l5_api.pedidos
DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) unsigned NOT NULL,
  `id_produto` int(11) unsigned NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Em Aberto',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pedidos_id_produto_foreign` (`id_produto`),
  KEY `pedidos_id_cliente_foreign` (`id_cliente`),
  CONSTRAINT `pedidos_id_cliente_foreign` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `pedidos_id_produto_foreign` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela l5_api.pedidos: ~0 rows (aproximadamente)
DELETE FROM `pedidos`;
INSERT INTO `pedidos` (`id`, `id_cliente`, `id_produto`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'Em Aberto', '2024-06-22 02:12:20', NULL),
	(2, 2, 2, 'Cancelado', '2024-06-22 02:12:20', NULL),
	(3, 3, 3, 'Pago', '2024-06-22 02:12:20', NULL),
	(4, 4, 4, 'Pago', '2024-06-22 02:12:20', NULL),
	(5, 5, 5, 'Em Aberto', '2024-06-22 02:12:20', NULL);

-- Copiando estrutura para tabela l5_api.produtos
DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela l5_api.produtos: ~0 rows (aproximadamente)
DELETE FROM `produtos`;
INSERT INTO `produtos` (`id`, `nome`, `preco`, `created_at`, `updated_at`) VALUES
	(1, 'Caneta Azul', 1.00, '2024-06-22 02:12:20', NULL),
	(2, 'Caneta Preta', 2.50, '2024-06-22 02:12:20', NULL),
	(3, 'Caneta Verde', 3.00, '2024-06-22 02:12:20', NULL),
	(4, 'Caneta Vermelha', 4.50, '2024-06-22 02:12:20', NULL),
	(5, 'Caneta Roxa', 5.00, '2024-06-22 02:12:20', NULL);

-- Copiando estrutura para tabela l5_api.usuarios
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela l5_api.usuarios: ~0 rows (aproximadamente)
DELETE FROM `usuarios`;
INSERT INTO `usuarios` (`id`, `usuario`, `senha`) VALUES
	(1, 'admin', '$2y$10$vdP6eJ5FAQNN5dgTFrpd1uCTzrFiT8E1DaE6X1jtc240gGePmcBpW');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
