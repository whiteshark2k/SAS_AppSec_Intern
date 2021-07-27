-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2021 at 04:24 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `c5`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `admin` tinyint(1) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` text NOT NULL,
  `fullname` text NOT NULL,
  `email` text NOT NULL,
  `tel` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`admin`, `username`, `password`, `fullname`, `email`, `tel`) VALUES
(0, 'CuongNM', 'test', 'Nguyễn Mạnh Cường', 'CuongNM@fsoft.com.vn', '0901897531'),
(0, 'GiangNT', 'test', 'Nguyễn Trường Giang', 'GiangNT@fsoft.com.vn', '0998682287'),
(0, 'HaiHM', 'test', 'Hoàng Minh Hải', 'HaiHM@fsoft.com.vn', '0998682287'),
(0, 'HoangMV', 'test', 'Mai Việt Hoàng', 'HoangMV@fsoft.com.vn', '0949946297'),
(1, 'LinhTD', 'admin', 'Trần Đức Linh', 'LinhTD@fsoft.com.vn', '0969285698'),
(0, 'NhatLQ', 'test', 'Lê Quý Nhật', 'NhatLQ@fsoft.com.vn', '0916066368'),
(0, 'TraLT', 'test', 'Lê Thị Trà', 'TraLT@fsoft.com.vn', '0943371608');

-- --------------------------------------------------------

--
-- Table structure for table `bai_tap`
--

CREATE TABLE `bai_tap` (
  `id_bt` int(11) NOT NULL,
  `ten_bt` text NOT NULL,
  `do_kho` text NOT NULL,
  `thoi_gian` int(2) NOT NULL,
  `mo_ta` text NOT NULL,
  `tep_dinh_kem` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bai_tap`
--

INSERT INTO `bai_tap` (`id_bt`, `ten_bt`, `do_kho`, `thoi_gian`, `mo_ta`, `tep_dinh_kem`) VALUES
(9, 'Challenge 1: Bài tập Shell Script', 'Dễ', 1, 'Viết báo cáo dưới dạng markdown', 'Challenge1.pdf'),
(10, 'Challenge 2: Lập trình Linux/Sticky Bit', 'Trung Bình', 1, 'Viết báo cáo dưới dạng markdown', 'challenge2.pdf'),
(11, 'Challenge 3: Lập trình SSH Logger', 'Khó', 1, 'Viết báo cáo dưới dạng markdown', 'challenge3.pdf'),
(12, 'Challenge 4: Lập trình mạng/HTTP Client', 'Dễ', 1, 'Viết báo cáo dưới dạng markdown', 'Challenge 4.docx.pdf'),
(13, 'Challenge 5: Lập trình web cơ bản', 'Dễ', 1, 'Viết báo cáo dưới dạng markdown', 'Challenge 5.docx.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `nop_bai`
--

CREATE TABLE `nop_bai` (
  `id_nop_bai` int(11) NOT NULL,
  `id_bt` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `thoi_gian_nop` datetime NOT NULL,
  `bai_nop` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nop_bai`
--

INSERT INTO `nop_bai` (`id_nop_bai`, `id_bt`, `username`, `thoi_gian_nop`, `bai_nop`) VALUES
(19, 9, 'NhatLQ', '2021-07-27 19:35:34', 'NhatLQ.Challenge_1.md'),
(20, 11, 'NhatLQ', '2021-07-27 19:35:41', 'NhatLQ.Challenge_3.md'),
(21, 13, 'NhatLQ', '2021-07-27 19:35:48', 'NhatLQ.Challenge_5.md'),
(22, 9, 'HoangMV', '2021-07-27 19:37:22', 'HoangMV.Challenge_1.md'),
(23, 10, 'HoangMV', '2021-07-27 19:37:34', 'HoangMV.Challenge_2.md'),
(24, 11, 'HoangMV', '2021-07-27 19:37:40', 'HoangMV.Challenge_3.md'),
(25, 12, 'HoangMV', '2021-07-27 19:37:46', 'HoangMV.Challenge_4.md'),
(26, 13, 'HoangMV', '2021-07-27 19:37:53', 'HoangMV.Challenge_5.md'),
(27, 11, 'HaiHM', '2021-07-27 19:39:04', 'HaiHM.Challenge_3.md'),
(28, 12, 'HaiHM', '2021-07-27 19:39:11', 'HaiHM.Challenge_4.md'),
(29, 9, 'HaiHM', '2021-07-27 19:39:18', 'HaiHM.Challenge_1.md'),
(30, 13, 'TraLT', '2021-07-27 19:40:09', 'TraLT.Challenge_5.md'),
(31, 9, 'TraLT', '2021-07-27 19:40:16', 'TraLT.Challenge_1.md'),
(32, 10, 'GiangNT', '2021-07-27 19:41:12', 'GiangNT.Challenge_2.md'),
(33, 9, 'GiangNT', '2021-07-27 19:41:17', 'GiangNT.Challenge_1.md');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id_quiz` int(11) NOT NULL,
  `ten_quiz` text NOT NULL,
  `goi_y` text NOT NULL,
  `tep_dinh_kem` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id_quiz`, `ten_quiz`, `goi_y`, `tep_dinh_kem`) VALUES
(2, 'Challenge 1: Thơ', 'Ngữ Văn 12 - Tác giả Xuân Quỳnh', 'Song.txt'),
(3, 'Challenge 2: Thơ', 'Ngữ Văn 12 - Tác giả Quang Dũng', 'Tay Tien.txt'),
(4, 'Challenge 3: Thơ', 'Ngữ Văn 12 - Tác giả Tố Hữu', 'Viet Bac.txt'),
(5, 'Challenge 4: Thơ', 'Ngữ Văn 12 - Tác giả Nguyễn Khoa Điềm', 'Dat Nuoc.txt'),
(6, 'Challenge 5: Tác phẩm văn học', 'Ngữ Văn 12 - Tác giả Nguyễn Tuân', 'Nguoi Lai Do Song Da.txt');

-- --------------------------------------------------------

--
-- Table structure for table `tin_nhan`
--

CREATE TABLE `tin_nhan` (
  `id_tn` int(11) NOT NULL,
  `nguoi_gui` varchar(25) NOT NULL,
  `nguoi_nhan` varchar(25) NOT NULL,
  `thoi_gian` datetime NOT NULL,
  `noi_dung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tin_nhan`
--

INSERT INTO `tin_nhan` (`id_tn`, `nguoi_gui`, `nguoi_nhan`, `thoi_gian`, `noi_dung`) VALUES
(14, 'LinhTD', 'TraLT', '2021-07-27 19:29:29', 'Chào mừng, Lê Thị Trà!'),
(15, 'LinhTD', 'CuongNM', '2021-07-27 19:30:29', 'Chào mừng, Nguyễn Mạnh Cường!'),
(16, 'LinhTD', 'GiangNT', '2021-07-27 19:30:41', 'Chào mừng, Nguyễn Trường Giang!'),
(17, 'LinhTD', 'HaiHM', '2021-07-27 19:30:52', 'Chào mừng, Hoàng Minh Hải!'),
(18, 'LinhTD', 'HoangMV', '2021-07-27 19:31:03', 'Chào mừng, Mai Việt Hoàng!'),
(19, 'LinhTD', 'NhatLQ', '2021-07-27 19:31:15', 'Chào mừng, Lê Quý Nhật!'),
(20, 'NhatLQ', 'CuongNM', '2021-07-27 19:34:52', 'Chào Cường!'),
(21, 'NhatLQ', 'HaiHM', '2021-07-27 19:35:02', 'Khỏe không Hải!'),
(22, 'NhatLQ', 'HoangMV', '2021-07-27 19:35:14', 'Lâu lắm không gặp!'),
(23, 'NhatLQ', 'LinhTD', '2021-07-27 20:22:58', 'Xin chào!');

-- --------------------------------------------------------

--
-- Table structure for table `tl_quiz`
--

CREATE TABLE `tl_quiz` (
  `id_quiz` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `trang_thai` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tl_quiz`
--

INSERT INTO `tl_quiz` (`id_quiz`, `username`, `trang_thai`) VALUES
(2, 'GiangNT', 1),
(2, 'HaiHM', 1),
(2, 'HoangMV', 1),
(2, 'NhatLQ', 1),
(2, 'TraLT', 1),
(3, 'HoangMV', 1),
(3, 'NhatLQ', 1),
(4, 'HaiHM', 1),
(4, 'HoangMV', 1),
(4, 'NhatLQ', 1),
(5, 'HoangMV', 1),
(5, 'TraLT', 1),
(6, 'HaiHM', 1),
(6, 'HoangMV', 1),
(6, 'NhatLQ', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `bai_tap`
--
ALTER TABLE `bai_tap`
  ADD PRIMARY KEY (`id_bt`);

--
-- Indexes for table `nop_bai`
--
ALTER TABLE `nop_bai`
  ADD PRIMARY KEY (`id_nop_bai`),
  ADD KEY `id_bt` (`id_bt`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id_quiz`);

--
-- Indexes for table `tin_nhan`
--
ALTER TABLE `tin_nhan`
  ADD PRIMARY KEY (`id_tn`),
  ADD KEY `nguoi_gui` (`nguoi_gui`),
  ADD KEY `nguoi_nhan` (`nguoi_nhan`);

--
-- Indexes for table `tl_quiz`
--
ALTER TABLE `tl_quiz`
  ADD PRIMARY KEY (`id_quiz`,`username`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bai_tap`
--
ALTER TABLE `bai_tap`
  MODIFY `id_bt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `nop_bai`
--
ALTER TABLE `nop_bai`
  MODIFY `id_nop_bai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id_quiz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tin_nhan`
--
ALTER TABLE `tin_nhan`
  MODIFY `id_tn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nop_bai`
--
ALTER TABLE `nop_bai`
  ADD CONSTRAINT `nop_bai_ibfk_1` FOREIGN KEY (`id_bt`) REFERENCES `bai_tap` (`id_bt`),
  ADD CONSTRAINT `nop_bai_ibfk_2` FOREIGN KEY (`username`) REFERENCES `account` (`username`);

--
-- Constraints for table `tin_nhan`
--
ALTER TABLE `tin_nhan`
  ADD CONSTRAINT `tin_nhan_ibfk_1` FOREIGN KEY (`nguoi_gui`) REFERENCES `account` (`username`),
  ADD CONSTRAINT `tin_nhan_ibfk_2` FOREIGN KEY (`nguoi_nhan`) REFERENCES `account` (`username`);

--
-- Constraints for table `tl_quiz`
--
ALTER TABLE `tl_quiz`
  ADD CONSTRAINT `tl_quiz_ibfk_1` FOREIGN KEY (`id_quiz`) REFERENCES `quiz` (`id_quiz`),
  ADD CONSTRAINT `tl_quiz_ibfk_2` FOREIGN KEY (`username`) REFERENCES `account` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
