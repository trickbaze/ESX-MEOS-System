-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2023 at 03:41 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meos`
--

-- --------------------------------------------------------

--
-- Table structure for table `aangifte`
--

CREATE TABLE `aangifte` (
  `id` int(255) NOT NULL,
  `aangever_voornaam` varchar(255) NOT NULL,
  `aangever_achternaam` varchar(255) NOT NULL,
  `aangever_geslacht` varchar(255) NOT NULL,
  `pleegplaats` varchar(255) NOT NULL,
  `pleegdatum` varchar(255) NOT NULL,
  `pleegtijd` varchar(255) NOT NULL,
  `verbalisant` varchar(255) NOT NULL,
  `verklaring` text NOT NULL,
  `opnamedatum` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('open','closed','hold') NOT NULL DEFAULT 'open',
  `behandelaar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `aangifte_reacties`
--

CREATE TABLE `aangifte_reacties` (
  `id` int(255) NOT NULL,
  `aangifte` int(255) NOT NULL,
  `reactie` text NOT NULL,
  `author` varchar(50) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `anotitie`
--

CREATE TABLE `anotitie` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_activations`
--

CREATE TABLE `app_activations` (
  `id` int(255) NOT NULL,
  `userid` int(255) NOT NULL,
  `app_identifier` varchar(255) NOT NULL,
  `status` enum('active','banned') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `beslaglog`
--

CREATE TABLE `beslaglog` (
  `id` int(255) NOT NULL,
  `agent` varchar(255) NOT NULL DEFAULT '0',
  `burger` varchar(255) NOT NULL DEFAULT '0',
  `kenteken` varchar(255) NOT NULL DEFAULT '0',
  `voertuig` varchar(255) NOT NULL DEFAULT '0',
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(255) NOT NULL DEFAULT '0',
  `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cjib`
--

CREATE TABLE `cjib` (
  `id` int(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `steam` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `open` varchar(255) NOT NULL,
  `job` varchar(255) NOT NULL,
  `term` varchar(255) NOT NULL,
  `last_contact` varchar(255) NOT NULL,
  `reminded` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `owned_stuff` text NOT NULL,
  `owned_properties` text NOT NULL,
  `status` enum('open','wanted','closed') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `huiszoekinglog`
--

CREATE TABLE `huiszoekinglog` (
  `id` int(255) NOT NULL,
  `agent` varchar(255) NOT NULL DEFAULT '0',
  `burger` varchar(255) NOT NULL DEFAULT '0',
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(255) NOT NULL DEFAULT '0',
  `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `i8`
--

CREATE TABLE `i8` (
  `id` int(255) NOT NULL,
  `userid` int(255) NOT NULL,
  `datum_1` varchar(255) NOT NULL,
  `datum_2` varchar(255) NOT NULL,
  `plaats` varchar(255) NOT NULL,
  `omstandigheden` varchar(255) NOT NULL,
  `geweld_persoon` int(255) NOT NULL,
  `geweld_goed` int(255) NOT NULL,
  `letsel_betrokkene` int(255) NOT NULL,
  `letsel_betrokkene_onbekend` int(255) DEFAULT NULL,
  `letsel_betrokkene_gering` int(255) DEFAULT NULL,
  `letsel_betrokkene_ander` int(255) DEFAULT NULL,
  `ander_letsel` varchar(255) DEFAULT NULL,
  `andere_schade` varchar(255) DEFAULT NULL,
  `hovj_naam` varchar(255) DEFAULT NULL,
  `hovj_rang` varchar(255) DEFAULT NULL,
  `toegepast_traangas` int(255) DEFAULT NULL,
  `toegepast_diensthond` int(255) DEFAULT NULL,
  `toegepast_dienstvoertuig` int(255) DEFAULT NULL,
  `toegepast_fysiek` int(255) DEFAULT NULL,
  `toegepast_handboeien` int(255) DEFAULT NULL,
  `toegepast_stroomstootwapen` int(255) DEFAULT NULL,
  `toegepast_vuurwapen` int(255) DEFAULT NULL,
  `toegepast_wapenstok` int(255) DEFAULT NULL,
  `beoordeeld_door_id` int(255) DEFAULT NULL,
  `status` int(255) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `informatie`
--

CREATE TABLE `informatie` (
  `id` int(255) NOT NULL,
  `gameid` int(255) NOT NULL,
  `verbalisant` varchar(255) NOT NULL,
  `datum` varchar(255) NOT NULL,
  `notitie` text NOT NULL,
  `sanctie` varchar(255) NOT NULL,
  `gesignaleerd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invorderlog`
--

CREATE TABLE `invorderlog` (
  `id` int(255) NOT NULL,
  `agent` varchar(255) NOT NULL DEFAULT '0',
  `burger` varchar(255) NOT NULL DEFAULT '0',
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(255) NOT NULL DEFAULT '0',
  `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kladblok`
--

CREATE TABLE `kladblok` (
  `id` int(255) NOT NULL,
  `userid` int(255) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `livelog`
--

CREATE TABLE `livelog` (
  `id` int(255) NOT NULL,
  `agent` varchar(255) NOT NULL,
  `burger` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `burgerid` int(255) NOT NULL,
  `ip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pagevisitlog`
--

CREATE TABLE `pagevisitlog` (
  `id` int(255) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `_SERVER` longtext NOT NULL,
  `_SESSION` longtext NOT NULL,
  `_POST` longtext NOT NULL,
  `_GET` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rdwlog`
--

CREATE TABLE `rdwlog` (
  `id` int(255) NOT NULL,
  `voertuigid` int(255) NOT NULL DEFAULT 0,
  `reason` text DEFAULT NULL,
  `plate` varchar(255) DEFAULT NULL,
  `action` varchar(255) NOT NULL DEFAULT '0',
  `ip` varchar(255) NOT NULL DEFAULT '0',
  `user` int(255) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rdwwok`
--

CREATE TABLE `rdwwok` (
  `id` int(255) NOT NULL,
  `voertuigid` int(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recherche`
--

CREATE TABLE `recherche` (
  `id` int(255) NOT NULL,
  `rechercheur` varchar(255) NOT NULL,
  `notitie` text NOT NULL,
  `datum` datetime NOT NULL DEFAULT current_timestamp(),
  `burger` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shadow_rijbewijzen`
--

CREATE TABLE `shadow_rijbewijzen` (
  `id` int(255) NOT NULL,
  `rijbewijzen` text NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specialisaties`
--

CREATE TABLE `specialisaties` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `short` varchar(255) NOT NULL DEFAULT '0',
  `docent` varchar(255) NOT NULL DEFAULT '0',
  `toelatingsrangen` text DEFAULT NULL,
  `beloningspromotie` text DEFAULT NULL,
  `created_by` varchar(255) NOT NULL DEFAULT '0',
  `ip` varchar(255) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `specialisaties`
--

INSERT INTO `specialisaties` (`id`, `name`, `short`, `docent`, `toelatingsrangen`, `beloningspromotie`, `created_by`, `ip`, `created_on`, `updated_on`) VALUES
(200, 'Basis motorsurveillant', 'Motor', 'R. van Oosten', 'Agent,Hoofd Agent,Brigadier,Inspecteur,Hoofd Inspecteur,Commissaris,Hoofd Commissaris,1e Hoofd Commissaris', '0', '154', '84.106.148.24', '2019-05-05 14:45:46', '2020-01-31 19:07:10'),
(201, 'Team Verkeer', 'VPE', 'R. van Oosten', 'Agent,Hoofd Agent,Brigadier,Inspecteur,Hoofd Inspecteur,Commissaris,Hoofd Commissaris,1e Hoofd Commissaris', '0', '154', '84.106.148.24', '2019-05-05 14:49:29', '2020-01-31 19:07:17'),
(202, 'Luchtvaartpolitie', 'Zulu', 'R. van Oosten', 'Agent,Hoofd Agent,Brigadier,Inspecteur,Hoofd Inspecteur,Commissaris,Hoofd Commissaris,1e Hoofd Commissaris', '0', '154', '84.106.148.24', '2019-05-05 14:51:21', '2020-01-31 19:07:23'),
(203, 'Dienst Speciale Interventies', 'DSI', 'R. van Oosten', 'Agent,Hoofd Agent,Brigadier,Inspecteur,Hoofd Inspecteur,Commissaris,Hoofd Commissaris,1e Hoofd Commissaris', '0', '154', '84.106.148.24', '2019-05-05 14:52:22', '2020-01-31 19:07:29'),
(206, 'DSI (Stelsel Speciale Eenheden)', 'DSI-SSE', 'R. van Oosten', 'Agent,Hoofd Agent,Brigadier,Inspecteur,Hoofd Inspecteur,Commissaris,Hoofd Commissaris,1e Hoofd Commissaris', '0', '154', '84.106.148.24', '2019-05-05 14:54:45', '2020-01-31 19:08:03'),
(2, 'Surveillant', 'Surveillant', 'R. van Oosten', 'Aspirant', 'Surveillant', '217', '84.106.148.24', '2019-05-05 15:00:48', '2023-10-12 22:09:35'),
(3, 'Agent', 'Agent', 'R. van Oosten', 'Surveillant', 'Agent', '154', '84.106.148.24', '2019-05-05 15:02:33', '2020-01-31 19:06:46'),
(4, 'Hoofdagent', 'Hoofdagent', 'R. van Oosten', 'Agent', 'Hoofd Agent', '154', '84.106.148.24', '2019-05-05 15:03:25', '2020-01-31 19:06:48'),
(5, 'Brigadier', 'Brigadier', 'R. van Oosten', 'Hoofd Agent', 'Brigadier', '154', '84.106.148.24', '2019-05-05 15:03:43', '2020-01-31 19:06:55'),
(17, 'Inspecteur', 'Inspecteur', 'R. van Oosten', 'Brigadier', 'Inspecteur', '154', '84.106.148.24', '2019-05-05 15:04:12', '2019-10-21 17:19:43'),
(18, 'Hoofdinspecteur', 'Hoofdinspecteur', 'R. van Oosten', 'Inspecteur', 'Hoofd Inspecteur', '154', '84.106.148.24', '2019-05-05 15:04:52', '2019-10-21 17:19:43'),
(19, 'Commissaris', 'Commissaris', 'R. van Oosten', 'Hoofd Inspecteur', 'Commissaris', '154', '84.106.148.24', '2019-05-05 15:05:33', '2019-10-21 17:19:44'),
(20, 'Hoofdcommissaris', 'Hoofdcommissaris', 'R. van Oosten', 'Commissaris', 'Hoofd Commissaris', '154', '84.106.148.24', '2019-05-05 15:06:00', '2019-10-21 17:19:46'),
(21, '1e hoofdcommissaris', '1e hoofdcommissaris', 'R. van Oosten', 'Hoofd Commissaris', '1e Hoofd Commissaris', '154', '84.106.148.24', '2019-05-05 15:06:21', '2019-10-21 17:19:47'),
(205, 'IBT Docent', 'IBT', 'R. van Oosten', 'Inspecteur,Hoofd Inspecteur,Commissaris,Hoofd Commissaris,1e Hoofd Commissaris', '0', '154', '84.106.148.24', '2019-05-05 15:07:29', '2020-01-31 19:07:54'),
(1, 'Rijopleiding Initieel', 'ROI', 'R. van Oosten', 'Aspirant,Surveillant,Agent,Hoofd Agent,Brigadier,Inspecteur,Hoofd Inspecteur,Commissaris,Hoofd Commissaris,1e Hoofd Commissaris', '0', '154', '84.106.148.24', '2019-05-05 15:18:32', '2020-01-31 19:06:00');

-- --------------------------------------------------------

--
-- Table structure for table `specialisatie_aanmeldingen`
--

CREATE TABLE `specialisatie_aanmeldingen` (
  `id` int(255) NOT NULL,
  `specialisatie` int(255) NOT NULL,
  `user` int(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `specialisatie_aanmeldingen`
--

INSERT INTO `specialisatie_aanmeldingen` (`id`, `specialisatie`, `user`) VALUES
(34, 0, 222),
(33, 0, 221);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('inactive','active') NOT NULL,
  `role` enum('admin','om','anwb','user') NOT NULL,
  `rang` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `specialisaties` text DEFAULT NULL,
  `last_login` varchar(255) DEFAULT NULL,
  `2fa` varchar(255) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `trainer` tinyint(1) NOT NULL DEFAULT 0,
  `cjib` tinyint(1) NOT NULL DEFAULT 0,
  `pin` int(6) DEFAULT NULL,
  `app` enum('0','1') NOT NULL DEFAULT '0',
  `secKey` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `status`, `role`, `rang`, `name`, `specialisaties`, `last_login`, `2fa`, `salt`, `trainer`, `cjib`, `pin`, `app`, `secKey`) VALUES
(217, 'admin', '$2y$10$vO7ollg2FDdqvkHlGNXqZugjBID4jLAQrkQdMBkcdyzSyqsmdMs52', 'active', 'admin', '1e Hoofd Commissaris', 'D. Jansen', NULL, '15-10-2023', NULL, NULL, 1, 0, NULL, '0', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aangifte`
--
ALTER TABLE `aangifte`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aangifte_reacties`
--
ALTER TABLE `aangifte_reacties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index 1` (`id`);

--
-- Indexes for table `anotitie`
--
ALTER TABLE `anotitie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_activations`
--
ALTER TABLE `app_activations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app_identifier` (`app_identifier`);

--
-- Indexes for table `beslaglog`
--
ALTER TABLE `beslaglog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cjib`
--
ALTER TABLE `cjib`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number` (`number`);

--
-- Indexes for table `huiszoekinglog`
--
ALTER TABLE `huiszoekinglog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `i8`
--
ALTER TABLE `i8`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `informatie`
--
ALTER TABLE `informatie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invorderlog`
--
ALTER TABLE `invorderlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kladblok`
--
ALTER TABLE `kladblok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index 1` (`id`);

--
-- Indexes for table `livelog`
--
ALTER TABLE `livelog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pagevisitlog`
--
ALTER TABLE `pagevisitlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rdwlog`
--
ALTER TABLE `rdwlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rdwwok`
--
ALTER TABLE `rdwwok`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Index 2` (`voertuigid`);

--
-- Indexes for table `recherche`
--
ALTER TABLE `recherche`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shadow_rijbewijzen`
--
ALTER TABLE `shadow_rijbewijzen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specialisaties`
--
ALTER TABLE `specialisaties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Index 2` (`short`);

--
-- Indexes for table `specialisatie_aanmeldingen`
--
ALTER TABLE `specialisatie_aanmeldingen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aangifte`
--
ALTER TABLE `aangifte`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `aangifte_reacties`
--
ALTER TABLE `aangifte_reacties`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `anotitie`
--
ALTER TABLE `anotitie`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `app_activations`
--
ALTER TABLE `app_activations`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `beslaglog`
--
ALTER TABLE `beslaglog`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cjib`
--
ALTER TABLE `cjib`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `huiszoekinglog`
--
ALTER TABLE `huiszoekinglog`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `i8`
--
ALTER TABLE `i8`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `informatie`
--
ALTER TABLE `informatie`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `invorderlog`
--
ALTER TABLE `invorderlog`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kladblok`
--
ALTER TABLE `kladblok`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `livelog`
--
ALTER TABLE `livelog`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pagevisitlog`
--
ALTER TABLE `pagevisitlog`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rdwlog`
--
ALTER TABLE `rdwlog`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `rdwwok`
--
ALTER TABLE `rdwwok`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `recherche`
--
ALTER TABLE `recherche`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `specialisaties`
--
ALTER TABLE `specialisaties`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT for table `specialisatie_aanmeldingen`
--
ALTER TABLE `specialisatie_aanmeldingen`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
