-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 22, 2019 at 09:46 PM
-- Server version: 5.7.26-0ubuntu0.18.04.1
-- PHP Version: 7.2.17-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `team`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `basename` varchar(255) DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `delimiter` varchar(5) NOT NULL,
  `type` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `basename`, `filename`, `delimiter`, `type`, `created_at`) VALUES
(1, 'first-test-csv.csv', 'file/output_d1a064322d1dd321c3c67ea35372cf2e.csv', ';', 1, '2019-05-22 11:49:43'),
(2, 'second-test-csv.csv', 'file/a749a7d85c9e43519dd50167a3f1d988.csv', ';', 2, '2019-05-22 12:02:19'),
(3, 'studenti.csv', 'file/output_5f8475e4000ecd9051d1ea3c1d5babb0.csv', ';', 1, '2019-05-22 19:05:45'),
(4, '1993-1994.csv', 'file/output_2998d3762917854de6efbc18698cc710.csv', ';', 1, '2019-05-22 19:06:15'),
(5, 'WEBTECH.csv', 'file/output_62a8bc7cfee68ed8f84316eac32b4207.csv', ';', 1, '2019-05-22 19:06:35'),
(6, 'virtual-server.csv', 'file/output_17101638c95c8a4d8e4b286ea94c792c.csv', ';', 1, '2019-05-22 19:07:17'),
(7, 'zoznam-studentov.csv', 'file/c3a351fe0851ce3669159b13ba914b79.csv', ';', 2, '2019-05-22 19:08:21'),
(8, 'zoznam-studentov.csv', 'file/395dde3ff8e2dfc9ce0dcefde644826c.csv', ';', 2, '2019-05-22 19:08:21');

-- --------------------------------------------------------

--
-- Table structure for table `files_types`
--

CREATE TABLE `files_types` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `files_types`
--

INSERT INTO `files_types` (`id`, `name`) VALUES
(1, 'First upload'),
(2, 'Second upload');

-- --------------------------------------------------------

--
-- Table structure for table `hodnotenie`
--

CREATE TABLE `hodnotenie` (
  `id` int(255) NOT NULL,
  `menostudenta` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
  `poznamka` text COLLATE utf8_slovak_ci NOT NULL,
  `id_infohodnotenie` int(11) NOT NULL,
  `rok` year(4) NOT NULL,
  `predmet` varchar(255) COLLATE utf8_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `hodnotenie`
--

INSERT INTO `hodnotenie` (`id`, `menostudenta`, `poznamka`, `id_infohodnotenie`, `rok`, `predmet`) VALUES
(80803, 'Selepova Adriana', '3;2;3;4;3;3;2;2;;2;1.25;6;6;8;14.9;16;73;D', 30, 2019, 'makacka'),
(90905, 'Chalupokova Zuzana', '3;2;3;4;3;3;2;2;;2;1.25;6;6;8;14.9;16;73;D', 30, 2019, 'makacka'),
(73703, 'Jozef Daxner', '3;2;3;4;3;3;2;2;;2;1.25;6;6;8;14.9;16;73;A', 30, 2019, 'makacka'),
(99999, 'Palo Habera', '3;2;3;4;3;3;2;2;;2;1.25;6;6;8;14.9;16;73;B', 30, 2019, 'makacka'),
(80803, 'Selepova Adriana', '3;2;3;4;3;3;2;2;;2;1.25;6;6;8;14.9;16;73;D', 31, 2018, 'webtr'),
(90905, 'Chalupokova Zuzana', '3;2;3;4;3;3;2;2;;2;1.25;6;6;8;14.9;16;73;D', 31, 2018, 'webtr'),
(73703, 'Jozef Daxner', '3;2;3;4;3;3;2;2;;2;1.25;6;6;8;14.9;16;73;A', 31, 2018, 'webtr'),
(99999, 'Palo Habera', '3;2;3;4;3;3;2;2;;2;1.25;6;6;8;14.9;16;73;B', 31, 2018, 'webtr');

-- --------------------------------------------------------

--
-- Table structure for table `infohodnotenie`
--

CREATE TABLE `infohodnotenie` (
  `zahlavie` text COLLATE utf8_slovak_ci NOT NULL,
  `idzahlavia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `infohodnotenie`
--

INSERT INTO `infohodnotenie` (`zahlavie`, `idzahlavia`) VALUES
('id;meno;cv1;cv2;cv3;cv4;cv5;cv6;cv7;cv8;c9;cv10;cv11;Z1;Z2;VT;SK-T;SK-P;Spolu;Znamka', 30),
('id;meno;cv1;cv2;cv3;cv4;cv5;cv6;cv7;cv8;c9;cv10;cv11;Z1;Z2;VT;SK-T;SK-P;Spolu;Znamka', 31);

-- --------------------------------------------------------

--
-- Table structure for table `localUsers`
--

CREATE TABLE `localUsers` (
  `id` int(11) NOT NULL COMMENT 'idstudenta',
  `username` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `localUsers`
--

INSERT INTO `localUsers` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$NBUYqUkbuE8fEZvwYxry4OQ6bLuLU0CMjG7rKmwd.JGhDurRK8HH2');

-- --------------------------------------------------------

--
-- Table structure for table `mail_log`
--

CREATE TABLE `mail_log` (
  `id` int(11) NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `template_type_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mail_log`
--

INSERT INTO `mail_log` (`id`, `recipient`, `template_type_id`, `subject`, `created_at`) VALUES
(1, 'xmarinic@is.stuba.sk', 1, 'From server', '2019-05-22 12:03:43'),
(2, 'xmarinic@stuba.sk', 1, 'From server', '2019-05-22 12:03:53'),
(3, 'dano.marinic@gmail.com', 1, 'From server', '2019-05-22 12:04:03'),
(4, 'dano.marinic@gmail.com', 1, 'From server', '2019-05-22 12:04:13'),
(5, 'xmarinic@is.stuba.sk', 1, 'From server', '2019-05-22 19:11:59'),
(6, 'xmarinic@stuba.sk', 1, 'From server', '2019-05-22 19:12:09'),
(7, 'dano.marinic@gmail.com', 1, 'From server', '2019-05-22 19:12:19'),
(8, 'dano.marinic@gmail.com', 1, 'From server', '2019-05-22 19:12:30');

-- --------------------------------------------------------

--
-- Table structure for table `mail_template`
--

CREATE TABLE `mail_template` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `text` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mail_template`
--

INSERT INTO `mail_template` (`id`, `name`, `type`, `text`, `created_at`) VALUES
(1, 'test-template', 1, 'Dobrý deň, \r\n\r\nna predmete Webové technológie 2 budete mať k dispozícii vlastný virtuálny linux server, ktorý budete používať počas semestra, a na ktorom budete vypracovávať zadania. Prihlasovacie údaje k Vašemu serveru su uvedené nižšie. \r\n\r\nip adresa: {{verejnaIP}} \r\nprihlasovacie meno: {{login}}\r\nheslo: {{heslo}} \r\n\r\nVaše web stránky budú dostupné na: http:// {{verejnaIP}}:{{http}} \r\n\r\n\r\nS pozdravom, {{sender}}', '2019-05-19 21:14:12'),
(2, 'html-test', 2, '<p>Dobrý deň, </p>\r\n<p>na predmete Webové technológie 2 budete mať k dispozícii vlastný virtuálny linux server, ktorý budete používať počas semestra, a na ktorom budete vypracovávať zadania. Prihlasovacie údaje k Vašemu serveru su uvedené nižšie.</p>\r\n<p><b>ip adresa:</b> {{verejnaIP}}<br>\r\n<b>prihlasovacie meno:</b> {{login}}<br>\r\n<b>heslo:</b> {{heslo}}</p>\r\n<p><b>Vaše web stránky budú dostupné na:</b> http:// {{verejnaIP}}:{{http}} </p><br>\r\n<p>S pozdravom, {{sender}}</p>', '2019-05-20 03:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `mail_template_type`
--

CREATE TABLE `mail_template_type` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mail_template_type`
--

INSERT INTO `mail_template_type` (`id`, `name`) VALUES
(1, 'text/plain'),
(2, 'text/html');

-- --------------------------------------------------------

--
-- Table structure for table `uloha2admin`
--

CREATE TABLE `uloha2admin` (
  `autoID` int(255) NOT NULL,
  `id` int(11) NOT NULL,
  `meno` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `heslo` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `tim` int(2) DEFAULT NULL,
  `body` int(2) DEFAULT NULL,
  `rok` int(4) DEFAULT NULL,
  `predmet` varchar(10) COLLATE utf8_slovak_ci DEFAULT NULL,
  `rozdelenie` int(255) DEFAULT NULL,
  `suhlas` varchar(255) COLLATE utf8_slovak_ci DEFAULT NULL,
  `suhlasAdmin` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Dumping data for table `uloha2admin`
--

INSERT INTO `uloha2admin` (`autoID`, `id`, `meno`, `email`, `heslo`, `tim`, `body`, `rok`, `predmet`, `rozdelenie`, `suhlas`, `suhlasAdmin`) VALUES
(247, 86308, 'Hrebeňák Martin', 'xhrebenak@is.stuba.sk', NULL, 22, 60, 1819, 'webte2', 10, 'nie', NULL),
(249, 85944, 'Mariniè Daniel', 'xmarinic@is.stuba.sk', NULL, 22, 60, 1819, 'webte2', 10, NULL, NULL),
(250, 80803, 'Selepová Adriána', 'xselepova@is.stuba.sk', NULL, 22, 60, 1819, 'webte2', 10, 'ano', NULL),
(251, 79987, 'Martin Komorny', 'xkomornym@is.stuba.sk', NULL, 22, 60, 1819, 'webte2', 15, NULL, NULL),
(252, 66666, 'Satan Diabol', 'xdevilqo@is.stuba.sk', NULL, 21, 100, 1819, 'webte2', NULL, NULL, NULL),
(253, 33333, 'Bird Control', 'xstahp@is.stuba.sk', NULL, 21, 100, 1819, 'webte2', NULL, NULL, NULL),
(254, 22222, ' Iron Man', ' XtonoStark@is.stuba.sk', NULL, 21, 100, 1819, 'webte2', NULL, NULL, NULL),
(255, 11111, 'Chesus Kristo', 'xgeezs@is.stuba.sk', NULL, 21, 100, 1819, 'webte2', NULL, NULL, NULL),
(7248, 86187, 'Chalupková Zuzana', 'xchalupkovaz@is.stuba.sk', NULL, 22, 60, 1819, 'webte2', 15, 'ano', NULL),
(7249, 86187, 'Chalupková Zuzana', 'xchalupkovaz@is.stuba.sk', NULL, 21, 60, 1718, 'webte2', 60, 'ano', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `files_types`
--
ALTER TABLE `files_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hodnotenie`
--
ALTER TABLE `hodnotenie`
  ADD KEY `idzahlavia` (`id_infohodnotenie`);

--
-- Indexes for table `infohodnotenie`
--
ALTER TABLE `infohodnotenie`
  ADD PRIMARY KEY (`idzahlavia`);

--
-- Indexes for table `localUsers`
--
ALTER TABLE `localUsers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_log`
--
ALTER TABLE `mail_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `template_type_id` (`template_type_id`);

--
-- Indexes for table `mail_template`
--
ALTER TABLE `mail_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_template_type`
--
ALTER TABLE `mail_template_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uloha2admin`
--
ALTER TABLE `uloha2admin`
  ADD PRIMARY KEY (`autoID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `files_types`
--
ALTER TABLE `files_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `infohodnotenie`
--
ALTER TABLE `infohodnotenie`
  MODIFY `idzahlavia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `localUsers`
--
ALTER TABLE `localUsers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'idstudenta', AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `mail_log`
--
ALTER TABLE `mail_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `mail_template`
--
ALTER TABLE `mail_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `mail_template_type`
--
ALTER TABLE `mail_template_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `uloha2admin`
--
ALTER TABLE `uloha2admin`
  MODIFY `autoID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7250;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `hodnotenie`
--
ALTER TABLE `hodnotenie`
  ADD CONSTRAINT `hodnotenie_ibfk_1` FOREIGN KEY (`id_infohodnotenie`) REFERENCES `infohodnotenie` (`idzahlavia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mail_log`
--
ALTER TABLE `mail_log`
  ADD CONSTRAINT `mail_log_ibfk_1` FOREIGN KEY (`template_type_id`) REFERENCES `mail_template_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
