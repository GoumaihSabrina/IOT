-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 30, 2025 alle 21:36
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iot_ambiente`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `previsioni`
--

CREATE TABLE `previsioni` (
  `id` int(11) NOT NULL,
  `citta` varchar(100) DEFAULT NULL,
  `data_previsione` date DEFAULT NULL,
  `temperatura_prevista` decimal(5,2) DEFAULT NULL,
  `temperatura_attuale` decimal(5,2) DEFAULT NULL,
  `umidita` decimal(5,2) DEFAULT NULL,
  `pm25` decimal(5,2) DEFAULT NULL,
  `pm10` decimal(5,2) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `rilevazioni`
--

CREATE TABLE `rilevazioni` (
  `id` int(11) NOT NULL,
  `temperatura` decimal(5,2) DEFAULT NULL,
  `qualita_aria` decimal(5,2) DEFAULT NULL,
  `umidita` decimal(5,2) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `previsioni`
--
ALTER TABLE `previsioni`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `rilevazioni`
--
ALTER TABLE `rilevazioni`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `previsioni`
--
ALTER TABLE `previsioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `rilevazioni`
--
ALTER TABLE `rilevazioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
