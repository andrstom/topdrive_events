-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Sob 18. čec 2020, 11:01
-- Verze serveru: 10.4.11-MariaDB
-- Verze PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `events`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `eventStartTime` int(11) NOT NULL,
  `eventStopTime` int(11) NOT NULL,
  `activity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `events`
--

INSERT INTO `events` (`id`, `eventStartTime`, `eventStopTime`, `activity`) VALUES
(3, 1594792800, 1594796400, 'snidane'),
(4, 1594796400, 1594800000, 'pauza'),
(5, 1594794600, 1594796400, 'kouka na video');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
