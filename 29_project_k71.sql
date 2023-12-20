-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2023 at 03:39 AM
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
  `is_true` int(11) NOT NULL,
  `ordinalNumber` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer`, `is_true`, `ordinalNumber`) VALUES
(301, 134, 'for ($i = 2; $i <= 10; $i++) {', 1, 1),
(302, 134, 'if ($i % 2 == 0) {', 1, 2),
(303, 134, 'echo $i . ;', 1, 3),
(304, 134, ' }}', 1, 4),
(305, 135, 'Personal Home Page', 0, NULL),
(306, 135, 'Preprocessor Hypertext', 0, NULL),
(307, 135, 'PHP: Hypertext Preprocessor', 1, NULL),
(308, 135, 'Private Hypertext Page', 0, NULL),
(309, 135, 'Programming Hyper Processor', 1, NULL),
(310, 136, 'HELLO WORLD!', 1, NULL),
(311, 136, 'hello world!', 0, NULL),
(312, 136, 'hello wolrd', 0, NULL),
(313, 136, 'Không chạy được, báo lỗi', 0, NULL),
(314, 137, 'none', 0, NULL),
(315, 137, 'null', 1, NULL),
(316, 137, 'undef', 0, NULL),
(317, 137, 'Không có khái niệm như vậy trong PHP', 0, NULL),
(318, 138, 'false ', 0, NULL),
(319, 138, 'true', 1, NULL),
(320, 138, 'Không có giá trị', 0, NULL),
(321, 138, 'true false', 0, NULL),
(322, 139, 'const', 0, NULL),
(323, 139, 'constants', 1, NULL),
(324, 139, 'define', 0, NULL),
(325, 139, 'def', 0, NULL),
(326, 140, 'file_exists()', 1, NULL),
(327, 140, 'is_file()', 1, NULL),
(328, 140, 'file_is()', 0, NULL),
(329, 140, 'file_check()', 0, NULL),
(330, 140, 'check_file()', 0, NULL),
(331, 141, 'if $x == 5 then', 0, NULL),
(332, 141, 'if $x = 5', 0, NULL),
(333, 141, ' if ($x == 5) {...', 1, NULL),
(334, 141, ' if ($x = 5);', 0, NULL),
(335, 141, 'if ($x === 5)', 1, NULL),
(336, 142, 'array()', 1, NULL),
(337, 142, '[ ]', 1, NULL),
(338, 142, 'new Array()', 0, NULL),
(339, 142, 'createArray()', 0, NULL),
(340, 142, 'makeArray()', 0, NULL),
(341, 143, 'Chuyển một mảng thành một chuỗi, sử dụng một ký tự nối', 1, NULL),
(342, 143, 'Tách một chuỗi thành một mảng, sử dụng một biểu thức chính quy', 1, NULL),
(343, 143, ' Kiểm tra xem một giá trị có tồn tại trong mảng hay không', 0, NULL),
(344, 143, 'Đảo ngược một chuỗi', 0, NULL),
(345, 143, 'Sắp xếp các phần tử trong một mảng theo thứ tự giảm dần', 1, NULL),
(346, 144, 'Kiểm tra xem biến có được định nghĩa hay không', 1, NULL),
(347, 144, 'Kiểm tra xem một biến có giá trị là null hay không', 0, NULL),
(348, 144, 'Kiểm tra xem một biến có tồn tại và không phải là null hay không', 1, NULL),
(349, 144, 'Kiểm tra xem một mảng có chứa một phần tử cụ thể hay không', 1, NULL),
(350, 144, 'Chuyển đổi một biến thành kiểu boolean', 0, NULL),
(351, 145, '74', 1, NULL),
(352, 146, 'GET ', 0, NULL),
(353, 146, 'POST ', 1, NULL),
(354, 146, 'REQUEST ', 0, NULL),
(355, 146, 'SEND ', 0, NULL),
(356, 147, 'global $variable;', 1, NULL),
(357, 147, '$variable = global;', 0, NULL),
(358, 147, 'set_global($variable);', 0, NULL),
(359, 147, 'create_global($variable);', 0, NULL),
(360, 148, 'Có', 0, NULL),
(361, 148, 'Không', 1, NULL),
(377, 152, '<?php ', 1, 1),
(378, 152, '$colors = array(\"Red\", \"Green\", \"Blue\");', 1, 2),
(379, 152, 'foreach ($colors as $key => $value)', 1, 3),
(380, 152, '{', 1, 4),
(381, 152, 'echo $key . \": \" . $value . \"<br>\";', 1, 5),
(382, 152, ' } ', 1, 6),
(383, 152, '?>', 1, 7),
(384, 153, '7 is a prime number.', 1, NULL),
(385, 154, '==', 0, NULL),
(386, 154, 'in_array()', 1, NULL),
(387, 154, '=', 0, NULL),
(388, 154, '===', 0, NULL),
(389, 155, 'Dữ liệu được truyền qua URL.', 0, NULL),
(390, 155, 'Dữ liệu không được hiển thị trong URL.', 1, NULL),
(391, 155, 'Có thể sử dụng để truyền dữ liệu giữa các trang.', 1, NULL),
(392, 155, 'Dữ liệu được lưu trữ trong biến toàn cục $_GET.', 0, NULL),
(393, 156, 'Khi biết chính xác số lần lặp.', 1, NULL),
(394, 156, 'Khi số lần lặp phụ thuộc vào một điều kiện.', 0, NULL),
(395, 156, 'Khi muốn lặp qua các phần tử của mảng.', 0, NULL),
(396, 156, 'Khi muốn lặp qua các số nguyên liên tục.', 0, NULL),
(397, 157, 'a2a1a3', 1, NULL),
(398, 158, 'Một cách duy nhất', 0, NULL),
(399, 158, 'Hai cách', 0, NULL),
(400, 158, 'Ba cách', 0, NULL),
(401, 158, 'Nhiều hơn ba cách', 1, NULL),
(402, 159, '// This is a multi-line comment //', 0, NULL),
(403, 159, '/* This is a multi-line comment */', 1, NULL),
(404, 159, '# This is a multi-line comment #', 0, NULL),
(405, 159, '/* This is a multi-line comment //', 0, NULL),
(406, 160, '13179', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course` varchar(50) NOT NULL,
  `state` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course`, `state`) VALUES
(106, 'KiemTra', 0),
(108, 'Công nghệ Web', 1),
(109, 'Quản trị mạng', 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_users`
--

CREATE TABLE `course_users` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `state` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_users`
--

INSERT INTO `course_users` (`id`, `course_id`, `user_id`, `state`) VALUES
(12, 106, 13, 1),
(14, 108, 13, 1),
(17, 108, 14, 1),
(18, 109, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lesson`
--

CREATE TABLE `lesson` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `id_course` int(11) NOT NULL,
  `numericalorder` int(11) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`id`, `name`, `video`, `description`, `id_course`, `numericalorder`, `file`) VALUES
(41, 'Bài 1: Lập trình website bán hàng full-stack - Giao diện trang chủ (P1)', '6ca7Roj_NfE', '', 108, 1, 'quizzCNW (1).docx'),
(42, 'Bài 1: Lập trình website bán hàng full-stack - Giao diện trang chủ (P2)', 'T4RIbr9VIT8', '', 108, 2, ''),
(43, 'Bài 1: Lập trình website bán hàng full-stack - Giao diện trang chủ (P3)', '3hx24mRfKGE', '', 108, 3, ''),
(44, 'Lập trình website bán hàng full stack Giao diện trang danh mục sản phẩm', 'HrzV05lzf2Y', '', 108, 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `tittle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `tittle`, `description`, `time`) VALUES
(154, 'Công nghệ Web', 'Admin đã thêm bài giảng mới', '2023-12-20 09:17:56'),
(155, 'Công nghệ Web', 'Admin đã thêm bài giảng mới', '2023-12-20 09:18:43'),
(156, 'Công nghệ Web', 'Admin đã thêm bài giảng mới', '2023-12-20 09:27:32'),
(157, 'Công nghệ Web', 'Admin đã thêm bài giảng mới', '2023-12-20 09:28:03'),
(158, 'Công nghệ Web', 'Admin đã thêm bài giảng mới', '2023-12-20 09:36:11');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(10) NOT NULL,
  `question` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `course_id` int(10) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` int(10) NOT NULL,
  `state` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `type`, `course_id`, `image`, `user_id`, `state`) VALUES
(134, 'Sắp xếp đoạn code sau: ', 'Sắp xếp', 108, NULL, 13, 1),
(135, 'PHP là viết tắt của gì?', 'Trắc nghiệm', 108, '', 13, 1),
(136, 'Đoạn mã sau, in ra giá trị nào sau đây', 'Trắc nghiệm', 108, 'image-6581e317a40e66.77241429.png', 13, 1),
(137, 'Mặc định của một biến không có giá trị được thể hiện với từ khóa', 'Trắc nghiệm', 108, '', 13, 1),
(138, 'Đoạn mã sau, in ra giá trị nào sau đây', 'Trắc nghiệm', 108, 'image-6581e3aba526f5.53260319.png', 13, 1),
(139, 'Hàm nào sau đây dùng để khai báo hằng số', 'Trắc nghiệm', 108, '', 13, 1),
(140, 'Hàm nào được sử dụng để kiểm tra xem một tập tin có tồn tại hay không trong PHP?', 'Trắc nghiệm', 108, '', 13, 1),
(141, 'Trong PHP, cách nào sau đây dùng để thực hiện lệnh điều kiện IF cho một biến?', 'Trắc nghiệm', 108, '', 13, 1),
(142, 'Để khai báo một mảng trong PHP, bạn sử dụng cú pháp nào sau đây?', 'Trắc nghiệm', 108, '', 13, 1),
(143, 'Trong PHP, hàm implode() được sử dụng để:', 'Trắc nghiệm', 108, '', 13, 1),
(144, 'Trong PHP, hàm isset() được sử dụng để:', 'Trắc nghiệm', 108, '', 13, 1),
(145, 'Trong PHP, sau khi thực hiện đoạn mã kết quả hiển thị sẽ là gì?', 'Điền', 108, 'image-6581e73f095273.15850388.png', 13, 1),
(146, 'Để gửi dữ liệu từ một trang web đến trang web khác trong PHP, bạn sử dụng phương thức nào?', 'Trắc nghiệm', 108, '', 13, 1),
(147, 'Trong PHP làm thế nào để tạo một biến toàn cục?', 'Trắc nghiệm', 108, '', 13, 1),
(148, 'Empty và isset có giống nhau không?', 'Trắc nghiệm', 108, '', 13, 1),
(152, 'Sắp xếp đoạn code sau', 'Sắp xếp', 108, NULL, 13, 1),
(153, 'Đoạn code dưới đây in ra gì ? (Nhập chính xác cả khoảng trắng và dấu)', 'Điền', 108, 'image-658247c3d60671.26933362.png', 13, 1),
(154, 'Toán tử nào được sử dụng để kiểm tra xem một giá trị có nằm trong mảng hay không ?', 'Trắc nghiệm', 108, '', 13, 1),
(155, 'Điều nào không đúng về GET trong PHP?', 'Trắc nghiệm', 108, '', 13, 1),
(156, 'Vòng lặp for trong PHP thường được sử dụng khi nào?', 'Trắc nghiệm', 108, '', 13, 1),
(157, 'Sau khi thực hiện đoạn mã kết quả trả về sẽ là gì?', 'Điền', 108, 'image-658248928500f2.67880190.png', 13, 1),
(158, 'Trong PHP, có bao nhiêu cách chính để tạo kết nối đến cơ sở dữ liệu?', 'Trắc nghiệm', 108, '', 13, 1),
(159, 'Làm thế nào để tạo comment trên nhiều dòng trong PHP?', 'Trắc nghiệm', 108, '', 13, 1),
(160, 'Đoạn code sau in ra gì ?', 'Điền', 108, 'image-65824909d0f749.63681223.png', 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `timeSubmit` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`id`, `user_id`, `score`, `course_id`, `timeSubmit`) VALUES
(417, 13, 0, 108, '2023-12-20'),
(418, 13, 8, 108, '2023-12-20'),
(419, 13, 0, 108, '2023-12-20'),
(420, 13, 7, 108, '2023-12-20'),
(421, 13, 0, 108, '2023-12-20'),
(422, 13, 0, 108, '2023-12-20'),
(423, 13, 0, 108, '2023-12-20'),
(424, 13, 0, 108, '2023-12-20'),
(425, 13, 0, 108, '2023-12-20'),
(426, 13, 0, 108, '2023-12-20'),
(427, 13, 0, 108, '2023-12-20'),
(428, 13, 1, 108, '2023-12-20'),
(429, 13, 0, 108, '2023-12-20'),
(430, 13, 0, 108, '2023-12-20'),
(431, 13, 1, 108, '2023-12-20'),
(432, 13, 0, 108, '2023-12-20'),
(433, 13, 2, 108, '2023-12-20'),
(434, 13, 0, 108, '2023-12-20'),
(435, 13, 5, 108, '2023-12-20'),
(436, 13, 0, 108, '2023-12-20'),
(437, 13, 3, 108, '2023-12-20');

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
  `answer_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `role` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `fullname`, `role`) VALUES
(13, 'adminnhom29', 'a1c6898bc270eb1c63089bee97edeb79', 'Mai Lý Hải', 1),
(14, 'mailyhai', '02a1a2426cd425555fcf3e80cc48c523', 'Mai Lý Hải', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_read` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`notification_id`, `user_id`, `is_read`) VALUES
(154, 13, 0),
(154, 14, 0),
(155, 13, 0),
(155, 14, 0),
(156, 13, 0),
(156, 14, 0),
(157, 13, 0),
(157, 14, 0),
(158, 13, 0),
(158, 14, 0);

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
-- Indexes for table `course_users`
--
ALTER TABLE `course_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_USER` (`user_id`),
  ADD KEY `FK_COURSE` (`course_id`);

--
-- Indexes for table `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_COURSES` (`id_course`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
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
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`notification_id`,`user_id`),
  ADD KEY `FK_USERSD` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=407;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `course_users`
--
ALTER TABLE `course_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `lesson`
--
ALTER TABLE `lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=438;

--
-- AUTO_INCREMENT for table `true_answers`
--
ALTER TABLE `true_answers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `FKquestionId` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_users`
--
ALTER TABLE `course_users`
  ADD CONSTRAINT `FK_COURSE` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `FK_USER` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `lesson`
--
ALTER TABLE `lesson`
  ADD CONSTRAINT `FK_COURSES` FOREIGN KEY (`id_course`) REFERENCES `courses` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `FKcourseId` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FKuserId` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `FKuser` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Fkcourse` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

--
-- Constraints for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD CONSTRAINT `FK_NOTIFICATIONS` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_USERSD` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
