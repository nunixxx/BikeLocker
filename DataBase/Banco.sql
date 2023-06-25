CREATE DATABASE IF NOT EXISTS BikeLocker COLLATE = 'utf8_general_ci';

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `bikelocker`
--

-- --------------------------------------------------------


--
-- Estrutura da tabela `bike`
--

CREATE TABLE `bikelocker`.`bike` (
  `Id_Bike` int(11) NOT NULL,
  `Imagem` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cor`
--

CREATE TABLE `bikelocker`.`cor` (
  `CodCor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cor_bike`
--

CREATE TABLE `bikelocker`.`cor_bike` (
  `CodCor` int(11) NOT NULL,
  `Id_Bike` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE `bikelocker`.`funcionario` (
  `CPF` BIGINT(11) NOT NULL,
  `nome` text NOT NULL,
  `senha` text NOT NULL,
  `papel` text NOT NULL,
  `email` text NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_bike`
--

CREATE TABLE `bikelocker`.`user_bike` (
  `CPF` BIGINT(11) NOT NULL,
  `Id_Bike` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `bikelocker`.`usuario` (
  `CPF` BIGINT(11) NOT NULL,
  `NOME` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `bicicletario`
--

CREATE TABLE IF NOT EXISTS `bikelocker`.`bicicletario` (
  `LOCKER` INT NOT NULL,
  `usuario_CPF` BIGINT(11) NOT NULL,
  `CADEADO` TINYINT NOT NULL,
  `CHEGADA` DATE NOT NULL,
  PRIMARY KEY (`LOCKER`)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `historicoBicicletario`
--

CREATE TABLE IF NOT EXISTS `bikelocker`.`historicoBicicletario` (
  `DATACONSULTA` DATE NOT NULL,
  `LOCKER` INT NOT NULL,
  `usuario_CPF` BIGINT(11) NOT NULL,
  `CHEGADA` DATE NOT NULL,
  `SAIDA` DATE NOT NULL,
  PRIMARY KEY (`DATACONSULTA`))
ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `bike`
--
ALTER TABLE `bikelocker`.`bike`
  ADD PRIMARY KEY (`Id_Bike`);

--
-- Índices para tabela `cor`
--
ALTER TABLE `bikelocker`.`cor`
  ADD PRIMARY KEY (`CodCor`);

--
-- Índices para tabela `cor_bike`
--
ALTER TABLE `bikelocker`.`cor_bike`
  ADD KEY `FK_COR_TO_Cor_Bike` (`CodCor`),
  ADD KEY `FK_Bike_TO_Cor_Bike` (`Id_Bike`);

--
-- Índices para tabela `funcionario`
--
ALTER TABLE `bikelocker`.`funcionario`
  ADD PRIMARY KEY (`CPF`);

--
-- Índices para tabela `user_bike`
--
ALTER TABLE `bikelocker`.`user_bike`
  ADD KEY `FK_Usuario_TO_User_Bike` (`CPF`),
  ADD KEY `FK_Bike_TO_User_Bike` (`Id_Bike`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `bikelocker`.`usuario`
  ADD PRIMARY KEY (`CPF`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `bike`
--
ALTER TABLE `bikelocker`.`bike`
  MODIFY `Id_Bike` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `cor_bike`
--
ALTER TABLE `bikelocker`.`cor_bike`
  ADD CONSTRAINT `FK_Bike_TO_Cor_Bike` FOREIGN KEY (`Id_Bike`) REFERENCES `bike` (`Id_Bike`),
  ADD CONSTRAINT `FK_COR_TO_Cor_Bike` FOREIGN KEY (`CodCor`) REFERENCES `cor` (`CodCor`);

--
-- Limitadores para a tabela `user_bike`
--
ALTER TABLE `bikelocker`.`user_bike`
  ADD CONSTRAINT `FK_Bike_TO_User_Bike` FOREIGN KEY (`Id_Bike`) REFERENCES `bike` (`Id_Bike`),
  ADD CONSTRAINT `FK_Usuario_TO_User_Bike` FOREIGN KEY (`CPF`) REFERENCES `usuario` (`CPF`);

--
-- Limitadores para a tabela `bicicletarios`
--
ALTER TABLE `bikelocker`.`bicicletario`
  ADD CONSTRAINT `fk_Bicicletario_usuario1` FOREIGN KEY (`usuario_CPF`) REFERENCES `usuario` (`CPF`);

--
-- Limitadores para a tabela `hitoricobicicletarios`
--
ALTER TABLE `bikelocker`.`historicobicicletario`
  ADD CONSTRAINT `fk_hist_bicicletario_usuario1` FOREIGN KEY (`usuario_CPF`) REFERENCES `usuario` (`CPF`);


COMMIT;
