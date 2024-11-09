-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.32-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para projeto
DROP DATABASE IF EXISTS `projeto`;
CREATE DATABASE IF NOT EXISTS `projeto` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `projeto`;

-- Copiando estrutura para tabela projeto.aso
DROP TABLE IF EXISTS `aso`;
CREATE TABLE IF NOT EXISTS `aso` (
  `idaso` int(11) NOT NULL AUTO_INCREMENT,
  `id_cand` int(11) DEFAULT NULL,
  `datacadastro` datetime DEFAULT NULL,
  `dataagenda` datetime DEFAULT NULL,
  `asoimg` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idaso`),
  KEY `aso_candidato` (`id_cand`),
  CONSTRAINT `aso_candidato` FOREIGN KEY (`id_cand`) REFERENCES `candidato` (`id_cand`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela projeto.aso: ~2 rows (aproximadamente)
DELETE FROM `aso`;
INSERT INTO `aso` (`idaso`, `id_cand`, `datacadastro`, `dataagenda`, `asoimg`, `status`) VALUES
	(5, 41, '1970-01-01 00:00:00', '2024-11-11 00:00:00', NULL, 'AG'),
	(6, 41, '2024-11-09 00:00:00', '2024-11-12 00:00:00', NULL, 'AG');

-- Copiando estrutura para tabela projeto.candidato
DROP TABLE IF EXISTS `candidato`;
CREATE TABLE IF NOT EXISTS `candidato` (
  `id_cand` int(11) NOT NULL AUTO_INCREMENT,
  `nome_cand` varchar(50) NOT NULL,
  `data_cad_cand` date NOT NULL,
  `data_nasc_cand` date NOT NULL,
  `sexo_cand` varchar(50) NOT NULL DEFAULT '',
  `telefone_cand` int(11) DEFAULT NULL,
  `celular_cand` int(11) DEFAULT NULL,
  `email_cand` varchar(50) NOT NULL,
  `status_cand` varchar(50) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_cand`),
  KEY `candidato_usuario` (`id`),
  CONSTRAINT `candidato_usuario` FOREIGN KEY (`id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela projeto.candidato: ~4 rows (aproximadamente)
DELETE FROM `candidato`;
INSERT INTO `candidato` (`id_cand`, `nome_cand`, `data_cad_cand`, `data_nasc_cand`, `sexo_cand`, `telefone_cand`, `celular_cand`, `email_cand`, `status_cand`, `id`) VALUES
	(41, 'Franciele dos Santos', '2024-10-30', '1988-01-01', 'F', 0, 0, 'franciele@gmail.com', 'Pendente', 32),
	(43, 'Bianca Marcelino', '2024-11-06', '1999-02-13', 'F', 0, 0, 'bianca@gmail.com', 'Pendente', 42),
	(44, 'Leonardo Damazio', '2024-11-06', '1987-01-11', 'M', 0, 0, 'leonardo@gmail.com', 'Pendente', 8),
	(45, 'Anderson da Silva', '2024-11-09', '2015-04-12', 'M', 0, 0, 'anderson@gmail.com', 'Pendente', 44);

-- Copiando estrutura para tabela projeto.dependentes
DROP TABLE IF EXISTS `dependentes`;
CREATE TABLE IF NOT EXISTS `dependentes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `certnasc` varchar(255) DEFAULT NULL,
  `nascdepimg` varchar(255) DEFAULT NULL,
  `nascdepdate` datetime DEFAULT NULL,
  `cartvac` varchar(255) DEFAULT NULL,
  `vacdepimg` varchar(255) DEFAULT NULL,
  `vacdepdate` datetime DEFAULT NULL,
  `idade` int(11) DEFAULT NULL,
  `id_cand` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `cand_dependente` (`id_cand`),
  CONSTRAINT `cand_dependente` FOREIGN KEY (`id_cand`) REFERENCES `candidato` (`id_cand`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

-- Copiando dados para a tabela projeto.dependentes: ~0 rows (aproximadamente)
DELETE FROM `dependentes`;

-- Copiando estrutura para tabela projeto.empresa
DROP TABLE IF EXISTS `empresa`;
CREATE TABLE IF NOT EXISTS `empresa` (
  `id_emp` int(11) NOT NULL AUTO_INCREMENT,
  `cnpj_emp` varchar(50) NOT NULL DEFAULT '',
  `nome_emp` varchar(50) NOT NULL,
  `email_emp` varchar(50) NOT NULL,
  `telefone_emp` int(11) NOT NULL,
  `nome_resp_emp` varchar(50) NOT NULL DEFAULT '',
  `tel_resp_emp` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_emp`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela projeto.empresa: ~10 rows (aproximadamente)
DELETE FROM `empresa`;
INSERT INTO `empresa` (`id_emp`, `cnpj_emp`, `nome_emp`, `email_emp`, `telefone_emp`, `nome_resp_emp`, `tel_resp_emp`) VALUES
	(1, '12526789000158', 'Sublime LTDA', 'administrativo@sublime.com.br', 2135356969, 'Raphael Souza', 2147483647),
	(3, '15254859000225', 'Atacadao S/A', 'administrativo@atacadao.com.br', 2136369878, 'Cristiano Meirelles', 2147483647),
	(4, '11222333000152', 'Mercado Sao Sebastiao LTDA', 'administrativo@sebastiao.com.br', 2136369878, 'Magda Nascimento', 2132158683),
	(5, '256632210002158', 'Mercado Vianense LTDA', 'administrativo@vianense.com.br', 2147483647, 'Jussara Freitas', 213535969),
	(6, '3265478900356', 'Magazine Luiza', 'administrativo@magalu.com.br', 2142165897, 'Antonio Maciel', 2142415689),
	(7, '42564874000316', 'Shopee S.A', 'administrativo@shopee.com.br', 2147483647, 'Carlos Magno', 2147483647),
	(8, '52465879000254', 'Casas Pedro LTDA', 'administrativo@casaspedro.com.br', 2147483647, 'Stephany Gomes', 2131349696),
	(9, '36546897000256', 'Renner S.A', 'administrativo@renner.com.br', 2121215456, 'Aparecida da Costa', 2121218987),
	(10, '54639963000158', 'Di Santinni S.A', 'administrativo@disantinni.com.br', 2136394845, 'Yuri Souza', 2124256363),
	(11, '36361456000217', 'Casas Bahia S.A', 'administrativo@casasbahia.com.br', 2124245663, 'Catia Malaquias', 2124258989),
	(12, '152564560000123', 'Natura S.A', 'administrativo@natura.com.br', 2131354747, 'Fernanda Costa', 2134789693),
	(13, '13741852000236', 'Hortifruti Zona Sul', 'administrativo@zonasul.com.br', 2145425252, 'Joao Marcos', 2145427885);

-- Copiando estrutura para tabela projeto.endereco
DROP TABLE IF EXISTS `endereco`;
CREATE TABLE IF NOT EXISTS `endereco` (
  `id_end` int(11) NOT NULL AUTO_INCREMENT,
  `cep` varchar(50) NOT NULL,
  `logradouro` varchar(50) NOT NULL,
  `numero` int(11) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `bairro` varchar(50) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `uf` varchar(50) NOT NULL,
  `id_cand` int(11) DEFAULT NULL,
  `id_emp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_end`),
  KEY `end_cand` (`id_cand`),
  KEY `end_emp` (`id_emp`),
  CONSTRAINT `end_cand` FOREIGN KEY (`id_cand`) REFERENCES `candidato` (`id_cand`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `end_emp` FOREIGN KEY (`id_emp`) REFERENCES `empresa` (`id_emp`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela projeto.endereco: ~4 rows (aproximadamente)
DELETE FROM `endereco`;
INSERT INTO `endereco` (`id_end`, `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `uf`, `id_cand`, `id_emp`) VALUES
	(19, '21330-300', 'Avenida Jambeiro', 12, '', 'Vila Valqueire', 'Rio de Janeiro', 'RJ', 41, NULL),
	(21, '21550-600', 'Rua Conde de Rezende', 12, 'A', 'Bento Ribeiro', 'Rio de Janeiro', 'RJ', 43, NULL),
	(22, '21330-300', 'Avenida Jambeiro', 115, 'Casa 1', 'Vila Valqueire', 'Rio de Janeiro', 'RJ', 44, NULL),
	(23, '23060-030', 'Rua Pocinhos', 0, 'Casa 101', 'Cosmos', 'Rio de Janeiro', 'RJ', 45, NULL);

-- Copiando estrutura para tabela projeto.ficha
DROP TABLE IF EXISTS `ficha`;
CREATE TABLE IF NOT EXISTS `ficha` (
  `idficha` int(11) NOT NULL AUTO_INCREMENT,
  `cpf` varchar(50) DEFAULT NULL,
  `cpfimg` varchar(200) DEFAULT NULL,
  `cpfdate` datetime DEFAULT NULL,
  `rg` varchar(50) DEFAULT NULL,
  `rgimg` varchar(200) DEFAULT NULL,
  `rgdate` datetime DEFAULT NULL,
  `cnh` varchar(50) DEFAULT NULL,
  `cnhimg` varchar(200) DEFAULT NULL,
  `cnhdate` datetime DEFAULT NULL,
  `ctps` varchar(50) DEFAULT NULL,
  `ctpsimg` varchar(200) DEFAULT NULL,
  `ctpsdate` datetime DEFAULT NULL,
  `compresid` varchar(50) DEFAULT NULL,
  `residimg` varchar(200) DEFAULT NULL,
  `residdate` datetime DEFAULT NULL,
  `compescol` varchar(50) DEFAULT NULL,
  `escolimg` varchar(200) DEFAULT NULL,
  `escoldate` datetime DEFAULT NULL,
  `certreserv` varchar(50) DEFAULT NULL,
  `reservimg` varchar(200) DEFAULT NULL,
  `reservdate` datetime DEFAULT NULL,
  `certnasc` varchar(50) DEFAULT NULL,
  `nascimg` varchar(200) DEFAULT NULL,
  `nascdate` datetime DEFAULT NULL,
  `id_cand` int(11) DEFAULT NULL,
  PRIMARY KEY (`idficha`) USING BTREE,
  KEY `ficha_candidato` (`id_cand`) USING BTREE,
  CONSTRAINT `FK_ficha_candidato` FOREIGN KEY (`id_cand`) REFERENCES `candidato` (`id_cand`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela projeto.ficha: ~2 rows (aproximadamente)
DELETE FROM `ficha`;
INSERT INTO `ficha` (`idficha`, `cpf`, `cpfimg`, `cpfdate`, `rg`, `rgimg`, `rgdate`, `cnh`, `cnhimg`, `cnhdate`, `ctps`, `ctpsimg`, `ctpsdate`, `compresid`, `residimg`, `residdate`, `compescol`, `escolimg`, `escoldate`, `certreserv`, `reservimg`, `reservdate`, `certnasc`, `nascimg`, `nascdate`, `id_cand`) VALUES
	(185, NULL, 'cpfimg_672f8d48ecf1d.pdf', NULL, NULL, 'rgimg_672f8d6245c15.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 41),
	(186, NULL, 'cpfimg_672f8d78c7ce9.pdf', NULL, NULL, 'rgimg_672f8e6dcbaa5.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 44);

-- Copiando estrutura para tabela projeto.usuario
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `situacao` tinyint(4) DEFAULT NULL,
  `dt_cadastro` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiracao` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela projeto.usuario: ~8 rows (aproximadamente)
DELETE FROM `usuario`;
INSERT INTO `usuario` (`id`, `nome`, `usuario`, `senha`, `email`, `nivel`, `situacao`, `dt_cadastro`, `reset_token`, `token_expiracao`) VALUES
	(8, 'Leonardo', 'leonardo', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'leonardo@gmail.com', 1, 1, '2024-10-08 00:00:00', NULL, NULL),
	(9, 'Filipe', 'filipe', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'filipe@gmail.com', 2, 1, '2024-10-08 00:00:00', NULL, NULL),
	(10, 'Bruno', 'bruno', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'bruno@gmail.com', 2, 1, '2024-10-08 00:00:00', NULL, NULL),
	(15, 'Alessandra', 'alessandra', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'alegomes.16@hotmail.com', 3, 1, '2024-10-18 14:40:09', '99cf2eda49b0ee99bdc7afe678460bb373b2e5481727f7fabbff5e9f4a76c4e029ad5178dbda214b56e75dada5f54d770ba8', '2024-10-18 20:35:17'),
	(32, 'Franciele', 'franciele', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'alegomes.16@hotmail.com', 1, 1, '2024-11-06 12:09:19', '23b6f7763acf0c0add1435b9ffe6f3af709880a0a4ced0ad0e07e09b087a8b2fa7711517e566f233222039b42b8dd88dfdc4', '2024-10-30 17:01:05'),
	(36, 'Rodrigo', 'rodrigo', '5f6955d227a320c7f1f6c7da2a6d96a851a8118f', 'alegomes.16@hotmail.com', 3, 1, '2024-11-05 16:34:23', NULL, NULL),
	(42, 'Bianca', 'bianca', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'bianca@gmail.com', 1, 1, '2024-11-05 20:31:40', NULL, NULL),
	(43, 'Clara', 'clara', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'clara@gmail.com', 3, 1, '2024-11-05 21:18:53', NULL, NULL),
	(44, 'Anderson da Silva', 'anderson', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'anderson@gmail.com', 1, 1, '2024-11-09 17:40:06', NULL, NULL);

-- Copiando estrutura para tabela projeto.vaga
DROP TABLE IF EXISTS `vaga`;
CREATE TABLE IF NOT EXISTS `vaga` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `descricao` varchar(50) NOT NULL DEFAULT '',
  `data` date NOT NULL,
  `status_vaga` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

-- Copiando dados para a tabela projeto.vaga: ~5 rows (aproximadamente)
DELETE FROM `vaga`;
INSERT INTO `vaga` (`id`, `nome`, `descricao`, `data`, `status_vaga`) VALUES
	(8, 'Tecnico de Informatica', 'Suporte e Manutencao', '2024-10-11', 'Andamento'),
	(10, 'Analista de RH', 'Controlar processos de admissÃ£o', '2024-10-14', 'Andamento'),
	(12, 'Gerente', 'Controlar operaÃ§Ã£o da loja', '2024-10-14', 'Andamento'),
	(13, 'Analista de Sistema', 'Criar programa para suporte', '2024-10-14', 'Andamento'),
	(14, 'Estagio de Administracao', 'Dar suporte ao setor', '2024-10-14', 'Andamento'),
	(15, 'Empilhador', 'Manusear equipamento', '2024-10-14', 'Andamento'),
	(16, 'Operador de Loja', 'Atendimento no balcao', '2024-11-06', 'Andamento');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
