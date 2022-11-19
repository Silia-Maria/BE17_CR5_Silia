-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 19. Nov 2022 um 16:58
-- Server-Version: 10.4.21-MariaDB
-- PHP-Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `BE17_CR5_animal_adoption_Silia`
--
CREATE DATABASE IF NOT EXISTS `BE17_CR5_animal_adoption_Silia` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `BE17_CR5_animal_adoption_Silia`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pets`
--

CREATE TABLE `pets` (
  `pet_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `age` int(3) NOT NULL,
  `description` varchar(255) NOT NULL,
  `size` int(3) NOT NULL,
  `vaccination` varchar(255) NOT NULL,
  `breed` varchar(255) NOT NULL DEFAULT 'Unknown',
  `status` varchar(255) NOT NULL DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `pets`
--

INSERT INTO `pets` (`pet_id`, `name`, `picture`, `location`, `age`, `description`, `size`, `vaccination`, `breed`, `status`) VALUES
(1, 'Benno', '63779639b6eba.jpg', 'Lindengasse 5', 8, 'Benno is a friendly, funny dog. He sleeps a lot and does not need looong walks.', 81, 'null', 'Beagle', ''),
(2, 'Lola', 'pet.jpg', 'Neubaugasse 20', 3, 'Lola is a cute Cat', 50, 'no', '', 'Available'),
(3, 'ronny', '6377aa996d47b.jpg', 'Tuplengasse 34', 4, 'He is really nice with kids and a perfect watch dog', 120, 'yes', 'German shepherd', 'Available'),
(4, 'Mick', '6377aad961119.jpg', 'Spittelauer Hauptstrasse 23', 10, 'Great cat', 40, 'yes', '', 'Available'),
(5, 'Emma', '6377ab18d3a94.jpg', 'Sechsschimmelgasse 1', 2, 'goood boy', 50, 'null', '', 'Available'),
(6, 'lordy', '6377ab452a10d.jpg', 'Sechsschimmelgasse 1', 2, 'Lordy loves to cuddle most of the time. sometimes she needs some alone time.', 40, 'null', '', 'Available'),
(7, 'maya', '6377ab7db8ccd.jpg', 'Lindengasse 3', 9, 'Good cat', 40, 'no', '', 'adopted'),
(8, 'Bob', '6377abab530b7.jpg', 'Lindengasse 3', 11, 'good boy', 100, 'yes', '', 'Available');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pet_adoption`
--

CREATE TABLE `pet_adoption` (
  `adoption_id` int(11) NOT NULL,
  `adoption_date` date NOT NULL,
  `fk_user_id` int(11) DEFAULT NULL,
  `fk_pet_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `pet_adoption`
--

INSERT INTO `pet_adoption` (`adoption_id`, `adoption_date`, `fk_user_id`, `fk_pet_id`) VALUES
(1, '2022-11-09', 2, 4),
(2, '2022-11-10', 3, 8),
(3, '2022-11-16', 4, 7);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `picture`, `password`, `status`) VALUES
(1, 'silia', 'cronauer', 'silia.maria@web.de', '+43660647893', 'praterstrasse 100', 'user.jpg', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'adm'),
(2, 'otto', 'wagner', 'otto.wagner@gmx.com', '+436697865809', 'wohllebengasse 5', 'user.jpg', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'user'),
(3, 'Anne', 'Last', 'Anne@gmail.com', '+43887098652', 'Blumengasse 5/12', '6377c2b57fd30.jpg', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'user'),
(4, 'lars', 'rudolph', 'lars@hotmail.com', '+439880084847', 'Praterstrasse 15', 'user.jpg', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'user');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`pet_id`);

--
-- Indizes für die Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD PRIMARY KEY (`adoption_id`),
  ADD KEY `fk_user_id` (`fk_user_id`),
  ADD KEY `fk_pet_id` (`fk_pet_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `pets`
--
ALTER TABLE `pets`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  MODIFY `adoption_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD CONSTRAINT `pet_adoption_ibfk_1` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `pet_adoption_ibfk_2` FOREIGN KEY (`fk_pet_id`) REFERENCES `pets` (`pet_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;