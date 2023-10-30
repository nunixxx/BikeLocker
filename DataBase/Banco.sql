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
  `cor` text NOT NULL,
  `cpf` Varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE `bikelocker`.`funcionario` (
  `CPF` Varchar(20) NOT NULL,
  `nome` text NOT NULL,
  `senha` text NOT NULL,
  `papel` text NOT NULL,
  `email` text NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `bikelocker`. `funcionario` (`CPF`, `nome`, `senha`, `papel`, `email`) VALUES
(11111111111, 'adm', '$2y$10$sQBza4MoQpAISgF.qJTfouOTpt3IWdFSfAknB5HDUt7arkEKvQRGa', 'adm', 'adm@gmail.com');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `bikelocker`.`usuario` (
  `CPF` Varchar(20) NOT NULL,
  `NOME` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `bicicletario`
--

CREATE TABLE IF NOT EXISTS `bikelocker`.`bicicletario` (
  `LOCKER` INT NOT NULL,
  `usuario_CPF` Varchar(20) NOT NULL,
  `CADEADO` TINYINT NOT NULL,
  `CHEGADA` DATETIME NOT NULL,
  `Bike_ID` INT(11) NOT NULL,
  PRIMARY KEY (`LOCKER`)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `historico`
--

  CREATE TABLE IF NOT EXISTS `bikelocker`.`historico` (
    `LOCKER` INT NOT NULL,
    `usuario_CPF` Varchar(20) NOT NULL,
    `CADEADO` TINYINT NOT NULL,
    `CHEGADA` DATETIME NOT NULL,
    `SAIDA` DATETIME NOT NULL,
    `BIKE_ID` INT(11) NOT NULL)
ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `bike`
--
ALTER TABLE `bikelocker`.`bike`
  ADD KEY `FK_Usuario_TO_Bike` (`CPF`),
  ADD PRIMARY KEY (`Id_Bike`);

--
-- Índices para tabela `funcionario`
--
ALTER TABLE `bikelocker`.`funcionario`
  ADD PRIMARY KEY (`CPF`);

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
-- Limitadores para a tabela `user_bike`
--
ALTER TABLE `bikelocker`.`bike`
  ADD CONSTRAINT `FK_Usuario_TO_Bike` FOREIGN KEY (`CPF`) REFERENCES `usuario` (`CPF`);

--
-- Limitadores para a tabela `bicicletarios`
--
ALTER TABLE `bikelocker`.`bicicletario`
  ADD CONSTRAINT `fk_Bicicletario_usuario1` FOREIGN KEY (`usuario_CPF`) REFERENCES `usuario` (`CPF`),
  ADD CONSTRAINT `fk_Bicicletario_bike` FOREIGN KEY (`bike_id`) REFERENCES `bike` (`ID_BIKE`);

--
-- Limitadores para a tabela `hitoricobicicletarios`
--
-- ALTER TABLE `bikelocker`.`historico`
  -- ADD CONSTRAINT `fk_hist_bicicletario_usuario1` FOREIGN KEY (`usuario_CPF`) REFERENCES `usuario` (`CPF`),
  -- ADD CONSTRAINT `fk_hist_Bicicletario_bike` FOREIGN KEY (`bike_id`) REFERENCES `bike` (`ID_BIKE`);

COMMIT;
