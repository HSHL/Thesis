-- phpMyAdmin SQL Dump
-- version 4.6.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 28. Mai 2016 um 19:19
-- Server-Version: 5.6.24
-- PHP-Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `thesis`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(11) NOT NULL,
  `publish_date` date NOT NULL,
  `finish_date` date NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL,
  `advisor_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `topics`
--

INSERT INTO `topics` (`topic_id`, `publish_date`, `finish_date`, `title`, `description`, `status`, `advisor_id`, `student_id`) VALUES
(1, '2016-05-01', '0000-00-00', 'BitCoin', '<p>BitCoin ist eine digitale WÃ¤hrung, ohne zentrale Kontrollinstanz. Transaktionen werden in einem offenen Peer-to-Peer-Netzwerk abgebildet. Es kommen verschiedene VerschlÃ¼sselungsverfahren zum Einsatz.\r\nIn der Arbeit soll ein technischer Ãœberblick Ã¼ber BitCoin gegeben werden.\r\n</p><ul><li>Wie bekommt man Zugang zu BitCoins?</li><li>Wie entstehen TauschbÃ¶rsen zwischen z.B. â‚¬ und BitCoin?</li><li>Wie hat sich der Wert entwickelt?</li></ul>', 0, 1, 0),
(2, '2016-05-01', '0000-00-00', 'Aufblasbarer Kindersitz', '<p>Eltern von kleinen Kindern haben auf Reisen oft das Problem, dass vor Ort keine Kindersitze zur VerfÃ¼gung stehen (z.B. Taxifahrt, Leihwagen, â€¦).</p><p>\r\nEs ist anhand einer Marktuntersuchung festzustellen, ob aufblasbare Kindersitze eine reelle Marktchance hÃ¤tten. Dabei sollten in der Arbeit die folgenden Fragen bearbeitet werden:</p><ul><li>Wie groÃŸ ist der Markt?</li><li>Was darf ein solcher Sitz maximal kosten?</li><li>Sind bereits Produkte, Gebrauchsmuster oder Patente vorhanden?</li><li>Welche Regelungen mÃ¼ssten eingehalten werden?</li><li>Welche Zulassungsprozesse sind zu durchlaufen?</li><li>Wie kÃ¶nnte eine technische Realisierung aussehen?</li><li>Welche Vermarktungsstrategie ist denkbar?</li><li>Was sind potentielle Vertriebs- bzw. Herstellungspartner?</li></ul>', 0, 1, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(100) NOT NULL,
  `is_advisor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `email`, `password_hash`, `is_advisor`) VALUES
(1, 'Alexander', 'Stuckenholz', 'alexander.stuckenholz@hshl.de', '02bbf68f9d0d4e1d297420e664fdaf795bec132f8cedae37cdb75e95b5601559', 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
