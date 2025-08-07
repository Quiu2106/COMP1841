-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2025 at 06:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cwcomp1841`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_replies`
--

CREATE TABLE `admin_replies` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `reply_text` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_replies`
--

INSERT INTO `admin_replies` (`id`, `message_id`, `admin_id`, `reply_text`, `sent_at`) VALUES
(1, 10, 1, 'Nguyen Rang Bo', '2025-07-21 07:32:58'),
(2, 12, 15, 'ádasdasdádasd\r\n', '2025-07-21 13:45:02'),
(3, 13, 1, 'OK I will help you', '2025-07-22 05:45:45'),
(4, 15, 1, 'I can not return your feelings', '2025-07-28 14:17:53'),
(5, 16, 1, 'OK, I\'m also testing', '2025-08-07 03:13:11');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `text` text NOT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `question_id`, `user_id`, `text`, `date`) VALUES
(4, 9, 6, 'You probably forgot to check isset before access.', '2025-07-15 14:14:50'),
(5, 9, 7, 'Common error, try var_dump to debug.', '2025-07-15 14:14:50'),
(6, 2, 4, 'Check if the file permissions in XAMPP are correct.', '2025-07-15 14:15:22'),
(7, 4, 6, 'LEFT JOIN will include unmatched rows from the left table.', '2025-07-15 14:15:22'),
(8, 4, 3, 'Add WHERE condition to avoid NULLs if needed.', '2025-07-15 14:15:22'),
(10, 8, 2, 'Try inspecting with browser dev tools.', '2025-07-15 14:15:22'),
(11, 8, 7, 'Maybe your CSS grid is missing column definitions.', '2025-07-15 14:15:22'),
(12, 8, 10, 'Add gap or check width constraints.', '2025-07-15 14:15:22'),
(14, 7, 1, 'I\'m testing', '2025-07-15 14:38:02'),
(34, 23, 18, 'OK', '2025-07-22 07:40:46'),
(36, 24, 1, '!OKK', '2025-07-22 07:45:14'),
(40, 24, 2, 'testing', '2025-07-28 13:07:23'),
(41, 27, 22, 'Just For Fun ver 2.0', '2025-07-28 15:50:10'),
(42, 27, 2, 'aaaaaa', '2025-08-01 14:26:17');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`, `is_read`, `user_id`) VALUES
(8, 'bob4563', 'bob@abc.com', 'General Question', 'Testing', '2025-07-19 07:32:02', 1, NULL),
(10, 'bob4563', 'bob@abc.com', 'Other', 'Ngo Iron Bap', '2025-07-21 03:46:16', 1, NULL),
(12, 'bob4563', 'bob@abc.com', 'General Question', 'ádasdasdasdasd', '2025-07-21 07:43:46', 1, NULL),
(13, 'QuynhNhu', 'Qnhu@gmail.com', 'Bug Report', 'I need your help', '2025-07-22 05:44:36', 1, NULL),
(14, 'QuynhNhu', 'Qnhu@gmail.com', 'Other', 'Testing', '2025-07-28 12:48:22', 1, NULL),
(15, 'Nguyễn Minh Trí', 'NMTri@gmail.com', 'Other', 'I Love You', '2025-07-28 13:58:16', 1, NULL),
(16, 'bob4563', 'bob@abc.com', 'Bug Report', 'testing', '2025-08-07 03:11:54', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `name`) VALUES
(1, 'COMP18411'),
(2, 'COMP1778'),
(3, 'MATH1050'),
(4, 'COMP1841'),
(5, 'ENG101'),
(6, 'PHY110'),
(7, 'HIST220'),
(8, 'COMP2020'),
(9, 'DS101'),
(18, 'Vovinam');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `title`, `text`, `date`, `image`, `module_id`, `user_id`) VALUES
(2, 'Image upload not working', 'JPG files not uploading on localhost.', '2025-06-02', '7.png', 2, 2),
(3, 'Difference between POST and GET?', 'When to use each method?', '2025-06-03', NULL, 1, 3),
(4, 'SQL JOIN confusion', 'INNER vs LEFT JOIN example needed.', '2025-06-04', '6.png', 3, 4),
(6, 'Responsive CSS help', 'My page is not mobile friendly.', '2025-06-06', NULL, 2, 6),
(7, 'Password hashing?', 'How to hash passwords securely in PHP?', '2025-06-07', '3.png', 1, 7),
(8, 'CSS grid layout bug', 'Columns not aligning.', '2025-06-09', '10.png', 4, NULL),
(9, 'Undefined index warning', 'How to avoid this PHP error?', '2025-06-10', '1.png', 1, 10),
(21, 'Ngô Iron Bắp', 'Ngô Là Bắp', '2025-07-19', '1752888390_img_5404.jpg', NULL, 2),
(23, 'testing 10', 'I\'m just testing', '2025-07-21', '1753106167_UML assignment2-Page-2.drawio.png', NULL, 11),
(24, 'VoQuynhNhu', 'I\'m leader', '2025-07-22', '1753162894_Screenshot 2025-04-21 103557.png', 6, 18),
(26, 'Something I don\'t know why it exist?', 'help me\r\n', '2025-07-22', '1753162959_Screenshot 2025-04-21 121211.png', 4, 18),
(27, 'ADMIN', 'Admin testing', '2025-07-28', '1753701498_Screenshot 2025-04-21 124302.png', NULL, 1),
(28, 'Nguyễn Minh Trí', 'My name is Trí, My StudentID is GCS230XXX', '2025-07-28', '1753710272_lightning-icon-lightning-bolt-icon-vector-removebg-preview.png', NULL, 22);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role`, `image`) VALUES
(1, 'qui nguyen', 'quinngcs230163@fpt.edu.vn', '$2y$10$Zf.1FojdIH1lcHm67t4wI.3C5uBKXOcU/kznm.vexW1YwycXTEA9a', 'admin', '1754536408_Screenshot 2025-04-24 193813.png'),
(2, 'bob4563', 'bob@abc.com', '$2y$10$MWWWTPysrr4aMEd7FiAdJukfxJzZI.VBxZYVb1PTl3l7BJ0ekKadm', 'user', '1752852304_IMG_9360.JPG'),
(3, 'charlie789', 'charlie@abc.com', '$2y$10$RmyUW0FNXcAM4JTcpNveSuQ4/Z4Nlcvsu8qhDG.ykaAFPcceXwhH6', 'user', NULL),
(4, 'daisy001', 'daisy@abc.com', '$2y$10$RmyUW0FNXcAM4JTcpNveSuQ4/Z4Nlcvsu8qhDG.ykaAFPcceXwhH6', 'user', NULL),
(6, 'fiona77', 'fiona@abc.com', '$2y$10$RmyUW0FNXcAM4JTcpNveSuQ4/Z4Nlcvsu8qhDG.ykaAFPcceXwhH6', 'user', NULL),
(7, 'georgex', 'george@abc.com', '$2y$10$RmyUW0FNXcAM4JTcpNveSuQ4/Z4Nlcvsu8qhDG.ykaAFPcceXwhH6', 'user', NULL),
(8, 'hannah_dev', 'hannah@abc.com', '$2y$10$RmyUW0FNXcAM4JTcpNveSuQ4/Z4Nlcvsu8qhDG.ykaAFPcceXwhH6', 'user', NULL),
(10, 'judyX', 'judy@abc.com', '$2y$10$RmyUW0FNXcAM4JTcpNveSuQ4/Z4Nlcvsu8qhDG.ykaAFPcceXwhH6', 'user', NULL),
(11, 'ThachTran', 'Thach@abc.com', '$2y$10$RmyUW0FNXcAM4JTcpNveSuQ4/Z4Nlcvsu8qhDG.ykaAFPcceXwhH6', 'user', '1753106297_activity 1.jpg'),
(13, 'CentralLam', 'Lam@abc.com', '$2y$10$n1MDV7QRmVvzS2K4dKmubuvk5eZUbceARwQoHuAFIVy9BAcnmrASq', 'admin', NULL),
(14, 'CuongNgo', 'Cuong@abc.com', '$2y$10$qzJlHeoLkNPj80cboHpmcu.EQzx6/avk4gYfWT4VF4xacvkEqaK.W', 'user', NULL),
(15, 'admin', 'admin@admin.com', '$2y$10$/dzM4uDylYJomxQ09rEEj.FuqWxMKEK0NxmvMCA7BuWt/keo5h/4S', 'admin', '1753686961_mssv.jpg'),
(18, 'QuynhNhu', 'Qnhu@gmail.com', '$2y$10$Zf.1FojdIH1lcHm67t4wI.3C5uBKXOcU/kznm.vexW1YwycXTEA9a', 'user', '1753163016_Screenshot 2025-06-09 195738.png'),
(21, '123', '123@gmail.com', '$2y$10$X.2.7MBfK4zWGD0bE4ISsejxzmbSkFySAWvAoJ8E/iBw4bXu9sS5K', 'user', NULL),
(22, 'NMTri', 'NMTri@gmail.com', '$2y$10$VnvYQCIgr9RuBWiE4tEIoOpPhwA9lASLc3/3s68ptBJxeCiRySR1y', 'user', '1753711009_lightning-icon-lightning-bolt-icon-vector-removebg-preview.png'),
(23, 'Huy', 'Huy2806@gmail.com', '$2y$10$XOFaEhD136wkuYd58vKmVeyb/rVOE./QmfuX2O5P0FP8AYnuTXMWe', 'user', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_replies`
--
ALTER TABLE `admin_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_id` (`message_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_question_user` (`user_id`),
  ADD KEY `fk_question_module` (`module_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_replies`
--
ALTER TABLE `admin_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_replies`
--
ALTER TABLE `admin_replies`
  ADD CONSTRAINT `admin_replies_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `contact_messages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_replies_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `fk_question_module` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_question_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
