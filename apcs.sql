-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 31, 2024 at 03:51 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apcs`
--

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
CREATE TABLE IF NOT EXISTS `patients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Non-Binary','Other') NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `blood_type` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') DEFAULT NULL,
  `allergies` text,
  `medical_conditions` text,
  `current_medications` text,
  `family_medical_history` text,
  `emergency_contact_name` varchar(100) NOT NULL,
  `emergency_contact_relationship` varchar(50) NOT NULL,
  `emergency_contact_phone` varchar(20) NOT NULL,
  `insurance_provider` varchar(100) DEFAULT NULL,
  `insurance_policy_number` varchar(50) DEFAULT NULL,
  `doctor_assigned` varchar(100) DEFAULT NULL,
  `date_of_registration` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Active','Inactive','Deceased') NOT NULL DEFAULT 'Active',
  `profile_photo` varchar(255) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `last_updated_by` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `first_name`, `last_name`, `middle_name`, `date_of_birth`, `gender`, `email`, `phone_number`, `address`, `blood_type`, `allergies`, `medical_conditions`, `current_medications`, `family_medical_history`, `emergency_contact_name`, `emergency_contact_relationship`, `emergency_contact_phone`, `insurance_provider`, `insurance_policy_number`, `doctor_assigned`, `date_of_registration`, `status`, `profile_photo`, `created_by`, `last_updated_by`, `created_at`, `updated_at`) VALUES
(1, 'John', 'Doe', 'M', '1985-08-12', 'Male', 'john.doe@example.com', '123-456-7890', '123 Main St, Cityville, State', 'O+', 'Penicillin', 'Diabetes', 'Metformin', NULL, 'Jane Doe', 'Wife', '098-765-4321', 'HealthPlus', 'HP12345678', 'Dr. Smith', '2024-08-31 00:00:00', 'Active', NULL, NULL, NULL, '2024-08-31 22:46:28', '2024-08-31 22:46:28'),
(2, 'Jane', 'Smith', NULL, '1990-01-05', 'Female', 'jane.smith@example.com', '234-567-8901', '456 Elm St, Townsville, State', 'A-', NULL, 'Hypertension', 'Lisinopril', NULL, 'John Smith', 'Husband', '876-543-2109', 'HealthFirst', 'HF98765432', 'Dr. Johnson', '2024-08-31 00:00:00', 'Active', NULL, NULL, NULL, '2024-08-31 22:46:28', '2024-08-31 22:46:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(249) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `verified` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `resettable` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `roles_mask` int UNSIGNED NOT NULL DEFAULT '0',
  `registered` int UNSIGNED NOT NULL,
  `last_login` int UNSIGNED DEFAULT NULL,
  `force_logout` mediumint UNSIGNED NOT NULL DEFAULT '0',
  `user_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '../../img/user.png',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `username`, `status`, `verified`, `resettable`, `roles_mask`, `registered`, `last_login`, `force_logout`, `user_type`, `img`) VALUES
(7, 'admin@gmail.com', '$2y$10$S6NagfeHxdMviSh0kAq/YuylDPjx3EONiVdmb2vbUyy18K0kkkwfS', 'ADMIN', 0, 1, 1, 0, 1723705017, 1725114668, 0, 'Admin', '../../img/user.png');

-- --------------------------------------------------------

--
-- Table structure for table `users_2fa`
--

DROP TABLE IF EXISTS `users_2fa`;
CREATE TABLE IF NOT EXISTS `users_2fa` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `mechanism` tinyint UNSIGNED NOT NULL,
  `seed` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` int UNSIGNED NOT NULL,
  `expires_at` int UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_mechanism` (`user_id`,`mechanism`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_confirmations`
--

DROP TABLE IF EXISTS `users_confirmations`;
CREATE TABLE IF NOT EXISTS `users_confirmations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `email` varchar(249) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `selector` varchar(16) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `email_expires` (`email`,`expires`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_confirmations`
--

INSERT INTO `users_confirmations` (`id`, `user_id`, `email`, `selector`, `token`, `expires`) VALUES
(1, 1, 'benetez1998@gmail.com', 'LucVhlCfv-R2ptlF', '$2y$10$ifx2h0.YZ.qeTuAVIGsOKuvo5FjrStpRKZnHxSLg6caosZ/o2H.Ii', 1723791417),
(2, 2, 'teacher@gmail.com', 'sMeLGVU0dO_Rz_Z7', '$2y$10$3sA.jBIn31dMnkWyxoQSx.h/PdyjLR.unC31Ucxcx7P9FB/oJwaUO', 1724375787),
(3, 3, 'teacher2@gmail.com', 'K2i3UZGugolw8_Vt', '$2y$10$BJ.DEx/X6fG1Yb73wqEkEe/Z/k5ThGHEZqSo335/8aib.WWfK6M1K', 1724375822),
(4, 4, 'marbenbenetez@gmail.com', '22PXMYroVFNWoRCx', '$2y$10$R/m/M90T/Gn4mdNPNw05LuuA2YIco8D28ZcRLWn3Ak1j0XHwlGzfi', 1724467560),
(5, 5, 'oplokmuyong@gmail.com', 'wBAdhXfPZixGesk0', '$2y$10$veYQ8d9CpPf3Yxl6DUOWV.Q6.HuugsdTuh/f0ha.5A0UYQi5UQuKq', 1724471633),
(6, 6, 'dorisann04.mariano@gmail.com', 'FGRuNnr35aMHSkgq', '$2y$10$v13T/z1TW7M.8b8.HGroxu0JPAFjRKzt5qTTDFSRirgt4MC0CAI12', 1724485436),
(7, 8, 'oplokm@gmail.com', 'zvTThTIcKHac_OWE', '$2y$10$XJVklQTZEYtvbYctfKfTX.4tuLCaJsH0ZYBSROsYg9/kVEBNBj0Bi', 1724828739),
(8, 9, 'Faculty@gmail.com', 'tyufa_woxiag6zai', '$2y$10$AfiwDP.ozDPKCE12HdzxpuR/AnZ8IyNSugFVWVSdLZVhC3KKc6soi', 1724828856),
(9, 10, 'jomanasapalon157@gmail.com', '91c9DFUEv98spIPv', '$2y$10$J8gVBRFMHJpFFWG4jNixiOcaeWaVYvQSZ7UycsSZKQhFPoyZ4o866', 1724994143),
(10, 11, 'Sampleemail@gmail.com', 'HSF7R5hayBfPFeGq', '$2y$10$Y6F1Oxfkzmd.Sk08kl93h.Tg69Scw0adWN9YkOlsb8WNHNvR2s3hy', 1725003973);

-- --------------------------------------------------------

--
-- Table structure for table `users_otps`
--

DROP TABLE IF EXISTS `users_otps`;
CREATE TABLE IF NOT EXISTS `users_otps` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `mechanism` tinyint UNSIGNED NOT NULL,
  `single_factor` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `selector` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires_at` int UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_mechanism` (`user_id`,`mechanism`),
  KEY `selector_user_id` (`selector`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_profile`
--

DROP TABLE IF EXISTS `users_profile`;
CREATE TABLE IF NOT EXISTS `users_profile` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `student_id` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `course_year` varchar(255) DEFAULT NULL,
  `date_birth` date DEFAULT NULL,
  `date_inserted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users_profile`
--

INSERT INTO `users_profile` (`id`, `user_id`, `student_id`, `full_name`, `course_year`, `date_birth`, `date_inserted`) VALUES
(4, 1, '2023-001', 'Marben Benetez', 'BSIT - 1', '1998-08-29', '2024-08-30 12:48:08'),
(5, 4, '2024-1212', 'Ben Benetez', 'BSIT-1', '2021-07-05', '2024-08-30 13:00:43'),
(6, 11, '2021098', 'Sherjan Sample account', 'BSIT 4', '2003-09-13', '2024-08-30 13:02:27');

-- --------------------------------------------------------

--
-- Table structure for table `users_remembered`
--

DROP TABLE IF EXISTS `users_remembered`;
CREATE TABLE IF NOT EXISTS `users_remembered` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user` int UNSIGNED NOT NULL,
  `selector` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_resets`
--

DROP TABLE IF EXISTS `users_resets`;
CREATE TABLE IF NOT EXISTS `users_resets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user` int UNSIGNED NOT NULL,
  `selector` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `user_expires` (`user`,`expires`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_throttling`
--

DROP TABLE IF EXISTS `users_throttling`;
CREATE TABLE IF NOT EXISTS `users_throttling` (
  `bucket` varchar(44) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `tokens` float UNSIGNED NOT NULL,
  `replenished_at` int UNSIGNED NOT NULL,
  `expires_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`bucket`),
  KEY `expires_at` (`expires_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_throttling`
--

INSERT INTO `users_throttling` (`bucket`, `tokens`, `replenished_at`, `expires_at`) VALUES
('ejWtPDKvxt-q7LZ3mFjzUoIWKJYzu47igC8Jd9mffFk', 74, 1725114668, 1725654668),
('CUeQSH1MUnRpuE3Wqv_fI3nADvMpK_cg6VpYK37vgIw', 3.00081, 1724289422, 1724721422),
('87mTL4jTgQ0v25XqJdpKen9gP76st40Djco8Ib-waOs', 74, 1724381158, 1724921158),
('hdQOXeZ8AAQaZ1ZS6-1Yi-2Nt_zoNcJKPgGnfcpOcJ0', 74, 1725076488, 1725616488),
('owjqe9D-HX6-WNHj8NEjDvaGEdZp5w8bvbO7jq8CETg', 72.9283, 1724381211, 1724921211),
('FSoxr_XJK0A_OvpecXp89JuxsH2ak5hynTk31cQsfhM', 4, 1724381160, 1724813160),
('5Z0ApckaKUC7Dmk1Ld13ygkcmhR_9uKeCTLGmYR20jQ', 70.0484, 1724383157, 1724923157),
('E7FtNXIhCFarnAXen-mggME1BincL-BAqwAfRrcF-9s', 73.0297, 1724383110, 1724923110),
('xCtjOtwOQvvveIlAkpi44U8oaV7kBdt3QAxUjj25MeY', 74, 1724383054, 1724923054),
('sQqzDtgqHu1vSCxYuT7w7nxuOiTeK40zR34ZJPNc5E4', 74, 1724384745, 1724924745),
('hz9PFhe1DwAioQEy5f1Bg29yKEmEtbqV-5A02b_gBRc', 73.0069, 1724385258, 1724925258),
('ecZD2N7rUOlMEQ8KqONFRhSJPMYoufPkgr05zo5uQN4', 4, 1724385233, 1724817233),
('C3rTTQL28Bv0Qsf95IgXiuhoce8NMuyd4ic4shX5Y9U', 68.8139, 1724402873, 1724942873),
('_u_7sP6_hTyTpMBqq1hDToASTDps4GBmzk-eRIg0pcA', 4, 1724399036, 1724831036),
('Dy8zWoJjxfTeJfrAw1uRcNRPs1xuI3-N39XOPClcUsU', 74, 1724416508, 1724956508),
('v-NIVt4HtQbkg3mYLlwCilgPMCGEZA0l-4m7mmdl088', 73.0047, 1724478936, 1725018936),
('Xnb-H_hUX5NdsjLt0tQX0BVyRSjT5HTosbT369NEna4', 71.1598, 1724735387, 1725275387),
('HNr9lMtHRXclDWABKtPk6gBuo_ZlFYLGVZF-vgg5qts', 19, 1724734813, 1724770813),
('5lxHs5txfZfYux3bSLWR6eJDCSFwy4W8vicS6f5COlI', 499, 1724734813, 1724907613),
('SpikGslvP0EJyeywzV_aDds8mX6jNxcnPtEdFoPIiBU', 71.22, 1724907790, 1725447790),
('XpdegNZIDsxig_BmWPA0jptxxaWKUhfHeL2ZFRYTQpg', 74, 1724742570, 1725282570),
('lPSD78r3yhaMXNK_lHYFZEVu7PweKoQ-3L6lkRAasCo', 74, 1724741814, 1725281814),
('5TicZSPRzak66VN7BRWTzyNrI2UhBthGY8cmviFxQq0', 4, 1724907743, 1725339743),
('iEJWaHwqREOZ6dQW3nAXN7VkTfkkazXCBnIKWKQJg0k', 74, 1724849869, 1725389869),
('at5a8JPTgahQolIGI7JD6-pYZl9fCHBJn2B6RBD1rsk', 74, 1724854681, 1725394681),
('JGZ9I9oBCnyO5FEM461XPMrcSOkMtiHSstS0O7ox2MM', 74, 1724906380, 1725446380),
('v-B5NwFMjGUoGKNDp7Ut81TKXnP6b-sELgBWun7o2v0', 73.0508, 1724913714, 1725453714),
('uV1wN0_czg6DfG47P_8gWc6ADo0DCOS_xLOTkLcqd6A', 71.5414, 1724917704, 1725457704),
('e3hMZeKPMH657PbSLYRXHvSKZa_wrbgC9Uj9atvR0A8', 4, 1724917573, 1725349573),
('LlPgLL35RGbw382GucbFt6-Dvc44yN_S42Jq3jrXBVs', 74, 1724990481, 1725530481);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
