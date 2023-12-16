-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2023 at 04:44 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `29_project_k71`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(10) NOT NULL,
  `question_id` int(10) NOT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `fill_answer` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer`, `fill_answer`) VALUES
(2, 4, NULL, 'No'),
(4, 6, NULL, '1'),
(5, 7, NULL, 'rửe'),
(6, 8, NULL, 'rửe');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(10) NOT NULL,
  `course` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course`) VALUES
(1, 'Nền tảng phát triển web'),
(2, 'Công nghệ web');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(10) NOT NULL,
  `question` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `course_id` int(10) NOT NULL,
  `image` longblob DEFAULT NULL,
  `user_id` int(10) NOT NULL,
  `state` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `type`, `course_id`, `image`, `user_id`, `state`) VALUES
(4, 'Is HTML a languague?', 'Điền', 2, '', 3, 1),
(6, 'abcxyz123', 'Điền', 2, '', 3, 1),
(7, 'ưqrwre', 'Điền', 2, '', 3, 1),
(8, 'ưqrwre', 'Điền', 2, '', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `course_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(10) DEFAULT NULL,
  `name_test` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL,
  `questions_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `true_answers`
--

CREATE TABLE `true_answers` (
  `id` int(10) NOT NULL,
  `answer_id` int(10) NOT NULL,
  `true_answer1` varchar(255) DEFAULT NULL,
  `true_answer2` varchar(255) DEFAULT NULL,
  `true_answer3` varchar(255) DEFAULT NULL,
  `true_answer4` varchar(255) DEFAULT NULL,
  `true_answer5` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `role` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `fullname`, `role`) VALUES
(3, 'admin', '533d9189235e8faf2a55d8f0bf490958', 'admin', 1),
(4, '715105097', '24555ddb83e8baf6974e9cdca745c9', '715105097', 0),
(6, 'taikhoan1', '4da40d6f7c1c67cc101434d594d2df', 'taikhoan1', 0),
(7, 'hoang2003', '0ea555a9eb07434c3c1b8f6ceda52a', 'hoang2003', 0),
(8, 'admin123456', 'a66abb5684c45962d887564f08346e', 'admin123456', 0),
(9, '715105074', 'c83827d7aeec3c8130133a84419e00e4', '715105074', 0),
(10, 'Huyhoang2003', '77186cdb974c6cbe382b00c2317d2774', 'Huyhoang2003', 0),
(11, 'abcxyz123', '25f9e794323b453885f5181f1b624d0b', 'Lê Huy Hoàng', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKquestionId` (`question_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKcourseId` (`course_id`),
  ADD KEY `FKuserId` (`user_id`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKuser` (`user_id`),
  ADD KEY `Fkcourse` (`course_id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD KEY `FKu` (`user_id`),
  ADD KEY `FKq` (`questions_id`);

--
-- Indexes for table `true_answers`
--
ALTER TABLE `true_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKtrueAnswersId` (`answer_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `true_answers`
--
ALTER TABLE `true_answers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `FKquestionId` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `FKcourseId` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `FKuserId` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `FKuser` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `Fkcourse` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `FKq` FOREIGN KEY (`questions_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `FKu` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `true_answers`
--
ALTER TABLE `true_answers`
  ADD CONSTRAINT `FKtrueAnswersId` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
