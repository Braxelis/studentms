-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 14 avr. 2025 à 00:49
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `etudiant`
--

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `created_at`) VALUES
(2, 'CSI3-DLW', 'ANNEE 2024/2025', '2025-04-09 10:13:30'),
(3, 'CSI3-DLW', 'ANNEE 2024/2025', '2025-04-09 10:17:09'),
(5, 'qqwq', 'qwqwq', '2025-04-09 11:06:59');

-- --------------------------------------------------------

--
-- Structure de la table `group_students`
--

CREATE TABLE `group_students` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `AdminName` varchar(120) DEFAULT NULL,
  `UserName` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'Admin', 'admin', 8979555558, 'admin@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2025-01-01 04:36:52');

-- --------------------------------------------------------

--
-- Structure de la table `tblclass`
--

CREATE TABLE `tblclass` (
  `ID` int(5) NOT NULL,
  `ClassName` varchar(50) DEFAULT NULL,
  `Section` varchar(20) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `tblclass`
--

INSERT INTO `tblclass` (`ID`, `ClassName`, `Section`, `CreationDate`) VALUES
(13, 'CSI3-DLW', 'A', '2025-04-11 10:38:16'),
(14, 'CSI3-IRC', 'A', '2025-04-11 21:50:43'),
(15, 'ERIS4', 'A', '2025-04-11 21:51:00'),
(16, 'MS2D4', 'A', '2025-04-11 21:51:11');

-- --------------------------------------------------------

--
-- Structure de la table `tblhomework`
--

CREATE TABLE `tblhomework` (
  `id` int(11) NOT NULL,
  `homeworkTitle` mediumtext DEFAULT NULL,
  `classId` int(11) DEFAULT NULL,
  `homeworkDescription` longtext DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `lastDateofSubmission` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tblhomework`
--

INSERT INTO `tblhomework` (`id`, `homeworkTitle`, `classId`, `homeworkDescription`, `postingDate`, `lastDateofSubmission`) VALUES
(2, 'Test Title for homework', 1, 'This is for testing. This is for testing. This is for testing. This is for testing. This is for testing. This is for testing. ', '2024-12-31 10:26:56', '2024-12-08'),
(3, 'Test Homework Titlesssssss', 1, 'This is for testing. ', '2024-12-31 10:43:26', '2025-01-02'),
(4, 'Maths Home work', 1, 'Do the chapter 10', '2025-01-04 04:13:07', '2025-01-15'),
(5, 'cni', 13, 'cni', '2025-04-11 21:47:22', '2025-04-12'),
(6, 'BACCALAURÉAT ', 0, 'Diplôme du Baccalauréat ', '2025-04-12 11:37:31', '2025-04-12'),
(7, 'BACCALAURÉAT ', 13, 'Diplôme du baccalauréat ', '2025-04-12 11:38:39', '2025-04-22');

-- --------------------------------------------------------

--
-- Structure de la table `tblnotice`
--

CREATE TABLE `tblnotice` (
  `ID` int(5) NOT NULL,
  `NoticeTitle` mediumtext DEFAULT NULL,
  `ClassId` int(10) DEFAULT NULL,
  `NoticeMsg` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `NoticeFile` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `tblnotice`
--

INSERT INTO `tblnotice` (`ID`, `NoticeTitle`, `ClassId`, `NoticeMsg`, `CreationDate`, `NoticeFile`) VALUES
(7, 'Test Notice', 1, 'This is the test notice. This is the test notice. This is the test notice. This is the test notice. This is the test notice.', '2025-01-01 06:03:25', NULL),
(8, 'Winter Vacnation', 1, 'Winter vacation till 15 Jan 2025', '2025-01-04 04:12:07', NULL),
(9, 'Venez à l\'école', 13, 'dsqdfqsdqsd', '2025-04-12 11:13:59', NULL),
(10, 'Venez à l\'école', 13, 'dqsfdqsd', '2025-04-12 11:15:39', 'uploads/notices/1744456539_Student submit.png');

-- --------------------------------------------------------

--
-- Structure de la table `tblpage`
--

CREATE TABLE `tblpage` (
  `ID` int(10) NOT NULL,
  `PageType` varchar(200) DEFAULT NULL,
  `PageTitle` mediumtext DEFAULT NULL,
  `PageDescription` mediumtext DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `UpdationDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `tblpage`
--

INSERT INTO `tblpage` (`ID`, `PageType`, `PageTitle`, `PageDescription`, `Email`, `MobileNumber`, `UpdationDate`) VALUES
(1, 'aboutus', 'About Us', '<div style=\"text-align: start;\"><font color=\"#7b8898\" face=\"Mercury SSm A, Mercury SSm B, Georgia, Times, Times New Roman, Microsoft YaHei New, Microsoft Yahei, ????, ??, SimSun, STXihei, ????, serif\"><span style=\"font-size: 26px;\">Student Management System Developed using PHP and MySQL</span></font><br></div>', NULL, NULL, NULL),
(2, 'contactus', 'Contact Us', 'Logbessou, Douala', 'alumnidocs@test.com', 1234567890, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tblpublicnotice`
--

CREATE TABLE `tblpublicnotice` (
  `ID` int(5) NOT NULL,
  `NoticeTitle` varchar(200) DEFAULT NULL,
  `NoticeMessage` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tblstudent`
--

CREATE TABLE `tblstudent` (
  `ID` int(10) NOT NULL,
  `StudentName` varchar(200) DEFAULT NULL,
  `StudentEmail` varchar(200) DEFAULT NULL,
  `StudentClass` varchar(100) DEFAULT NULL,
  `Gender` varchar(50) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `StuID` varchar(200) DEFAULT NULL,
  `FatherName` mediumtext DEFAULT NULL,
  `MotherName` mediumtext DEFAULT NULL,
  `ContactNumber` bigint(10) DEFAULT NULL,
  `AltenateNumber` bigint(10) DEFAULT NULL,
  `Address` mediumtext DEFAULT NULL,
  `UserName` varchar(200) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `Image` varchar(200) DEFAULT NULL,
  `DateofAdmission` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `tblstudent`
--

INSERT INTO `tblstudent` (`ID`, `StudentName`, `StudentEmail`, `StudentClass`, `Gender`, `DOB`, `StuID`, `FatherName`, `MotherName`, `ContactNumber`, `AltenateNumber`, `Address`, `UserName`, `Password`, `Image`, `DateofAdmission`) VALUES
(7, 'KAMDEM', 'kamdem@gmail.com', '13', 'Male', '2017-01-01', 'kamdem', 'KAM', 'DEM', 123456789, 123456789, 'Logbessou', 'kamdem', '5aa3c7bb08d3c4c480d859ea16c3fcca', 'ed9d51ff16e10c35f839febf73db9b531744368172.png', '2025-04-11 10:42:52');

-- --------------------------------------------------------

--
-- Structure de la table `tbluploadedhomeworks`
--

CREATE TABLE `tbluploadedhomeworks` (
  `id` int(11) NOT NULL,
  `homeworkId` int(11) DEFAULT NULL,
  `studentId` int(11) DEFAULT NULL,
  `homeworkDescription` longtext DEFAULT NULL,
  `homeworkFile` varchar(255) DEFAULT NULL,
  `postinDate` timestamp NULL DEFAULT current_timestamp(),
  `adminRemark` mediumtext DEFAULT NULL,
  `adminRemarkDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbluploadedhomeworks`
--

INSERT INTO `tbluploadedhomeworks` (`id`, `homeworkId`, `studentId`, `homeworkDescription`, `homeworkFile`, `postinDate`, `adminRemark`, `adminRemarkDate`) VALUES
(1, 2, 4, 'upload', '869d2b4df212b9b55402b8fca8e28870.pdf', '2025-01-01 05:47:45', 'ok', '2025-01-01 09:44:36'),
(2, 4, 6, 'Done', 'a375fcfbcac4b897b4574fbd4003467d.pdf', '2025-01-04 04:13:46', NULL, NULL),
(3, 5, 7, 'cni', 'fccff373377f9f23bf4fae49348c12e8.pdf', '2025-04-11 21:48:11', NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `group_students`
--
ALTER TABLE `group_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `fk_group_id` (`group_id`);

--
-- Index pour la table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tblclass`
--
ALTER TABLE `tblclass`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tblhomework`
--
ALTER TABLE `tblhomework`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tblnotice`
--
ALTER TABLE `tblnotice`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tblpage`
--
ALTER TABLE `tblpage`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tblpublicnotice`
--
ALTER TABLE `tblpublicnotice`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `tbluploadedhomeworks`
--
ALTER TABLE `tbluploadedhomeworks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `group_students`
--
ALTER TABLE `group_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `tblclass`
--
ALTER TABLE `tblclass`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `tblhomework`
--
ALTER TABLE `tblhomework`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `tblnotice`
--
ALTER TABLE `tblnotice`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `tblpage`
--
ALTER TABLE `tblpage`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `tblpublicnotice`
--
ALTER TABLE `tblpublicnotice`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `tblstudent`
--
ALTER TABLE `tblstudent`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `tbluploadedhomeworks`
--
ALTER TABLE `tbluploadedhomeworks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
