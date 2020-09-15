-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 15. sep 2020 ob 09.10
-- Različica strežnika: 10.4.14-MariaDB
-- Različica PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `evidenca`
--

-- --------------------------------------------------------

--
-- Struktura tabele `dijak`
--

CREATE TABLE `dijak` (
  `dijak_id` int(11) NOT NULL,
  `ime` varchar(20) NOT NULL,
  `priimek` varchar(30) NOT NULL,
  `razred_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Odloži podatke za tabelo `dijak`
--

INSERT INTO `dijak` (`dijak_id`, `ime`, `priimek`, `razred_id`, `username`, `password`) VALUES
(4, 'matic', 'tovornik', 1, 'matic3225', '12345678'),
(5, 'jože', 'strožer', 1, 'jozi', '12345678');

-- --------------------------------------------------------

--
-- Struktura tabele `ocena`
--

CREATE TABLE `ocena` (
  `ocena_id` int(11) NOT NULL,
  `ocena` int(1) NOT NULL,
  `vrsta_ocene` varchar(10) NOT NULL,
  `komentar` text DEFAULT NULL,
  `obdobje` int(1) NOT NULL,
  `predmet_id` int(11) NOT NULL,
  `dijak_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Odloži podatke za tabelo `ocena`
--

INSERT INTO `ocena` (`ocena_id`, `ocena`, `vrsta_ocene`, `komentar`, `obdobje`, `predmet_id`, `dijak_id`) VALUES
(1, 5, 'pisna', NULL, 1, 1, 4),
(2, 4, 'ustna', NULL, 1, 2, 4),
(3, 4, 'pisna', NULL, 2, 2, 4),
(4, 3, 'izdelek', NULL, 1, 1, 5),
(5, 1, 'izdelek', NULL, 2, 2, 5),
(6, 1, 'zakljucena', NULL, 3, 1, 5);

-- --------------------------------------------------------

--
-- Struktura tabele `predmet`
--

CREATE TABLE `predmet` (
  `predmet_id` int(11) NOT NULL,
  `kratica` varchar(3) NOT NULL,
  `naziv_predmeta` varchar(40) NOT NULL,
  `profesor_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Odloži podatke za tabelo `predmet`
--

INSERT INTO `predmet` (`predmet_id`, `kratica`, `naziv_predmeta`, `profesor_id`) VALUES
(1, 'NUP', 'Napredna uporaba podatkovnih baz', 1),
(2, 'SMV', 'Stroka moderne vsebine', 1);

-- --------------------------------------------------------

--
-- Struktura tabele `predmet_razred`
--

CREATE TABLE `predmet_razred` (
  `predmet_razred_id` int(11) NOT NULL,
  `predmet_id` int(11) NOT NULL,
  `razred_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Odloži podatke za tabelo `predmet_razred`
--

INSERT INTO `predmet_razred` (`predmet_razred_id`, `predmet_id`, `razred_id`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Struktura tabele `profesor`
--

CREATE TABLE `profesor` (
  `profesor_id` int(11) NOT NULL,
  `ime` varchar(20) NOT NULL,
  `priimek` varchar(30) NOT NULL,
  `kabinet` varchar(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Odloži podatke za tabelo `profesor`
--

INSERT INTO `profesor` (`profesor_id`, `ime`, `priimek`, `kabinet`, `username`, `password`) VALUES
(1, 'Nejc', 'Rehar', 'Anus', 'nefi', '12345678');

-- --------------------------------------------------------

--
-- Struktura tabele `razred`
--

CREATE TABLE `razred` (
  `razred_id` int(11) NOT NULL,
  `razred` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Odloži podatke za tabelo `razred`
--

INSERT INTO `razred` (`razred_id`, `razred`) VALUES
(1, 'R4B');

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `dijak`
--
ALTER TABLE `dijak`
  ADD PRIMARY KEY (`dijak_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `razred_id` (`razred_id`);

--
-- Indeksi tabele `ocena`
--
ALTER TABLE `ocena`
  ADD PRIMARY KEY (`ocena_id`),
  ADD KEY `predmet_id` (`predmet_id`),
  ADD KEY `dijak_id` (`dijak_id`);

--
-- Indeksi tabele `predmet`
--
ALTER TABLE `predmet`
  ADD PRIMARY KEY (`predmet_id`),
  ADD KEY `profesor_id` (`profesor_id`);

--
-- Indeksi tabele `predmet_razred`
--
ALTER TABLE `predmet_razred`
  ADD PRIMARY KEY (`predmet_razred_id`),
  ADD KEY `predmet_id` (`predmet_id`),
  ADD KEY `razred_id` (`razred_id`);

--
-- Indeksi tabele `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`profesor_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeksi tabele `razred`
--
ALTER TABLE `razred`
  ADD PRIMARY KEY (`razred_id`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `dijak`
--
ALTER TABLE `dijak`
  MODIFY `dijak_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT tabele `ocena`
--
ALTER TABLE `ocena`
  MODIFY `ocena_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT tabele `predmet`
--
ALTER TABLE `predmet`
  MODIFY `predmet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT tabele `predmet_razred`
--
ALTER TABLE `predmet_razred`
  MODIFY `predmet_razred_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT tabele `profesor`
--
ALTER TABLE `profesor`
  MODIFY `profesor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT tabele `razred`
--
ALTER TABLE `razred`
  MODIFY `razred_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `dijak`
--
ALTER TABLE `dijak`
  ADD CONSTRAINT `dijak_ibfk_2` FOREIGN KEY (`razred_id`) REFERENCES `razred` (`razred_id`);

--
-- Omejitve za tabelo `ocena`
--
ALTER TABLE `ocena`
  ADD CONSTRAINT `ocena_ibfk_1` FOREIGN KEY (`predmet_id`) REFERENCES `predmet` (`predmet_id`),
  ADD CONSTRAINT `ocena_ibfk_2` FOREIGN KEY (`dijak_id`) REFERENCES `dijak` (`dijak_id`);

--
-- Omejitve za tabelo `predmet`
--
ALTER TABLE `predmet`
  ADD CONSTRAINT `predmet_ibfk_1` FOREIGN KEY (`profesor_id`) REFERENCES `profesor` (`profesor_id`);

--
-- Omejitve za tabelo `predmet_razred`
--
ALTER TABLE `predmet_razred`
  ADD CONSTRAINT `predmet_razred_ibfk_1` FOREIGN KEY (`predmet_id`) REFERENCES `predmet` (`predmet_id`),
  ADD CONSTRAINT `predmet_razred_ibfk_2` FOREIGN KEY (`razred_id`) REFERENCES `razred` (`razred_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
