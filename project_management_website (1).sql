-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2025 at 07:39 PM
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
-- Database: `project_management_website`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_project_mark`
--

CREATE TABLE `add_project_mark` (
  `student_name` varchar(255) NOT NULL,
  `student_enrollment` varchar(255) NOT NULL,
  `project_id` int(11) NOT NULL,
  `project_title` varchar(255) NOT NULL,
  `1_project_review` int(11) NOT NULL,
  `2_project_review` int(11) NOT NULL,
  `3_project_review` int(11) NOT NULL,
  `total` int(11) GENERATED ALWAYS AS (`1_project_review` + `2_project_review` + `3_project_review`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_project_mark`
--

INSERT INTO `add_project_mark` (`student_name`, `student_enrollment`, `project_id`, `project_title`, `1_project_review`, `2_project_review`, `3_project_review`) VALUES
('Rakesh mali', '206580316001', 18, 'office management', 48, 25, 10),
('vignesh', '206580316002', 17, 'college management', 20, 10, 2),
('sujal', '206580316003', 17, 'college management', 8, 10, 5),
('bhavesh', '206580316004', 20, 'shop management system', 5, 5, 0),
('prince', '206580316005', 20, 'shop management system', 4, 10, 0),
('ram', '206580316006', 19, 'rc management system', 0, 0, 0),
('Rakesh mali', '206580316007', 20, 'shop management system', 0, 0, 0),
('Rakesh mali', '206580316008', 21, 'student management', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `adminlogin`
--

CREATE TABLE `adminlogin` (
  `admin_id` int(11) NOT NULL,
  `id` varchar(50) NOT NULL,
  `aname` varchar(50) NOT NULL,
  `apassword` varchar(255) NOT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `aemail` varchar(50) DEFAULT NULL,
  `amobile` varchar(10) DEFAULT NULL,
  `failed_attempts` int(11) DEFAULT NULL,
  `lock_until` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminlogin`
--

INSERT INTO `adminlogin` (`admin_id`, `id`, `aname`, `apassword`, `semester`, `aemail`, `amobile`, `failed_attempts`, `lock_until`) VALUES
(1, 'admin_sem1', '', '$2b$12$e91LUA9DetOoEKUBs3TZKeNeUnFnxGSYQQ5U5iyQT02QFtjNgnWV2', '1', NULL, NULL, 0, NULL),
(2, 'admin_sem2', '', '$2b$12$FHX6VFdlrTEmcX.74iCmueIC7kVBCayxqPgnO2HpXdLVbTP5rcOJK', '2', NULL, NULL, 0, NULL),
(3, 'admin_sem3', 'prakashn', '$2b$12$mGVx5yBZkFVUEZAkKkIhDOJ.8PMG/H7Br/n12F/o1t3/52HlMlJhS', '3', 'rakeshmali.mjn989@muj.manipal.edu', '7589456222', 0, NULL),
(4, 'admin_sem4', '', '$2b$12$LNXZZHTN/6WKwcGWERuX5ebXiUBoB.NqMCRgR3XP9e5/E.qXAkg5y', '4', NULL, NULL, 0, NULL),
(5, 'admin_sem5', 'prakash', '$2b$12$NIRffFxrU7BbdDjIMmz3p.9urKoM2JteuYTsQJMlTp1Bu7fO0XY3K', '5', 'prakash.muj2021@muj.manipal.edu', '5454848787', 0, NULL),
(6, 'admin_sem6', 'rakesh', '$2b$12$S01iYzHa5ko7kAbGUcr.N.m/ISHaALkSjccInNBsqkCxuy6LGkuU2', '6', 'rakesh.muj2026@muj.manipal.edu', '7787878986', 0, NULL),
(7, 'admin_sem7', 'jon', '$2y$10$xv/VZ55PO0Cj6yfjqXLOCuZeWvhoFAONPMJfltMHVykvLPitXwXl2', '7', '', '', 0, NULL),
(8, 'admin_sem8', 'jon', '$2y$10$T046fPs86yQuyasu/UvSaeT4CJQfaWe928SGmEvAgtqXOKiLSaul2', '8', '', '', 0, NULL),
(9, 'SuperAdmin@12345678', 'Super Admin', '$2y$10$M/Zju/W0vUxCBnabiaaAwu8zZzn30bhWuCM5iO7ODZspzH5y1QKma', 'all', '', '', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_add_contain`
--

CREATE TABLE `admin_add_contain` (
  `sr_no` int(11) NOT NULL,
  `project_domain_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_add_contain`
--

INSERT INTO `admin_add_contain` (`sr_no`, `project_domain_type`) VALUES
(1, 'web dev'),
(2, 'application'),
(3, 'network'),
(6, 'iot'),
(7, 'robotc'),
(9, 'management');

-- --------------------------------------------------------

--
-- Table structure for table `allocated_project`
--

CREATE TABLE `allocated_project` (
  `id` int(11) NOT NULL,
  `registration_no` varchar(20) DEFAULT NULL,
  `p_id` varchar(20) DEFAULT NULL,
  `fid` varchar(20) DEFAULT NULL,
  `year` varchar(25) NOT NULL,
  `semester` varchar(25) NOT NULL,
  `section` varchar(25) NOT NULL,
  `action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `circular_notices`
--

CREATE TABLE `circular_notices` (
  `id` int(11) NOT NULL,
  `fid` varchar(50) NOT NULL,
  `notice_date` date NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `semester` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `circular_notices`
--

INSERT INTO `circular_notices` (`id`, `fid`, `notice_date`, `title`, `description`, `type`, `semester`) VALUES
(61, '', '2024-12-17', 'student can select the project before 30/12/2025', 'The system checks the current date against the project selection deadline, which is set for December 30, 2025.\r\nIf the student attempts to select a project before the deadline, the system allows the selection process to proceed.\r\nIf the student tries to select a project after the deadline, the system disables the selection process and displays a message notifying the student that the project selection period has ended.', 'faculty', ''),
(62, '', '2024-12-17', 'student can select the project before 30/12/2025', 'The system checks the current date against the project selection deadline, which is set for December 30, 2025. If the student attempts to select a project before the deadline, the system allows the selection process to proceed. If the student tries to select a project after the deadline, the system disables the selection process and displays a message notifying the student that the project selection period has ended.', 'student', ''),
(63, '', '2024-12-17', 'student can select the project before 30/12/2025', 'The system checks the current date against the project selection deadline, which is set for December 30, 2025. If the student attempts to select a project before the deadline, the system allows the selection process to proceed. If the student tries to select a project after the deadline, the system disables the selection process and displays a message notifying the student that the project selection period has ended.', 'all', ''),
(64, 'muj2028', '2024-12-17', 'Bhavesh', 'fehjgyu', '', '5'),
(67, 'muj2028', '2025-01-16', 'aghgfc', 'asdfghgc', '', 'All S'),
(68, 'muj2026', '2025-01-19', 'yygtfrdes', 'tgrfedws', '', 'All S'),
(70, 'muj2027', '2025-01-19', 'Submit Project Title', 'Select your Project', '', 'All S'),
(71, 'muj2027', '2025-01-19', 'n3', 'efse', '', '5'),
(72, 'muj2027', '2025-01-19', 'kjwndjb', 'dj3nkqj', '', '6'),
(73, 'muj2027', '2025-01-19', 'kjwndjb', 'dj3nkqj', '', '6'),
(74, 'muj2024', '2025-01-19', 'hbgfd', 'jyhntbgvfd', '', '3');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `sr_no` int(11) NOT NULL,
  `fid` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `specialization` varchar(50) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `lock_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`sr_no`, `fid`, `password`, `fname`, `email`, `mobile`, `specialization`, `designation`, `image`, `failed_attempts`, `lock_until`) VALUES
(1094, 'MUJ0134', '$2y$10$Ne.q.ZJv0mAsSLCAa0lnqupLK3VwhywgV8bx1DoxlXI8sKp2ldRse', 'Dr. Sumit Srivastava', 'sumit.srivastava@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1095, 'MUJ0852', '$2y$10$JLwZAZvKoX87mhdpWCVZ5eNk41t3AkiwtUDyfECamTHvuVTQftIZC', 'Dr Pankaj Vyas', 'pankaj.vyas@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1096, 'MUJ0165', '$2y$10$c604.URfDyojlxV9CFxm7eoyQkYnxGxqaEUUBAUjAXomRRx64oPAW', 'Dr. Devesh Kumar Srivastava', 'devesh.srivastava@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1097, 'MUJ0706', '$2y$10$3pIIKaiprT6.gkvL8ae9r.AMu4g3Abl7HVvElBbyhv7ABOteK5tSO', 'Dr. Pratistha Mathur', 'pratistha.mathur@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1098, 'MUJ1022', '$2y$10$FBxmLvOXxc/W99YFRkCB0uquxN0KojKRHbUCOuTvc5RYK7HLwfPJO', 'Dr. Nripendra Narayan Das', 'nripendranarayan.das@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1099, 'MUJ0874', '$2y$10$YKhzuvFa03X/TDanz7T80eMNAJga.i/38ky8MhYJ5RE6bIGWIEZjy', 'Dr. Narendra Singh Yadav', 'narendrasingh.yadav@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1100, 'MUJ0633', '$2y$10$.Sd1OipgTQHRonlAezQ4VOXXp8cV4.P0sbL/K2GyZ.6aMq6sK8pru', 'Dr. Anju Yadav', 'anju.yadav@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1101, 'MUJ0688', '$2y$10$kNuevUua7qfFgvYndulPbugxJs9nIXSBRNOFpFD772ZufFq6DNOGy', 'Dr. Ashish Jain', 'ashish.jain@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1102, 'MUJ1023', '$2y$10$5haT4Nw.KPj.br.H0eDBouXY/.Aa6zFpzj6DpSh1DAFgF6PlMMdXS', 'Dr. Prakash Chandra Sharma', 'prakashchandra.sharma@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1103, 'MUJ0557', '$2y$10$b4OwpGamCjMgL/XjkTdVZO7zJk8bP7Rj/5RAx5jevlMfPNLAS3R.C', 'Dr. Vivek Kumar Verma', 'vivekkumar.verma@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1104, 'MUJ0139', '$2y$10$CCdhf.yNos9EAKiBn2x.ounUGEugIz/8flw4t9XR8.X7UfRAYBvK.', 'Dr. Lokesh Sharma', 'lokesh.sharma@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1105, 'MUJ1068', '$2y$10$kZWG81.DCKNN6WuWG.AeL.4g9hOaJGQ2Ffgtb9wX3c17Q7BKj3XZi', 'Dr. Nirmal Kumar Gupta', 'nirmalkumar.gupta@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1106, 'MUJ0861', '$2y$10$uTg760psEr1tcRlpbItrDOYPohB3Yuyzu6XNy2jUzjDN9h7NFv4cW', 'Dr. Sulabh Bansal', 'sulabh.bansal@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1107, 'MUJ1148', '$2y$10$smyB0zUepf9EKkJPBFIBde/IqX0NYMDoNcsy7tOGloHgtyO9SNs5O', 'Dr. Shalini Puri', 'shalini.puri@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1108, 'MUJ0406', '$2y$10$ke8AsAK1sCG4B7V7SkhNB.3VPRX8.Q06l0TP8lN..5vvACwSfwKVm', 'Dr. Krishna Kumar', 'krishna.kumar@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1109, 'MUJ1389', '$2y$10$JgIsDmXkrkLrXRPeGcsF4OEPUlkXBSbc93ICZ2g2FeGzFQj/jSrIe', 'Dr. Ganpat Singh Chauhan', 'ganpat.chauhan@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1110, 'MUJ1092', '$2y$10$p3lzxEqWqAIyjFMRmvOf3eo0/tAVC8OXOTR2HVRYBeisgOVFaB2Fm', 'Ms. Smaranika Mohapatra', 'smaranika.mohapatra@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1111, 'MUJ1755', '$2y$10$H3Vcpz94AxDpvNjOgusoAOldqdmq9B1ysZJ5IRjzcAkpqiFwKt5J6', 'Dr. Varsha Himthani', 'varsha.himthani@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1112, 'MUJ0738', '$2y$10$5cnRGXJZAdRIYp0ulxHuS.QY/H4ezVpwWzBglQRDgUNm6gI9OMXTK', 'Ms. Vineeta Soni', 'Vineeta.soni@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1113, 'MUJ0627', '$2y$10$zYir23KvcKyeMF0PP4JNKuO7M.6jfefyLf571SiDjd4rgwUVJuTcO', 'Mr. Ankit Mundra', 'ankit.mundra@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1114, 'MUJ0703', '$2y$10$E1eX97RaEJG6d16TT8.a3.5op9VBPq5LV2B0Frg2ztq8ETGnRTnRi', 'Mr. Anurag Bhatnagar', 'anurag.bhatnagar@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1115, 'MUJ1732', '$2y$10$I2ifVEgbKNCf4m4iROP4HuO9LfHNcVnMYQv3cgd3Qzhde19jaxsm6', 'Mr. Chandrapal Singh Dangi', 'chandrapalsingh.dangi@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1116, 'MUJ0724', '$2y$10$fDmZtf14n6BLTrzS2tgytuyuKpF6GwqBSCyR.KmqYr12mBoTSz1fe', 'Dr. Kavita', 'kavita.Jhajharia@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1117, 'MUJ0521', '$2y$10$GMRP1Bc4HY.8NKj8yxxiguSdIC461RlnjoJuhCO/caYhF3tbXdmvy', 'Dr. Rahul Saxena', 'rahul.saxena@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1118, 'MUJ0566', '$2y$10$jx1rU/62kPs5Uu4Q0szUKeLcba7jrhjaeCI.vz7U45wuCfXphZQ8u', 'Mr. Ravinder Kumar', 'ravinder.kumar@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1119, 'MUJ1767', '$2y$10$g4aIbbM3LYSUydaQbdFq9./8grcKiQFK9kBGQLQk7dMND3tNIgOcq', 'Mr. Ravindra Kumar Saini', 'ravinderkumar.saini@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1120, 'MUJ0400', '$2y$10$DL5VtllGXUXf748k5hxq8O7uFmfFLtuOotLDvxAUb6paLX9lu8ibu', 'Mr. Rohit Kumar Gupta', 'rohitkumar.gupta@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1121, 'MUJ1396', '$2y$10$5ag95e46lkjsE9T.oNBupeE19Usv.hKZQXzNn/cb6KpFxODZnpmJe', 'Dr. Shikha Chaudhary', 'shikha.chaudhary@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1122, 'MUJ0607', '$2y$10$jmPcGIhQ.UYtO3WfcWL66.9kBqt4RsqOBzHHSBMru5UOuKhTKHUhW', 'Mr. Venkatesh Gauri Shankar', 'venkateshg.shankar@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1123, 'MUJ0287', '$2y$10$hrsX/8EUmpCWtYQPfk9QsOAiu0EdgKL74hB.LmWWx2nIoRSqSPHIG', 'Mr. Virendra Dehru', 'virender.dehru@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1124, 'MUJ1041', '$2y$10$rfLnQSqK2J4cyTBPDDjF7OA3fikzrk7q42EIYgWCe5BqilD2mlX22', 'Mr. Vijay Prakash Sharma', 'vijay.sharma@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1125, 'MUJ1149', '$2y$10$wJPRi5clZUbW.WbR54Wwb.81cUPImAnaoIJaao2qROapEOJ0AQS7C', 'Dr. Avani Sharma', 'avani.sharma@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1126, 'MUJ1509', '$2y$10$8R0JmT2X1lWG0z7clzonG.rCfyotZIsv2uVkJ/HE/.VzsNwdv/Jq2', 'Dr. Bagesh Kumar', 'bagesh.kumar@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1127, 'MUJ1548', '$2y$10$6RARdj.jpxbCxqsEEtlAKOArKLUcZCcs2wrNau/IvvYkrykrXLP6q', 'Dr. Debolina Ghosh', 'debolina.ghosh@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1128, 'MUJ1460', '$2y$10$S.H3qxAy.7y01gzZ54Y3Ye1t8qvHgV8HJzp2qNI23MfrTTjvm6Fyi', 'Dr. Krati Dubey', 'krati.dubey@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1129, 'MUJ1145', '$2y$10$IXQfmPJR5Qxg/6MGh9/u0Oaku2JstqVWcif.khet.T8byynwUJWwu', 'Dr. Shally Vats', 'shally.vats@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1130, 'MUJ1179', '$2y$10$59MsraDmFEGLLxsBLCR6n.8HtDqB6J4h1jMVS97f6FePKcrOhFjwm', 'Dr. Shweta Sharma', 'sharma.shweta@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1131, 'MUJ1744', '$2y$10$4lqrX77sXgVStZa0S/FcBe.EQXRC/4vyjbPGPk0ZyBKYHKcBaIaGq', 'Mr.Suman Saurabh Sarkar', 'suman.sarkar@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1132, 'MUJAD001', '$2y$10$eeIoXB6U/KorYunEONjKSuGm2kqZ5bfdeSeDrrr9y9QcygMFnmiqK', 'Ms. Nandani Sharma', 'nandani.sharma@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1133, 'MUJAD002', '$2y$10$f/vMUIWyzMVibtJEDsuZ8uMrK6hvps9BP5QqxO9WG.sS5mAmbz0gm', 'Ms. Rashmi Bartwal', 'rashmi.bartwal@jaipur.manipal.edu', '', '', '', NULL, 0, NULL),
(1134, 'MUJAD015', '$2y$10$4V1uBB.XZ4..uX2cZnGyounC1Kwt1AYVrFvwXiqHpjM.4woI5kqzG', 'Mr. Yogender Kumar Sharma', 'yogender.sharma@jaipur.manipal.edu', '', '', '', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `registration_no` varchar(255) NOT NULL,
  `ticket_id` varchar(255) NOT NULL,
  `fid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `registration_no`, `ticket_id`, `fid`, `name`, `email`, `message`, `submitted_at`, `status`) VALUES
(61, '229302650', '9367410666', '', 'RAKESH SAVALRAM MALI', 'rakesh.229302650@muj.manipal.edu', 'dfvgbhnjmk,l', '2025-01-31 04:54:10', ''),
(62, '', '6911774587', 'MUJ0134', 'Dr. Sumit Srivastava', 'sumit.srivastava@jaipur.manipal.edu', '3tyuiouyt', '2025-01-31 09:14:49', ''),
(63, '', '7032267088', 'MUJ0134', 'Dr. Sumit Srivastava', 'sumit.srivastava@jaipur.manipal.edu', 'uhygfds', '2025-01-31 09:21:38', 'Solved'),
(64, '', '5067134816', 'MUJ0134', 'Dr. Sumit Srivastava', 'sumit.srivastava@jaipur.manipal.edu', 'uhygfds', '2025-01-31 09:22:02', ''),
(65, '', '4938687199', 'MUJ0134', 'Dr. Sumit Srivastava', 'sumit.srivastava@jaipur.manipal.edu', 'uhygfds', '2025-01-31 09:28:56', ''),
(66, '', '7540064793', 'MUJ0134', 'Dr. Sumit Srivastava', 'sumit.srivastava@jaipur.manipal.edu', 'uhygfds', '2025-01-31 09:31:05', ''),
(67, '229302650', '2248496693', '', 'RAKESH SAVALRAM MALI', 'rakesh.229302650@muj.manipal.edu', 'polkumjhngvfcds', '2025-01-31 14:01:22', ''),
(68, '229302647', '9742097269', '', 'BHAVESH BADHE', 'bhavesh.229302647@muj.manipal.edu', 'Nice :)', '2025-02-01 15:22:37', '');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `registration_no` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `p_id` varchar(15) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `semester` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `registration_no`, `message`, `p_id`, `datetime`, `semester`) VALUES
(5442, '2293026001', 'Project ID: 4181998621 has been Allowed.', '4181998621', '2025-01-22 14:49:33', ''),
(5443, '2293026023', 'Admin has allocated you to project ID: 4181998621', '4181998621', '2025-01-22 20:07:22', '6'),
(5444, '2293026002', 'Admin has allocated you to project ID: 4495632934', '4495632934', '2025-01-22 20:07:22', '6'),
(5445, '2293026047', 'Admin has allocated you to project ID: 4495632934', '4495632934', '2025-01-22 20:07:22', '6'),
(5446, '2293026039', 'Admin has allocated you to project ID: 4495632934', '4495632934', '2025-01-22 20:07:22', '6'),
(5447, '2293026025', 'Admin has allocated you to project ID: 6006116016', '6006116016', '2025-01-22 20:07:22', '6'),
(5448, '2293026006', 'Admin has allocated you to project ID: 6006116016', '6006116016', '2025-01-22 20:07:22', '6'),
(5449, '2293026034', 'Admin has allocated you to project ID: 6006116016', '6006116016', '2025-01-22 20:07:22', '6'),
(5450, '2293026004', 'Admin has allocated you to project ID: 6006116016', '6006116016', '2025-01-22 20:07:22', '6'),
(5451, '2293026028', 'Admin has allocated you to project ID: 6784320191', '6784320191', '2025-01-22 20:07:22', '6'),
(5452, '2293026010', 'Admin has allocated you to project ID: 6784320191', '6784320191', '2025-01-22 20:07:22', '6'),
(5453, '2293026032', 'Admin has allocated you to project ID: 8774432226', '8774432226', '2025-01-22 20:07:22', '6'),
(5454, '2293026018', 'Admin has allocated you to project ID: 8774432226', '8774432226', '2025-01-22 20:07:22', '6'),
(5455, '2293026038', 'Admin has allocated you to project ID: 8774432226', '8774432226', '2025-01-22 20:07:22', '6'),
(5456, '2293026019', 'Admin has allocated you to project ID: 9340235619', '9340235619', '2025-01-22 20:07:22', '6'),
(5457, '2293026043', 'Admin has allocated you to project ID: 9340235619', '9340235619', '2025-01-22 20:07:22', '6'),
(5458, '2293026009', 'Project ID: 3402731165 has been Allowed.', '3402731165', '2025-01-22 21:19:17', ''),
(16131, '229202021', 'Admin has allocated you to project ID: 1000722704', '1000722704', '2025-02-02 11:54:20', '6'),
(16132, '229202024', 'Admin has allocated you to project ID: 1004168229', '1004168229', '2025-02-02 11:54:20', '6'),
(16133, '229202031', 'Admin has allocated you to project ID: 1004532500', '1004532500', '2025-02-02 11:54:20', '6'),
(16134, '229202037', 'Admin has allocated you to project ID: 1048603321', '1048603321', '2025-02-02 11:54:20', '6'),
(16135, '229202040', 'Admin has allocated you to project ID: 1057996662', '1057996662', '2025-02-02 11:54:20', '6'),
(16136, '229202057', 'Admin has allocated you to project ID: 1095420126', '1095420126', '2025-02-02 11:54:20', '6'),
(16137, '229209007', 'Admin has allocated you to project ID: 1160738827', '1160738827', '2025-02-02 11:54:20', '6'),
(16138, '229209011', 'Admin has allocated you to project ID: 1193767543', '1193767543', '2025-02-02 11:54:20', '6'),
(16139, '229302001', 'Admin has allocated you to project ID: 1204897329', '1204897329', '2025-02-02 11:54:20', '6'),
(16140, '229302003', 'Admin has allocated you to project ID: 1239326951', '1239326951', '2025-02-02 11:54:20', '6'),
(16141, '229302004', 'Admin has allocated you to project ID: 1289995718', '1289995718', '2025-02-02 11:54:20', '6'),
(16142, '229302006', 'Admin has allocated you to project ID: 1295100160', '1295100160', '2025-02-02 11:54:20', '6'),
(16143, '229302008', 'Admin has allocated you to project ID: 1299509120', '1299509120', '2025-02-02 11:54:20', '6'),
(16144, '229302009', 'Admin has allocated you to project ID: 1370661456', '1370661456', '2025-02-02 11:54:20', '6'),
(16145, '229302010', 'Admin has allocated you to project ID: 1390303994', '1390303994', '2025-02-02 11:54:20', '6'),
(16146, '229302013', 'Admin has allocated you to project ID: 1391472287', '1391472287', '2025-02-02 11:54:20', '6'),
(16147, '229302014', 'Admin has allocated you to project ID: 1410988875', '1410988875', '2025-02-02 11:54:20', '6'),
(16148, '229302016', 'Admin has allocated you to project ID: 1436296549', '1436296549', '2025-02-02 11:54:20', '6'),
(16149, '229302017', 'Admin has allocated you to project ID: 1450816962', '1450816962', '2025-02-02 11:54:20', '6'),
(16150, '229302018', 'Admin has allocated you to project ID: 1455075141', '1455075141', '2025-02-02 11:54:20', '6'),
(16151, '229302019', 'Admin has allocated you to project ID: 1465412368', '1465412368', '2025-02-02 11:54:20', '6'),
(16152, '229302020', 'Admin has allocated you to project ID: 1501518340', '1501518340', '2025-02-02 11:54:20', '6'),
(16153, '229302021', 'Admin has allocated you to project ID: 1529020613', '1529020613', '2025-02-02 11:54:20', '6'),
(16154, '229302022', 'Admin has allocated you to project ID: 1593392517', '1593392517', '2025-02-02 11:54:20', '6'),
(16155, '229302023', 'Admin has allocated you to project ID: 1613916785', '1613916785', '2025-02-02 11:54:20', '6'),
(16156, '229302024', 'Admin has allocated you to project ID: 1654890274', '1654890274', '2025-02-02 11:54:20', '6'),
(16157, '229302026', 'Admin has allocated you to project ID: 1673331600', '1673331600', '2025-02-02 11:54:20', '6'),
(16158, '229302027', 'Admin has allocated you to project ID: 1703107926', '1703107926', '2025-02-02 11:54:20', '6'),
(16159, '229302028', 'Admin has allocated you to project ID: 1730425058', '1730425058', '2025-02-02 11:54:20', '6'),
(16160, '229302029', 'Admin has allocated you to project ID: 1744761981', '1744761981', '2025-02-02 11:54:20', '6'),
(16161, '229302030', 'Admin has allocated you to project ID: 1789688240', '1789688240', '2025-02-02 11:54:20', '6'),
(16162, '229302031', 'Admin has allocated you to project ID: 1790264748', '1790264748', '2025-02-02 11:54:20', '6'),
(16163, '229302032', 'Admin has allocated you to project ID: 1795913974', '1795913974', '2025-02-02 11:54:20', '6'),
(16164, '229302033', 'Admin has allocated you to project ID: 1827411362', '1827411362', '2025-02-02 11:54:20', '6'),
(16165, '229302034', 'Admin has allocated you to project ID: 1827932266', '1827932266', '2025-02-02 11:54:20', '6'),
(16166, '229302035', 'Admin has allocated you to project ID: 1862977792', '1862977792', '2025-02-02 11:54:20', '6'),
(16167, '229302036', 'Admin has allocated you to project ID: 1871004047', '1871004047', '2025-02-02 11:54:20', '6'),
(16168, '229302037', 'Admin has allocated you to project ID: 1875602825', '1875602825', '2025-02-02 11:54:20', '6'),
(16169, '229302038', 'Admin has allocated you to project ID: 1881294093', '1881294093', '2025-02-02 11:54:20', '6'),
(16170, '229302039', 'Admin has allocated you to project ID: 1904502279', '1904502279', '2025-02-02 11:54:20', '6'),
(16171, '229302046', 'Admin has allocated you to project ID: 1914665233', '1914665233', '2025-02-02 11:54:20', '6'),
(16172, '229302047', 'Admin has allocated you to project ID: 1925267654', '1925267654', '2025-02-02 11:54:20', '6'),
(16173, '229302048', 'Admin has allocated you to project ID: 1929221748', '1929221748', '2025-02-02 11:54:20', '6'),
(16174, '229302051', 'Admin has allocated you to project ID: 1940736610', '1940736610', '2025-02-02 11:54:20', '6'),
(16175, '229302055', 'Admin has allocated you to project ID: 1999942730', '1999942730', '2025-02-02 11:54:20', '6'),
(16176, '229302056', 'Admin has allocated you to project ID: 2006469699', '2006469699', '2025-02-02 11:54:20', '6'),
(16177, '229302057', 'Admin has allocated you to project ID: 2050388281', '2050388281', '2025-02-02 11:54:20', '6'),
(16178, '229302058', 'Admin has allocated you to project ID: 2055364848', '2055364848', '2025-02-02 11:54:20', '6'),
(16179, '229302060', 'Admin has allocated you to project ID: 2081466661', '2081466661', '2025-02-02 11:54:20', '6'),
(16180, '229302061', 'Admin has allocated you to project ID: 2100530822', '2100530822', '2025-02-02 11:54:20', '6'),
(16181, '229302062', 'Admin has allocated you to project ID: 2105391311', '2105391311', '2025-02-02 11:54:20', '6'),
(16182, '229302063', 'Admin has allocated you to project ID: 2105875587', '2105875587', '2025-02-02 11:54:20', '6'),
(16183, '229302065', 'Admin has allocated you to project ID: 2110057545', '2110057545', '2025-02-02 11:54:20', '6'),
(16184, '229302066', 'Admin has allocated you to project ID: 2111818423', '2111818423', '2025-02-02 11:54:20', '6'),
(16185, '229302070', 'Admin has allocated you to project ID: 2136001118', '2136001118', '2025-02-02 11:54:20', '6'),
(16186, '229302114', 'Admin has allocated you to project ID: 2152255917', '2152255917', '2025-02-02 11:54:20', '6'),
(16187, '229302133', 'Admin has allocated you to project ID: 2160011903', '2160011903', '2025-02-02 11:54:20', '6'),
(16188, '229302265', 'Admin has allocated you to project ID: 2163595868', '2163595868', '2025-02-02 11:54:20', '6'),
(16189, '229302449', 'Admin has allocated you to project ID: 2170753809', '2170753809', '2025-02-02 11:54:20', '6'),
(16190, '229302652', 'Admin has allocated you to project ID: 2185073266', '2185073266', '2025-02-02 11:54:20', '6'),
(16191, '229301218', 'Admin has allocated you to project ID: 2193483520', '2193483520', '2025-02-02 11:54:20', '6'),
(16192, '229302011', 'Admin has allocated you to project ID: 2203292003', '2203292003', '2025-02-02 11:54:20', '6'),
(16193, '229302068', 'Admin has allocated you to project ID: 2211838782', '2211838782', '2025-02-02 11:54:20', '6'),
(16194, '229302072', 'Admin has allocated you to project ID: 2229896395', '2229896395', '2025-02-02 11:54:20', '6'),
(16195, '229302074', 'Admin has allocated you to project ID: 2248940334', '2248940334', '2025-02-02 11:54:20', '6'),
(16196, '229302075', 'Admin has allocated you to project ID: 2252173728', '2252173728', '2025-02-02 11:54:20', '6'),
(16197, '229302077', 'Admin has allocated you to project ID: 2252263646', '2252263646', '2025-02-02 11:54:20', '6'),
(16198, '229302078', 'Admin has allocated you to project ID: 2256208932', '2256208932', '2025-02-02 11:54:20', '6'),
(16199, '229302079', 'Admin has allocated you to project ID: 2266711865', '2266711865', '2025-02-02 11:54:20', '6'),
(16200, '229302080', 'Admin has allocated you to project ID: 2295675692', '2295675692', '2025-02-02 11:54:20', '6'),
(16201, '229302081', 'Admin has allocated you to project ID: 2296958783', '2296958783', '2025-02-02 11:54:20', '6'),
(16202, '229302084', 'Admin has allocated you to project ID: 2300748991', '2300748991', '2025-02-02 11:54:20', '6'),
(16203, '229302086', 'Admin has allocated you to project ID: 2328109853', '2328109853', '2025-02-02 11:54:20', '6'),
(16204, '229302087', 'Admin has allocated you to project ID: 2344315932', '2344315932', '2025-02-02 11:54:20', '6'),
(16205, '229302088', 'Admin has allocated you to project ID: 2350009692', '2350009692', '2025-02-02 11:54:20', '6'),
(16206, '229302090', 'Admin has allocated you to project ID: 2352656613', '2352656613', '2025-02-02 11:54:20', '6'),
(16207, '229302092', 'Admin has allocated you to project ID: 2360335985', '2360335985', '2025-02-02 11:54:20', '6'),
(16208, '229302093', 'Admin has allocated you to project ID: 2370764421', '2370764421', '2025-02-02 11:54:20', '6'),
(16209, '229302095', 'Admin has allocated you to project ID: 2375091197', '2375091197', '2025-02-02 11:54:20', '6'),
(16210, '229302096', 'Admin has allocated you to project ID: 2379477550', '2379477550', '2025-02-02 11:54:20', '6'),
(16211, '229302097', 'Admin has allocated you to project ID: 2393125230', '2393125230', '2025-02-02 11:54:20', '6'),
(16212, '229302101', 'Admin has allocated you to project ID: 2395562325', '2395562325', '2025-02-02 11:54:20', '6'),
(16213, '229302102', 'Admin has allocated you to project ID: 2417921598', '2417921598', '2025-02-02 11:54:20', '6'),
(16214, '229302104', 'Admin has allocated you to project ID: 2430872752', '2430872752', '2025-02-02 11:54:20', '6'),
(16215, '229302107', 'Admin has allocated you to project ID: 2456265185', '2456265185', '2025-02-02 11:54:20', '6'),
(16216, '229302108', 'Admin has allocated you to project ID: 2478659036', '2478659036', '2025-02-02 11:54:20', '6'),
(16217, '229302109', 'Admin has allocated you to project ID: 2488548413', '2488548413', '2025-02-02 11:54:20', '6'),
(16218, '229302111', 'Admin has allocated you to project ID: 2518854799', '2518854799', '2025-02-02 11:54:20', '6'),
(16219, '229302112', 'Admin has allocated you to project ID: 2533206491', '2533206491', '2025-02-02 11:54:20', '6'),
(16220, '229302115', 'Admin has allocated you to project ID: 2535629351', '2535629351', '2025-02-02 11:54:20', '6'),
(16221, '229302116', 'Admin has allocated you to project ID: 2540188032', '2540188032', '2025-02-02 11:54:20', '6'),
(16222, '229302117', 'Admin has allocated you to project ID: 2554168529', '2554168529', '2025-02-02 11:54:20', '6'),
(16223, '229302119', 'Admin has allocated you to project ID: 2557905500', '2557905500', '2025-02-02 11:54:20', '6'),
(16224, '229302120', 'Admin has allocated you to project ID: 2626945784', '2626945784', '2025-02-02 11:54:20', '6'),
(16225, '229302122', 'Admin has allocated you to project ID: 2649218889', '2649218889', '2025-02-02 11:54:20', '6'),
(16226, '229302125', 'Admin has allocated you to project ID: 2664413302', '2664413302', '2025-02-02 11:54:20', '6'),
(16227, '229302127', 'Admin has allocated you to project ID: 2664497700', '2664497700', '2025-02-02 11:54:20', '6'),
(16228, '229302128', 'Admin has allocated you to project ID: 2688184772', '2688184772', '2025-02-02 11:54:20', '6'),
(16229, '229302131', 'Admin has allocated you to project ID: 2708541558', '2708541558', '2025-02-02 11:54:20', '6'),
(16230, '229302134', 'Admin has allocated you to project ID: 2742911806', '2742911806', '2025-02-02 11:54:20', '6'),
(16231, '229302135', 'Admin has allocated you to project ID: 2838139683', '2838139683', '2025-02-02 11:54:20', '6'),
(16232, '229302137', 'Admin has allocated you to project ID: 2862096622', '2862096622', '2025-02-02 11:54:20', '6'),
(16233, '229302139', 'Admin has allocated you to project ID: 2938311649', '2938311649', '2025-02-02 11:54:20', '6'),
(16234, '229302140', 'Admin has allocated you to project ID: 2944338793', '2944338793', '2025-02-02 11:54:20', '6'),
(16235, '229302143', 'Admin has allocated you to project ID: 2946931374', '2946931374', '2025-02-02 11:54:20', '6'),
(16236, '229302144', 'Admin has allocated you to project ID: 2965595500', '2965595500', '2025-02-02 11:54:20', '6'),
(16237, '229302148', 'Admin has allocated you to project ID: 2975208425', '2975208425', '2025-02-02 11:54:20', '6'),
(16238, '229302149', 'Admin has allocated you to project ID: 2995086154', '2995086154', '2025-02-02 11:54:20', '6'),
(16239, '229302152', 'Admin has allocated you to project ID: 3023434922', '3023434922', '2025-02-02 11:54:20', '6'),
(16240, '229302155', 'Admin has allocated you to project ID: 3023520664', '3023520664', '2025-02-02 11:54:20', '6'),
(16241, '229302156', 'Admin has allocated you to project ID: 3043036303', '3043036303', '2025-02-02 11:54:20', '6'),
(16242, '229302158', 'Admin has allocated you to project ID: 3045327022', '3045327022', '2025-02-02 11:54:20', '6'),
(16243, '229302159', 'Admin has allocated you to project ID: 3062011550', '3062011550', '2025-02-02 11:54:20', '6'),
(16244, '229302162', 'Admin has allocated you to project ID: 3067597182', '3067597182', '2025-02-02 11:54:20', '6'),
(16245, '229302163', 'Admin has allocated you to project ID: 3086246613', '3086246613', '2025-02-02 11:54:20', '6'),
(16246, '229302165', 'Admin has allocated you to project ID: 3099598556', '3099598556', '2025-02-02 11:54:20', '6'),
(16247, '229302166', 'Admin has allocated you to project ID: 3112399828', '3112399828', '2025-02-02 11:54:20', '6'),
(16248, '229302167', 'Admin has allocated you to project ID: 3154793006', '3154793006', '2025-02-02 11:54:20', '6'),
(16249, '229302168', 'Admin has allocated you to project ID: 3193854094', '3193854094', '2025-02-02 11:54:20', '6'),
(16250, '229302171', 'Admin has allocated you to project ID: 3310859314', '3310859314', '2025-02-02 11:54:20', '6'),
(16251, '229302172', 'Admin has allocated you to project ID: 3318796875', '3318796875', '2025-02-02 11:54:20', '6'),
(16252, '229302654', 'Admin has allocated you to project ID: 3343781853', '3343781853', '2025-02-02 11:54:20', '6'),
(16253, '229302173', 'Admin has allocated you to project ID: 3394127040', '3394127040', '2025-02-02 11:54:20', '6'),
(16254, '229302176', 'Admin has allocated you to project ID: 3397807961', '3397807961', '2025-02-02 11:54:20', '6'),
(16255, '229302177', 'Admin has allocated you to project ID: 3398830066', '3398830066', '2025-02-02 11:54:20', '6'),
(16256, '229302178', 'Admin has allocated you to project ID: 3407193427', '3407193427', '2025-02-02 11:54:20', '6'),
(16257, '229302179', 'Admin has allocated you to project ID: 3457876220', '3457876220', '2025-02-02 11:54:20', '6'),
(16258, '229302183', 'Admin has allocated you to project ID: 3459987023', '3459987023', '2025-02-02 11:54:20', '6'),
(16259, '229302186', 'Admin has allocated you to project ID: 3468797249', '3468797249', '2025-02-02 11:54:20', '6'),
(16260, '229302187', 'Admin has allocated you to project ID: 3485090444', '3485090444', '2025-02-02 11:54:20', '6'),
(16261, '229302189', 'Admin has allocated you to project ID: 3516295613', '3516295613', '2025-02-02 11:54:20', '6'),
(16262, '229302190', 'Admin has allocated you to project ID: 3526302397', '3526302397', '2025-02-02 11:54:20', '6'),
(16263, '229302191', 'Admin has allocated you to project ID: 3537730588', '3537730588', '2025-02-02 11:54:20', '6'),
(16264, '229302194', 'Admin has allocated you to project ID: 3538066755', '3538066755', '2025-02-02 11:54:20', '6'),
(16265, '229302196', 'Admin has allocated you to project ID: 3565412116', '3565412116', '2025-02-02 11:54:20', '6'),
(16266, '229302197', 'Admin has allocated you to project ID: 3603987043', '3603987043', '2025-02-02 11:54:20', '6'),
(16267, '229302199', 'Admin has allocated you to project ID: 3608614540', '3608614540', '2025-02-02 11:54:20', '6'),
(16268, '229302200', 'Admin has allocated you to project ID: 3626211158', '3626211158', '2025-02-02 11:54:20', '6'),
(16269, '229302201', 'Admin has allocated you to project ID: 3637935044', '3637935044', '2025-02-02 11:54:20', '6'),
(16270, '229302204', 'Admin has allocated you to project ID: 3653042122', '3653042122', '2025-02-02 11:54:20', '6'),
(16271, '229302205', 'Admin has allocated you to project ID: 3664624295', '3664624295', '2025-02-02 11:54:20', '6'),
(16272, '229302206', 'Admin has allocated you to project ID: 3672856585', '3672856585', '2025-02-02 11:54:20', '6'),
(16273, '229302207', 'Admin has allocated you to project ID: 3681264226', '3681264226', '2025-02-02 11:54:20', '6'),
(16274, '229302208', 'Admin has allocated you to project ID: 3690007198', '3690007198', '2025-02-02 11:54:20', '6'),
(16275, '229302209', 'Admin has allocated you to project ID: 3700967370', '3700967370', '2025-02-02 11:54:20', '6'),
(16276, '229302211', 'Admin has allocated you to project ID: 3716198305', '3716198305', '2025-02-02 11:54:20', '6'),
(16277, '229302215', 'Admin has allocated you to project ID: 3718741560', '3718741560', '2025-02-02 11:54:20', '6'),
(16278, '229302217', 'Admin has allocated you to project ID: 3731467086', '3731467086', '2025-02-02 11:54:20', '6'),
(16279, '229302220', 'Admin has allocated you to project ID: 3734800369', '3734800369', '2025-02-02 11:54:20', '6'),
(16280, '229302221', 'Admin has allocated you to project ID: 3808545010', '3808545010', '2025-02-02 11:54:20', '6'),
(16281, '229302222', 'Admin has allocated you to project ID: 3831235179', '3831235179', '2025-02-02 11:54:20', '6'),
(16282, '229302223', 'Admin has allocated you to project ID: 3910659599', '3910659599', '2025-02-02 11:54:20', '6'),
(16283, '229302227', 'Admin has allocated you to project ID: 3924284505', '3924284505', '2025-02-02 11:54:20', '6'),
(16284, '229302229', 'Admin has allocated you to project ID: 3925738837', '3925738837', '2025-02-02 11:54:20', '6'),
(16285, '229302230', 'Admin has allocated you to project ID: 3938249964', '3938249964', '2025-02-02 11:54:20', '6'),
(16286, '229302231', 'Admin has allocated you to project ID: 3976520190', '3976520190', '2025-02-02 11:54:20', '6'),
(16287, '229302232', 'Admin has allocated you to project ID: 3980740028', '3980740028', '2025-02-02 11:54:20', '6'),
(16288, '229302236', 'Admin has allocated you to project ID: 3987502243', '3987502243', '2025-02-02 11:54:20', '6'),
(16289, '229302237', 'Admin has allocated you to project ID: 3998875926', '3998875926', '2025-02-02 11:54:20', '6'),
(16290, '229302238', 'Admin has allocated you to project ID: 4006297704', '4006297704', '2025-02-02 11:54:20', '6'),
(16291, '229302240', 'Admin has allocated you to project ID: 4022965028', '4022965028', '2025-02-02 11:54:20', '6'),
(16292, '229302242', 'Admin has allocated you to project ID: 4039909901', '4039909901', '2025-02-02 11:54:20', '6'),
(16293, '229302244', 'Admin has allocated you to project ID: 4102771335', '4102771335', '2025-02-02 11:54:20', '6'),
(16294, '229302246', 'Admin has allocated you to project ID: 4107381072', '4107381072', '2025-02-02 11:54:20', '6'),
(16295, '229302251', 'Admin has allocated you to project ID: 4113883817', '4113883817', '2025-02-02 11:54:20', '6'),
(16296, '229302252', 'Admin has allocated you to project ID: 4114265974', '4114265974', '2025-02-02 11:54:20', '6'),
(16297, '229302253', 'Admin has allocated you to project ID: 4142670825', '4142670825', '2025-02-02 11:54:20', '6'),
(16298, '229302254', 'Admin has allocated you to project ID: 4157928780', '4157928780', '2025-02-02 11:54:20', '6'),
(16299, '229302255', 'Admin has allocated you to project ID: 4178249441', '4178249441', '2025-02-02 11:54:20', '6'),
(16300, '229302257', 'Admin has allocated you to project ID: 4178820588', '4178820588', '2025-02-02 11:54:20', '6'),
(16301, '229302259', 'Admin has allocated you to project ID: 4190431401', '4190431401', '2025-02-02 11:54:20', '6'),
(16302, '229302260', 'Admin has allocated you to project ID: 4192655126', '4192655126', '2025-02-02 11:54:20', '6'),
(16303, '229302261', 'Admin has allocated you to project ID: 4199324252', '4199324252', '2025-02-02 11:54:20', '6'),
(16304, '229302262', 'Admin has allocated you to project ID: 4219188682', '4219188682', '2025-02-02 11:54:20', '6'),
(16305, '229302263', 'Admin has allocated you to project ID: 4220079963', '4220079963', '2025-02-02 11:54:20', '6'),
(16306, '229302266', 'Admin has allocated you to project ID: 4228686369', '4228686369', '2025-02-02 11:54:20', '6'),
(16307, '229302268', 'Admin has allocated you to project ID: 4238853605', '4238853605', '2025-02-02 11:54:20', '6'),
(16308, '229302269', 'Admin has allocated you to project ID: 4280244946', '4280244946', '2025-02-02 11:54:20', '6'),
(16309, '229302272', 'Admin has allocated you to project ID: 4292688356', '4292688356', '2025-02-02 11:54:20', '6'),
(16310, '229302274', 'Admin has allocated you to project ID: 4368619381', '4368619381', '2025-02-02 11:54:20', '6'),
(16311, '229302275', 'Admin has allocated you to project ID: 4396097061', '4396097061', '2025-02-02 11:54:20', '6'),
(16312, '229302276', 'Admin has allocated you to project ID: 4403602182', '4403602182', '2025-02-02 11:54:20', '6'),
(16313, '229302299', 'Admin has allocated you to project ID: 4414253569', '4414253569', '2025-02-02 11:54:20', '6'),
(16314, '229302651', 'Admin has allocated you to project ID: 4428368762', '4428368762', '2025-02-02 11:54:20', '6'),
(16315, '229302239', 'Admin has allocated you to project ID: 4464430878', '4464430878', '2025-02-02 11:54:20', '6'),
(16316, '229302277', 'Admin has allocated you to project ID: 4487512915', '4487512915', '2025-02-02 11:54:20', '6'),
(16317, '229302278', 'Admin has allocated you to project ID: 4495169113', '4495169113', '2025-02-02 11:54:20', '6'),
(16318, '229302279', 'Admin has allocated you to project ID: 4535814350', '4535814350', '2025-02-02 11:54:20', '6'),
(16319, '229302282', 'Admin has allocated you to project ID: 4563711359', '4563711359', '2025-02-02 11:54:20', '6'),
(16320, '229302284', 'Admin has allocated you to project ID: 4587644476', '4587644476', '2025-02-02 11:54:20', '6'),
(16321, '229302285', 'Admin has allocated you to project ID: 4601744490', '4601744490', '2025-02-02 11:54:20', '6'),
(16322, '229302286', 'Admin has allocated you to project ID: 4602214620', '4602214620', '2025-02-02 11:54:20', '6'),
(16323, '229302290', 'Admin has allocated you to project ID: 4626352144', '4626352144', '2025-02-02 11:54:20', '6'),
(16324, '229302291', 'Admin has allocated you to project ID: 4646295026', '4646295026', '2025-02-02 11:54:20', '6'),
(16325, '229302292', 'Admin has allocated you to project ID: 4648289072', '4648289072', '2025-02-02 11:54:20', '6'),
(16326, '229302293', 'Admin has allocated you to project ID: 4659032267', '4659032267', '2025-02-02 11:54:20', '6'),
(16327, '229302294', 'Admin has allocated you to project ID: 4670001991', '4670001991', '2025-02-02 11:54:20', '6'),
(16328, '229302295', 'Admin has allocated you to project ID: 4676700015', '4676700015', '2025-02-02 11:54:20', '6'),
(16329, '229302297', 'Admin has allocated you to project ID: 4683669119', '4683669119', '2025-02-02 11:54:20', '6'),
(16330, '229302298', 'Admin has allocated you to project ID: 4692939692', '4692939692', '2025-02-02 11:54:20', '6'),
(16331, '229302301', 'Admin has allocated you to project ID: 4729898862', '4729898862', '2025-02-02 11:54:20', '6'),
(16332, '229302302', 'Admin has allocated you to project ID: 4735281282', '4735281282', '2025-02-02 11:54:20', '6'),
(16333, '229302303', 'Admin has allocated you to project ID: 4744359760', '4744359760', '2025-02-02 11:54:20', '6'),
(16334, '229302304', 'Admin has allocated you to project ID: 4770707855', '4770707855', '2025-02-02 11:54:20', '6'),
(16335, '229302305', 'Admin has allocated you to project ID: 4795866484', '4795866484', '2025-02-02 11:54:20', '6'),
(16336, '229302306', 'Admin has allocated you to project ID: 4824828973', '4824828973', '2025-02-02 11:54:20', '6'),
(16337, '229302309', 'Admin has allocated you to project ID: 4849040317', '4849040317', '2025-02-02 11:54:20', '6'),
(16338, '229302310', 'Admin has allocated you to project ID: 4861837688', '4861837688', '2025-02-02 11:54:20', '6'),
(16339, '229302311', 'Admin has allocated you to project ID: 4887622292', '4887622292', '2025-02-02 11:54:20', '6'),
(16340, '229302312', 'Admin has allocated you to project ID: 4892114363', '4892114363', '2025-02-02 11:54:20', '6'),
(16341, '229302314', 'Admin has allocated you to project ID: 4940805896', '4940805896', '2025-02-02 11:54:20', '6'),
(16342, '229302317', 'Admin has allocated you to project ID: 4942061056', '4942061056', '2025-02-02 11:54:20', '6'),
(16343, '229302318', 'Admin has allocated you to project ID: 4956973152', '4956973152', '2025-02-02 11:54:20', '6'),
(16344, '229302319', 'Admin has allocated you to project ID: 4957221761', '4957221761', '2025-02-02 11:54:20', '6'),
(16345, '229302320', 'Admin has allocated you to project ID: 4974186098', '4974186098', '2025-02-02 11:54:20', '6'),
(16346, '229302321', 'Admin has allocated you to project ID: 4980578806', '4980578806', '2025-02-02 11:54:20', '6'),
(16347, '229302323', 'Admin has allocated you to project ID: 4994371122', '4994371122', '2025-02-02 11:54:20', '6'),
(16348, '229302324', 'Admin has allocated you to project ID: 4995543651', '4995543651', '2025-02-02 11:54:20', '6'),
(16349, '229302326', 'Admin has allocated you to project ID: 5001456780', '5001456780', '2025-02-02 11:54:20', '6'),
(16350, '229302329', 'Admin has allocated you to project ID: 5010032558', '5010032558', '2025-02-02 11:54:20', '6'),
(16351, '229302331', 'Admin has allocated you to project ID: 5013902153', '5013902153', '2025-02-02 11:54:20', '6'),
(16352, '229302333', 'Admin has allocated you to project ID: 5043197537', '5043197537', '2025-02-02 11:54:20', '6'),
(16353, '229302335', 'Admin has allocated you to project ID: 5056001394', '5056001394', '2025-02-02 11:54:20', '6'),
(16354, '229302338', 'Admin has allocated you to project ID: 5098852180', '5098852180', '2025-02-02 11:54:20', '6'),
(16355, '229302339', 'Admin has allocated you to project ID: 5103077785', '5103077785', '2025-02-02 11:54:20', '6'),
(16356, '229302340', 'Admin has allocated you to project ID: 5114085394', '5114085394', '2025-02-02 11:54:20', '6'),
(16357, '229302341', 'Admin has allocated you to project ID: 5156153097', '5156153097', '2025-02-02 11:54:20', '6'),
(16358, '229302343', 'Admin has allocated you to project ID: 5171590685', '5171590685', '2025-02-02 11:54:20', '6'),
(16359, '229302344', 'Admin has allocated you to project ID: 5204119206', '5204119206', '2025-02-02 11:54:20', '6'),
(16360, '229302346', 'Admin has allocated you to project ID: 5270324358', '5270324358', '2025-02-02 11:54:20', '6'),
(16361, '229302349', 'Admin has allocated you to project ID: 5288839706', '5288839706', '2025-02-02 11:54:20', '6'),
(16362, '229302350', 'Admin has allocated you to project ID: 5291821919', '5291821919', '2025-02-02 11:54:20', '6'),
(16363, '229302351', 'Admin has allocated you to project ID: 5306479731', '5306479731', '2025-02-02 11:54:20', '6'),
(16364, '229302353', 'Admin has allocated you to project ID: 5349966292', '5349966292', '2025-02-02 11:54:20', '6'),
(16365, '229302355', 'Admin has allocated you to project ID: 5360708451', '5360708451', '2025-02-02 11:54:20', '6'),
(16366, '229302359', 'Admin has allocated you to project ID: 5383163819', '5383163819', '2025-02-02 11:54:20', '6'),
(16367, '229302360', 'Admin has allocated you to project ID: 5385978070', '5385978070', '2025-02-02 11:54:20', '6'),
(16368, '229302362', 'Admin has allocated you to project ID: 5431080430', '5431080430', '2025-02-02 11:54:20', '6'),
(16369, '229302365', 'Admin has allocated you to project ID: 5442586383', '5442586383', '2025-02-02 11:54:20', '6'),
(16370, '229302366', 'Admin has allocated you to project ID: 5449562552', '5449562552', '2025-02-02 11:54:20', '6'),
(16371, '229302367', 'Admin has allocated you to project ID: 5458273832', '5458273832', '2025-02-02 11:54:20', '6'),
(16372, '229302368', 'Admin has allocated you to project ID: 5502538472', '5502538472', '2025-02-02 11:54:20', '6'),
(16373, '229302369', 'Admin has allocated you to project ID: 5510422877', '5510422877', '2025-02-02 11:54:20', '6'),
(16374, '229302371', 'Admin has allocated you to project ID: 5541609710', '5541609710', '2025-02-02 11:54:20', '6'),
(16375, '229302372', 'Admin has allocated you to project ID: 5547368814', '5547368814', '2025-02-02 11:54:20', '6'),
(16376, '229302050', 'Admin has allocated you to project ID: 5555527245', '5555527245', '2025-02-02 11:54:20', '6'),
(16377, '229302373', 'Admin has allocated you to project ID: 5561998262', '5561998262', '2025-02-02 11:54:20', '6'),
(16378, '229302374', 'Admin has allocated you to project ID: 5568136133', '5568136133', '2025-02-02 11:54:20', '6'),
(16379, '229302376', 'Admin has allocated you to project ID: 5579116055', '5579116055', '2025-02-02 11:54:20', '6'),
(16380, '229302377', 'Admin has allocated you to project ID: 5590111920', '5590111920', '2025-02-02 11:54:20', '6'),
(16381, '229302379', 'Admin has allocated you to project ID: 5597099551', '5597099551', '2025-02-02 11:54:20', '6'),
(16382, '229302380', 'Admin has allocated you to project ID: 5603267265', '5603267265', '2025-02-02 11:54:20', '6'),
(16383, '229302381', 'Admin has allocated you to project ID: 5613876835', '5613876835', '2025-02-02 11:54:20', '6'),
(16384, '229302383', 'Admin has allocated you to project ID: 5617854863', '5617854863', '2025-02-02 11:54:20', '6'),
(16385, '229302384', 'Admin has allocated you to project ID: 5618876086', '5618876086', '2025-02-02 11:54:20', '6'),
(16386, '229302385', 'Admin has allocated you to project ID: 5619092115', '5619092115', '2025-02-02 11:54:20', '6'),
(16387, '229302387', 'Admin has allocated you to project ID: 5646611423', '5646611423', '2025-02-02 11:54:20', '6'),
(16388, '229302388', 'Admin has allocated you to project ID: 5649715891', '5649715891', '2025-02-02 11:54:20', '6'),
(16389, '229302390', 'Admin has allocated you to project ID: 5663860487', '5663860487', '2025-02-02 11:54:20', '6'),
(16390, '229302391', 'Admin has allocated you to project ID: 5688924509', '5688924509', '2025-02-02 11:54:20', '6'),
(16391, '229302393', 'Admin has allocated you to project ID: 5705467537', '5705467537', '2025-02-02 11:54:20', '6'),
(16392, '229302395', 'Admin has allocated you to project ID: 5705717039', '5705717039', '2025-02-02 11:54:20', '6'),
(16393, '229302398', 'Admin has allocated you to project ID: 5709228360', '5709228360', '2025-02-02 11:54:20', '6'),
(16394, '229302399', 'Admin has allocated you to project ID: 5724967510', '5724967510', '2025-02-02 11:54:20', '6'),
(16395, '229302400', 'Admin has allocated you to project ID: 5729270656', '5729270656', '2025-02-02 11:54:20', '6'),
(16396, '229302401', 'Admin has allocated you to project ID: 5768873480', '5768873480', '2025-02-02 11:54:20', '6'),
(16397, '229302407', 'Admin has allocated you to project ID: 5826737987', '5826737987', '2025-02-02 11:54:20', '6'),
(16398, '229302408', 'Admin has allocated you to project ID: 5829036468', '5829036468', '2025-02-02 11:54:20', '6'),
(16399, '229302410', 'Admin has allocated you to project ID: 5862703159', '5862703159', '2025-02-02 11:54:20', '6'),
(16400, '229302412', 'Admin has allocated you to project ID: 5895101929', '5895101929', '2025-02-02 11:54:20', '6'),
(16401, '229302414', 'Admin has allocated you to project ID: 5919692801', '5919692801', '2025-02-02 11:54:20', '6'),
(16402, '229302415', 'Admin has allocated you to project ID: 5920611343', '5920611343', '2025-02-02 11:54:20', '6'),
(16403, '229302417', 'Admin has allocated you to project ID: 5946070049', '5946070049', '2025-02-02 11:54:20', '6'),
(16404, '229302420', 'Admin has allocated you to project ID: 5955290809', '5955290809', '2025-02-02 11:54:20', '6'),
(16405, '229302421', 'Admin has allocated you to project ID: 5955339525', '5955339525', '2025-02-02 11:54:20', '6'),
(16406, '229302422', 'Admin has allocated you to project ID: 5956305148', '5956305148', '2025-02-02 11:54:20', '6'),
(16407, '229302423', 'Admin has allocated you to project ID: 5994521512', '5994521512', '2025-02-02 11:54:20', '6'),
(16408, '229302424', 'Admin has allocated you to project ID: 6038310151', '6038310151', '2025-02-02 11:54:20', '6'),
(16409, '229302425', 'Admin has allocated you to project ID: 6057225332', '6057225332', '2025-02-02 11:54:20', '6'),
(16410, '229302427', 'Admin has allocated you to project ID: 6057225649', '6057225649', '2025-02-02 11:54:20', '6'),
(16411, '229302429', 'Admin has allocated you to project ID: 6097089933', '6097089933', '2025-02-02 11:54:20', '6'),
(16412, '229302430', 'Admin has allocated you to project ID: 6158491027', '6158491027', '2025-02-02 11:54:20', '6'),
(16413, '229302431', 'Admin has allocated you to project ID: 6161110956', '6161110956', '2025-02-02 11:54:20', '6'),
(16414, '229302434', 'Admin has allocated you to project ID: 6220041769', '6220041769', '2025-02-02 11:54:20', '6'),
(16415, '229302438', 'Admin has allocated you to project ID: 6230600863', '6230600863', '2025-02-02 11:54:20', '6'),
(16416, '229302441', 'Admin has allocated you to project ID: 6231830234', '6231830234', '2025-02-02 11:54:20', '6'),
(16417, '229302443', 'Admin has allocated you to project ID: 6240706168', '6240706168', '2025-02-02 11:54:20', '6'),
(16418, '229302445', 'Admin has allocated you to project ID: 6275845010', '6275845010', '2025-02-02 11:54:20', '6'),
(16419, '229302446', 'Admin has allocated you to project ID: 6286778688', '6286778688', '2025-02-02 11:54:20', '6'),
(16420, '229302447', 'Admin has allocated you to project ID: 6305009370', '6305009370', '2025-02-02 11:54:20', '6'),
(16421, '229302448', 'Admin has allocated you to project ID: 6389878343', '6389878343', '2025-02-02 11:54:20', '6'),
(16422, '229302453', 'Admin has allocated you to project ID: 6446476969', '6446476969', '2025-02-02 11:54:20', '6'),
(16423, '229302454', 'Admin has allocated you to project ID: 6459813954', '6459813954', '2025-02-02 11:54:20', '6'),
(16424, '229302455', 'Admin has allocated you to project ID: 6464225389', '6464225389', '2025-02-02 11:54:20', '6'),
(16425, '229302456', 'Admin has allocated you to project ID: 6471667233', '6471667233', '2025-02-02 11:54:20', '6'),
(16426, '229302457', 'Admin has allocated you to project ID: 6491928912', '6491928912', '2025-02-02 11:54:20', '6'),
(16427, '229302459', 'Admin has allocated you to project ID: 6532003841', '6532003841', '2025-02-02 11:54:20', '6'),
(16428, '229302461', 'Admin has allocated you to project ID: 6535332133', '6535332133', '2025-02-02 11:54:20', '6'),
(16429, '229302462', 'Admin has allocated you to project ID: 6557848249', '6557848249', '2025-02-02 11:54:20', '6'),
(16430, '229302463', 'Admin has allocated you to project ID: 6576820869', '6576820869', '2025-02-02 11:54:20', '6'),
(16431, '229302464', 'Admin has allocated you to project ID: 6617426000', '6617426000', '2025-02-02 11:54:20', '6'),
(16432, '229302468', 'Admin has allocated you to project ID: 6655708541', '6655708541', '2025-02-02 11:54:20', '6'),
(16433, '229302469', 'Admin has allocated you to project ID: 6661558435', '6661558435', '2025-02-02 11:54:20', '6'),
(16434, '229302470', 'Admin has allocated you to project ID: 6702076205', '6702076205', '2025-02-02 11:54:20', '6'),
(16435, '229302498', 'Admin has allocated you to project ID: 6715462376', '6715462376', '2025-02-02 11:54:20', '6'),
(16436, '229302520', 'Admin has allocated you to project ID: 6720517899', '6720517899', '2025-02-02 11:54:20', '6'),
(16437, '229302653', 'Admin has allocated you to project ID: 6725590682', '6725590682', '2025-02-02 11:54:20', '6'),
(16438, '229303065', 'Admin has allocated you to project ID: 6730318500', '6730318500', '2025-02-02 11:54:20', '6'),
(16439, '219302288', 'Admin has allocated you to project ID: 6734472994', '6734472994', '2025-02-02 11:54:20', '6'),
(16440, '229302466', 'Admin has allocated you to project ID: 6758913148', '6758913148', '2025-02-02 11:54:20', '6'),
(16441, '229302467', 'Admin has allocated you to project ID: 6763159981', '6763159981', '2025-02-02 11:54:20', '6'),
(16442, '229302471', 'Admin has allocated you to project ID: 6788407902', '6788407902', '2025-02-02 11:54:20', '6'),
(16443, '229302472', 'Admin has allocated you to project ID: 6839253441', '6839253441', '2025-02-02 11:54:20', '6'),
(16444, '229302473', 'Admin has allocated you to project ID: 6855604103', '6855604103', '2025-02-02 11:54:20', '6'),
(16445, '229302474', 'Admin has allocated you to project ID: 6897951408', '6897951408', '2025-02-02 11:54:20', '6'),
(16446, '229302475', 'Admin has allocated you to project ID: 6943483553', '6943483553', '2025-02-02 11:54:20', '6'),
(16447, '229302476', 'Admin has allocated you to project ID: 6951459598', '6951459598', '2025-02-02 11:54:20', '6'),
(16448, '229302477', 'Admin has allocated you to project ID: 6966417966', '6966417966', '2025-02-02 11:54:20', '6'),
(16449, '229302478', 'Admin has allocated you to project ID: 6977997705', '6977997705', '2025-02-02 11:54:20', '6'),
(16450, '229302479', 'Admin has allocated you to project ID: 7018553968', '7018553968', '2025-02-02 11:54:20', '6'),
(16451, '229302480', 'Admin has allocated you to project ID: 7024581261', '7024581261', '2025-02-02 11:54:20', '6'),
(16452, '229302481', 'Admin has allocated you to project ID: 7030580543', '7030580543', '2025-02-02 11:54:20', '6'),
(16453, '229302483', 'Admin has allocated you to project ID: 7039332196', '7039332196', '2025-02-02 11:54:20', '6'),
(16454, '229302484', 'Admin has allocated you to project ID: 7081599958', '7081599958', '2025-02-02 11:54:20', '6'),
(16455, '229302485', 'Admin has allocated you to project ID: 7082783305', '7082783305', '2025-02-02 11:54:20', '6'),
(16456, '229302486', 'Admin has allocated you to project ID: 7097629672', '7097629672', '2025-02-02 11:54:20', '6'),
(16457, '229302487', 'Admin has allocated you to project ID: 7104241145', '7104241145', '2025-02-02 11:54:20', '6'),
(16458, '229302489', 'Admin has allocated you to project ID: 7113873793', '7113873793', '2025-02-02 11:54:20', '6'),
(16459, '229302490', 'Admin has allocated you to project ID: 7154448821', '7154448821', '2025-02-02 11:54:20', '6'),
(16460, '229302491', 'Admin has allocated you to project ID: 7203189326', '7203189326', '2025-02-02 11:54:20', '6'),
(16461, '229302492', 'Admin has allocated you to project ID: 7203664773', '7203664773', '2025-02-02 11:54:20', '6'),
(16462, '229302494', 'Admin has allocated you to project ID: 7209449323', '7209449323', '2025-02-02 11:54:20', '6'),
(16463, '229302496', 'Admin has allocated you to project ID: 7228456060', '7228456060', '2025-02-02 11:54:20', '6'),
(16464, '229302499', 'Admin has allocated you to project ID: 7235201123', '7235201123', '2025-02-02 11:54:20', '6'),
(16465, '229302500', 'Admin has allocated you to project ID: 7240267661', '7240267661', '2025-02-02 11:54:20', '6'),
(16466, '229302501', 'Admin has allocated you to project ID: 7249961134', '7249961134', '2025-02-02 11:54:20', '6'),
(16467, '229302502', 'Admin has allocated you to project ID: 7288938230', '7288938230', '2025-02-02 11:54:20', '6'),
(16468, '229302503', 'Admin has allocated you to project ID: 7290721165', '7290721165', '2025-02-02 11:54:20', '6'),
(16469, '229302504', 'Admin has allocated you to project ID: 7312682591', '7312682591', '2025-02-02 11:54:20', '6'),
(16470, '229302505', 'Admin has allocated you to project ID: 7314062615', '7314062615', '2025-02-02 11:54:20', '6'),
(16471, '229302506', 'Admin has allocated you to project ID: 7359672051', '7359672051', '2025-02-02 11:54:20', '6'),
(16472, '229302507', 'Admin has allocated you to project ID: 7383794443', '7383794443', '2025-02-02 11:54:20', '6'),
(16473, '229302508', 'Admin has allocated you to project ID: 7440039304', '7440039304', '2025-02-02 11:54:20', '6'),
(16474, '229302509', 'Admin has allocated you to project ID: 7446263443', '7446263443', '2025-02-02 11:54:20', '6'),
(16475, '229302510', 'Admin has allocated you to project ID: 7523729572', '7523729572', '2025-02-02 11:54:20', '6'),
(16476, '229302511', 'Admin has allocated you to project ID: 7533453730', '7533453730', '2025-02-02 11:54:20', '6'),
(16477, '229302512', 'Admin has allocated you to project ID: 7562300562', '7562300562', '2025-02-02 11:54:20', '6'),
(16478, '229302513', 'Admin has allocated you to project ID: 7569444888', '7569444888', '2025-02-02 11:54:20', '6'),
(16479, '229302514', 'Admin has allocated you to project ID: 7576073823', '7576073823', '2025-02-02 11:54:20', '6'),
(16480, '229302515', 'Admin has allocated you to project ID: 7576774322', '7576774322', '2025-02-02 11:54:20', '6'),
(16481, '229302516', 'Admin has allocated you to project ID: 7611106663', '7611106663', '2025-02-02 11:54:20', '6'),
(16482, '229302517', 'Admin has allocated you to project ID: 7650951786', '7650951786', '2025-02-02 11:54:20', '6'),
(16483, '229302518', 'Admin has allocated you to project ID: 7652315228', '7652315228', '2025-02-02 11:54:20', '6'),
(16484, '229302519', 'Admin has allocated you to project ID: 7657681767', '7657681767', '2025-02-02 11:54:20', '6'),
(16485, '229302521', 'Admin has allocated you to project ID: 7661517394', '7661517394', '2025-02-02 11:54:20', '6'),
(16486, '229302522', 'Admin has allocated you to project ID: 7675778244', '7675778244', '2025-02-02 11:54:20', '6'),
(16487, '229302523', 'Admin has allocated you to project ID: 7679051373', '7679051373', '2025-02-02 11:54:20', '6'),
(16488, '229302524', 'Admin has allocated you to project ID: 7728136111', '7728136111', '2025-02-02 11:54:20', '6'),
(16489, '229302525', 'Admin has allocated you to project ID: 7750597482', '7750597482', '2025-02-02 11:54:20', '6'),
(16490, '229302526', 'Admin has allocated you to project ID: 7774563212', '7774563212', '2025-02-02 11:54:20', '6'),
(16491, '229302527', 'Admin has allocated you to project ID: 7784864874', '7784864874', '2025-02-02 11:54:20', '6'),
(16492, '229302528', 'Admin has allocated you to project ID: 7814915481', '7814915481', '2025-02-02 11:54:20', '6'),
(16493, '229302529', 'Admin has allocated you to project ID: 7827209517', '7827209517', '2025-02-02 11:54:20', '6'),
(16494, '229302530', 'Admin has allocated you to project ID: 7844855989', '7844855989', '2025-02-02 11:54:20', '6'),
(16495, '229302531', 'Admin has allocated you to project ID: 7879049852', '7879049852', '2025-02-02 11:54:20', '6'),
(16496, '229302532', 'Admin has allocated you to project ID: 7917863849', '7917863849', '2025-02-02 11:54:20', '6'),
(16497, '229302534', 'Admin has allocated you to project ID: 7936080782', '7936080782', '2025-02-02 11:54:20', '6'),
(16498, '229302535', 'Admin has allocated you to project ID: 7952217445', '7952217445', '2025-02-02 11:54:20', '6'),
(16499, '229302536', 'Admin has allocated you to project ID: 7959070944', '7959070944', '2025-02-02 11:54:20', '6'),
(16500, '229302538', 'Admin has allocated you to project ID: 7976953719', '7976953719', '2025-02-02 11:54:20', '6'),
(16501, '229302539', 'Admin has allocated you to project ID: 7993001205', '7993001205', '2025-02-02 11:54:20', '6'),
(16502, '229303164', 'Admin has allocated you to project ID: 8000925975', '8000925975', '2025-02-02 11:54:20', '6'),
(16503, '229302540', 'Admin has allocated you to project ID: 8035518577', '8035518577', '2025-02-02 11:54:20', '6'),
(16504, '229302541', 'Admin has allocated you to project ID: 8043862566', '8043862566', '2025-02-02 11:54:20', '6'),
(16505, '229302542', 'Admin has allocated you to project ID: 8051951681', '8051951681', '2025-02-02 11:54:20', '6'),
(16506, '229302543', 'Admin has allocated you to project ID: 8067606166', '8067606166', '2025-02-02 11:54:20', '6'),
(16507, '229302545', 'Admin has allocated you to project ID: 8086741380', '8086741380', '2025-02-02 11:54:20', '6'),
(16508, '229302546', 'Admin has allocated you to project ID: 8095386842', '8095386842', '2025-02-02 11:54:20', '6'),
(16509, '229302547', 'Admin has allocated you to project ID: 8098064035', '8098064035', '2025-02-02 11:54:20', '6'),
(16510, '229302548', 'Admin has allocated you to project ID: 8106994403', '8106994403', '2025-02-02 11:54:20', '6'),
(16511, '229302549', 'Admin has allocated you to project ID: 8123618663', '8123618663', '2025-02-02 11:54:20', '6'),
(16512, '229302550', 'Admin has allocated you to project ID: 8179561293', '8179561293', '2025-02-02 11:54:20', '6'),
(16513, '229302551', 'Admin has allocated you to project ID: 8182259819', '8182259819', '2025-02-02 11:54:20', '6'),
(16514, '229302553', 'Admin has allocated you to project ID: 8185203175', '8185203175', '2025-02-02 11:54:20', '6'),
(16515, '229302555', 'Admin has allocated you to project ID: 8194371476', '8194371476', '2025-02-02 11:54:20', '6'),
(16516, '229302557', 'Admin has allocated you to project ID: 8207490835', '8207490835', '2025-02-02 11:54:20', '6'),
(16517, '229302558', 'Admin has allocated you to project ID: 8219064627', '8219064627', '2025-02-02 11:54:20', '6'),
(16518, '229302559', 'Admin has allocated you to project ID: 8223422332', '8223422332', '2025-02-02 11:54:20', '6'),
(16519, '229302560', 'Admin has allocated you to project ID: 8233441244', '8233441244', '2025-02-02 11:54:20', '6'),
(16520, '229302561', 'Admin has allocated you to project ID: 8239085442', '8239085442', '2025-02-02 11:54:20', '6'),
(16521, '229302563', 'Admin has allocated you to project ID: 8298910690', '8298910690', '2025-02-02 11:54:20', '6'),
(16522, '229302564', 'Admin has allocated you to project ID: 8300891452', '8300891452', '2025-02-02 11:54:20', '6'),
(16523, '229302565', 'Admin has allocated you to project ID: 8305167313', '8305167313', '2025-02-02 11:54:20', '6'),
(16524, '229302566', 'Admin has allocated you to project ID: 8340829671', '8340829671', '2025-02-02 11:54:20', '6'),
(16525, '229302567', 'Admin has allocated you to project ID: 8353096138', '8353096138', '2025-02-02 11:54:20', '6'),
(16526, '229302568', 'Admin has allocated you to project ID: 8353898311', '8353898311', '2025-02-02 11:54:20', '6'),
(16527, '229302569', 'Admin has allocated you to project ID: 8366620002', '8366620002', '2025-02-02 11:54:20', '6'),
(16528, '229302570', 'Admin has allocated you to project ID: 8383698720', '8383698720', '2025-02-02 11:54:20', '6'),
(16529, '229302571', 'Admin has allocated you to project ID: 8398261537', '8398261537', '2025-02-02 11:54:20', '6'),
(16530, '229302572', 'Admin has allocated you to project ID: 8415354418', '8415354418', '2025-02-02 11:54:20', '6'),
(16531, '229302573', 'Admin has allocated you to project ID: 8418224531', '8418224531', '2025-02-02 11:54:20', '6'),
(16532, '229302574', 'Admin has allocated you to project ID: 8422671065', '8422671065', '2025-02-02 11:54:20', '6'),
(16533, '229302575', 'Admin has allocated you to project ID: 8435661920', '8435661920', '2025-02-02 11:54:20', '6'),
(16534, '229302576', 'Admin has allocated you to project ID: 8436256741', '8436256741', '2025-02-02 11:54:20', '6'),
(16535, '229302578', 'Admin has allocated you to project ID: 8457056864', '8457056864', '2025-02-02 11:54:20', '6'),
(16536, '229302580', 'Admin has allocated you to project ID: 8462029981', '8462029981', '2025-02-02 11:54:20', '6'),
(16537, '229302583', 'Admin has allocated you to project ID: 8484778416', '8484778416', '2025-02-02 11:54:20', '6'),
(16538, '229302584', 'Admin has allocated you to project ID: 8504815338', '8504815338', '2025-02-02 11:54:20', '6'),
(16539, '229302585', 'Admin has allocated you to project ID: 8534166107', '8534166107', '2025-02-02 11:54:20', '6'),
(16540, '229302587', 'Admin has allocated you to project ID: 8539180900', '8539180900', '2025-02-02 11:54:20', '6'),
(16541, '229302588', 'Admin has allocated you to project ID: 8545159407', '8545159407', '2025-02-02 11:54:20', '6'),
(16542, '229302589', 'Admin has allocated you to project ID: 8554360826', '8554360826', '2025-02-02 11:54:20', '6'),
(16543, '229302590', 'Admin has allocated you to project ID: 8565283278', '8565283278', '2025-02-02 11:54:20', '6'),
(16544, '229302591', 'Admin has allocated you to project ID: 8584155726', '8584155726', '2025-02-02 11:54:20', '6'),
(16545, '229302592', 'Admin has allocated you to project ID: 8600092090', '8600092090', '2025-02-02 11:54:20', '6'),
(16546, '229302593', 'Admin has allocated you to project ID: 8610841486', '8610841486', '2025-02-02 11:54:20', '6'),
(16547, '229302594', 'Admin has allocated you to project ID: 8612769935', '8612769935', '2025-02-02 11:54:20', '6');
INSERT INTO `notifications` (`id`, `registration_no`, `message`, `p_id`, `datetime`, `semester`) VALUES
(16548, '229302595', 'Admin has allocated you to project ID: 8615298102', '8615298102', '2025-02-02 11:54:20', '6'),
(16549, '229302596', 'Admin has allocated you to project ID: 8615801073', '8615801073', '2025-02-02 11:54:20', '6'),
(16550, '229302597', 'Admin has allocated you to project ID: 8624196782', '8624196782', '2025-02-02 11:54:20', '6'),
(16551, '229302598', 'Admin has allocated you to project ID: 8629172939', '8629172939', '2025-02-02 11:54:20', '6'),
(16552, '229302599', 'Admin has allocated you to project ID: 8636665216', '8636665216', '2025-02-02 11:54:20', '6'),
(16553, '229302600', 'Admin has allocated you to project ID: 8638138699', '8638138699', '2025-02-02 11:54:20', '6'),
(16554, '229302601', 'Admin has allocated you to project ID: 8673736387', '8673736387', '2025-02-02 11:54:20', '6'),
(16555, '229302602', 'Admin has allocated you to project ID: 8679884928', '8679884928', '2025-02-02 11:54:20', '6'),
(16556, '229302603', 'Admin has allocated you to project ID: 8715495425', '8715495425', '2025-02-02 11:54:20', '6'),
(16557, '229302604', 'Admin has allocated you to project ID: 8749390185', '8749390185', '2025-02-02 11:54:20', '6'),
(16558, '229302605', 'Admin has allocated you to project ID: 8792762426', '8792762426', '2025-02-02 11:54:20', '6'),
(16559, '229302609', 'Admin has allocated you to project ID: 8804611809', '8804611809', '2025-02-02 11:54:20', '6'),
(16560, '229302614', 'Admin has allocated you to project ID: 8820718942', '8820718942', '2025-02-02 11:54:20', '6'),
(16561, '229302617', 'Admin has allocated you to project ID: 8825896449', '8825896449', '2025-02-02 11:54:20', '6'),
(16562, '229302618', 'Admin has allocated you to project ID: 8851913365', '8851913365', '2025-02-02 11:54:20', '6'),
(16563, '229302621', 'Admin has allocated you to project ID: 8937812174', '8937812174', '2025-02-02 11:54:20', '6'),
(16564, '229302644', 'Admin has allocated you to project ID: 8940854829', '8940854829', '2025-02-02 11:54:20', '6'),
(16565, '229302428', 'Admin has allocated you to project ID: 8942139174', '8942139174', '2025-02-02 11:54:20', '6'),
(16566, '229302622', 'Admin has allocated you to project ID: 8955755299', '8955755299', '2025-02-02 11:54:20', '6'),
(16567, '229302623', 'Admin has allocated you to project ID: 8958710544', '8958710544', '2025-02-02 11:54:20', '6'),
(16568, '229302626', 'Admin has allocated you to project ID: 8959119994', '8959119994', '2025-02-02 11:54:20', '6'),
(16569, '229302627', 'Admin has allocated you to project ID: 8971132276', '8971132276', '2025-02-02 11:54:20', '6'),
(16570, '229302628', 'Admin has allocated you to project ID: 8978317432', '8978317432', '2025-02-02 11:54:20', '6'),
(16571, '229302629', 'Admin has allocated you to project ID: 8984112327', '8984112327', '2025-02-02 11:54:20', '6'),
(16572, '229302630', 'Admin has allocated you to project ID: 9001193984', '9001193984', '2025-02-02 11:54:20', '6'),
(16573, '229302631', 'Admin has allocated you to project ID: 9011902981', '9011902981', '2025-02-02 11:54:20', '6'),
(16574, '229302633', 'Admin has allocated you to project ID: 9032212503', '9032212503', '2025-02-02 11:54:20', '6'),
(16575, '229302635', 'Admin has allocated you to project ID: 9034562847', '9034562847', '2025-02-02 11:54:20', '6'),
(16576, '229302636', 'Admin has allocated you to project ID: 9058304695', '9058304695', '2025-02-02 11:54:20', '6'),
(16577, '229302638', 'Admin has allocated you to project ID: 9094112920', '9094112920', '2025-02-02 11:54:20', '6'),
(16578, '229302639', 'Admin has allocated you to project ID: 9142367743', '9142367743', '2025-02-02 11:54:20', '6'),
(16579, '229302641', 'Admin has allocated you to project ID: 9151698435', '9151698435', '2025-02-02 11:54:20', '6'),
(16580, '229302642', 'Admin has allocated you to project ID: 9154466950', '9154466950', '2025-02-02 11:54:20', '6'),
(16581, '229302646', 'Admin has allocated you to project ID: 9160240498', '9160240498', '2025-02-02 11:54:20', '6'),
(16582, '229302648', 'Admin has allocated you to project ID: 9196757340', '9196757340', '2025-02-02 11:54:20', '6'),
(16583, '229303024', 'Admin has allocated you to project ID: 9223225610', '9223225610', '2025-02-02 11:54:20', '6'),
(16584, '229303037', 'Admin has allocated you to project ID: 9225268894', '9225268894', '2025-02-02 11:54:20', '6'),
(16585, '229303041', 'Admin has allocated you to project ID: 9265115229', '9265115229', '2025-02-02 11:54:20', '6'),
(16586, '229303062', 'Admin has allocated you to project ID: 9270126727', '9270126727', '2025-02-02 11:54:20', '6'),
(16587, '229303084', 'Admin has allocated you to project ID: 9289979806', '9289979806', '2025-02-02 11:54:20', '6'),
(16588, '229303096', 'Admin has allocated you to project ID: 9291417951', '9291417951', '2025-02-02 11:54:20', '6'),
(16589, '229303104', 'Admin has allocated you to project ID: 9295671527', '9295671527', '2025-02-02 11:54:20', '6'),
(16590, '229303112', 'Admin has allocated you to project ID: 9316535241', '9316535241', '2025-02-02 11:54:20', '6'),
(16591, '229303121', 'Admin has allocated you to project ID: 9319246131', '9319246131', '2025-02-02 11:54:20', '6'),
(16592, '229303138', 'Admin has allocated you to project ID: 9337626088', '9337626088', '2025-02-02 11:54:20', '6'),
(16593, '229303147', 'Admin has allocated you to project ID: 9351168743', '9351168743', '2025-02-02 11:54:20', '6'),
(16594, '229303155', 'Admin has allocated you to project ID: 9397843430', '9397843430', '2025-02-02 11:54:20', '6'),
(16595, '229303163', 'Admin has allocated you to project ID: 9398419688', '9398419688', '2025-02-02 11:54:20', '6'),
(16596, '229303179', 'Admin has allocated you to project ID: 9432826244', '9432826244', '2025-02-02 11:54:20', '6'),
(16597, '229303193', 'Admin has allocated you to project ID: 9436032048', '9436032048', '2025-02-02 11:54:20', '6'),
(16598, '229303195', 'Admin has allocated you to project ID: 9466889630', '9466889630', '2025-02-02 11:54:20', '6'),
(16599, '229303197', 'Admin has allocated you to project ID: 9473701300', '9473701300', '2025-02-02 11:54:20', '6'),
(16600, '229303207', 'Admin has allocated you to project ID: 9535960896', '9535960896', '2025-02-02 11:54:20', '6'),
(16601, '229303216', 'Admin has allocated you to project ID: 9544021196', '9544021196', '2025-02-02 11:54:20', '6'),
(16602, '229303218', 'Admin has allocated you to project ID: 9556993938', '9556993938', '2025-02-02 11:54:20', '6'),
(16603, '229303223', 'Admin has allocated you to project ID: 9563942681', '9563942681', '2025-02-02 11:54:20', '6'),
(16604, '229303226', 'Admin has allocated you to project ID: 9565232775', '9565232775', '2025-02-02 11:54:20', '6'),
(16605, '229303246', 'Admin has allocated you to project ID: 9567572209', '9567572209', '2025-02-02 11:54:20', '6'),
(16606, '229303255', 'Admin has allocated you to project ID: 9568941938', '9568941938', '2025-02-02 11:54:20', '6'),
(16607, '229303258', 'Admin has allocated you to project ID: 9570234354', '9570234354', '2025-02-02 11:54:20', '6'),
(16608, '229303261', 'Admin has allocated you to project ID: 9580350632', '9580350632', '2025-02-02 11:54:20', '6'),
(16609, '229303281', 'Admin has allocated you to project ID: 9590692735', '9590692735', '2025-02-02 11:54:20', '6'),
(16610, '229303296', 'Admin has allocated you to project ID: 9593552043', '9593552043', '2025-02-02 11:54:20', '6'),
(16611, '229303298', 'Admin has allocated you to project ID: 9638062975', '9638062975', '2025-02-02 11:54:20', '6'),
(16612, '229303302', 'Admin has allocated you to project ID: 9639331428', '9639331428', '2025-02-02 11:54:20', '6'),
(16613, '229303306', 'Admin has allocated you to project ID: 9642189751', '9642189751', '2025-02-02 11:54:20', '6'),
(16614, '229303319', 'Admin has allocated you to project ID: 9643269337', '9643269337', '2025-02-02 11:54:20', '6'),
(16615, '229303323', 'Admin has allocated you to project ID: 9646119011', '9646119011', '2025-02-02 11:54:20', '6'),
(16616, '229303324', 'Admin has allocated you to project ID: 9648982480', '9648982480', '2025-02-02 11:54:20', '6'),
(16617, '229303347', 'Admin has allocated you to project ID: 9663506936', '9663506936', '2025-02-02 11:54:20', '6'),
(16618, '229303446', 'Admin has allocated you to project ID: 9693223209', '9693223209', '2025-02-02 11:54:20', '6'),
(16619, '229309035', 'Admin has allocated you to project ID: 9693256303', '9693256303', '2025-02-02 11:54:20', '6'),
(16620, '229309099', 'Admin has allocated you to project ID: 9705361430', '9705361430', '2025-02-02 11:54:20', '6'),
(16621, '229309147', 'Admin has allocated you to project ID: 9745748036', '9745748036', '2025-02-02 11:54:20', '6'),
(16622, '229309158', 'Admin has allocated you to project ID: 9751128485', '9751128485', '2025-02-02 11:54:20', '6'),
(16623, '229309169', 'Admin has allocated you to project ID: 9770685233', '9770685233', '2025-02-02 11:54:20', '6'),
(16624, '229309188', 'Admin has allocated you to project ID: 9835273438', '9835273438', '2025-02-02 11:54:20', '6'),
(16625, '229309253', 'Admin has allocated you to project ID: 9838347058', '9838347058', '2025-02-02 11:54:20', '6'),
(16626, '229309258', 'Admin has allocated you to project ID: 9906061069', '9906061069', '2025-02-02 11:54:20', '6'),
(16627, '229311236', 'Admin has allocated you to project ID: 9914596443', '9914596443', '2025-02-02 11:54:20', '6');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `p_id` varchar(15) NOT NULL,
  `pname` varchar(255) NOT NULL,
  `pdesc` varchar(255) NOT NULL,
  `project_type` varchar(50) NOT NULL,
  `project_domain_type` varchar(255) NOT NULL,
  `fid` varchar(11) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `max_student` int(11) NOT NULL,
  `no_of_student_allocated` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`p_id`, `pname`, `pdesc`, `project_type`, `project_domain_type`, `fid`, `semester`, `max_student`, `no_of_student_allocated`) VALUES
('0253774041', 'Metaheuritics Applications in Machine Learninig', '...', 'minnor', 'iot', 'MUJ0134', '6', 2, '0');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `sr_no` int(11) NOT NULL,
  `registration_no` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `password` varchar(500) NOT NULL,
  `section` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `year` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `lock_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`sr_no`, `registration_no`, `name`, `email`, `mobile_no`, `password`, `section`, `semester`, `year`, `image`, `failed_attempts`, `lock_until`) VALUES
(8043, '229202021', 'ANKITA SINGH', 'ankita.229202021@muj.manipal.edu', '2828456855', '$2y$10$hmnds39UozIH3X.VaEJAT.90SDoDAX/1sAcAqJ5h2LnuraKN42Rbu', 'A', '6', '2021', NULL, 0, NULL),
(8044, '229202024', 'SHAURYA PRATAP SINGH', 'shaurya.229202024@muj.manipal.edu', '', '$2y$10$svpKbMfljG0E/BeeilEAHuy9eOMztA5N2HvEsNIJy09OVbw7QsKTm', 'A', '6', '2021', NULL, 0, NULL),
(8045, '229202031', 'AGAM SINGH ARORA', 'agam.229202031@muj.manipal.edu', '', '$2y$10$vQixHTaRtt3GuW2caFixWOec1TYDBzhBFXWi2jY3ouEPqrB3QWtzC', 'A', '6', '2021', NULL, 0, NULL),
(8046, '229202037', 'ISHAN PATHAK', 'ishan.229202037@muj.manipal.edu', '', '$2y$10$DaGlDiN9V5P5h7YTCuBxHu9Gddd7I5jSQGRkuv1cycYLLYOMIEwX.', 'A', '6', '2021', NULL, 0, NULL),
(8047, '229202040', 'DIKSHA KUMARI', 'diksha.229202040@muj.manipal.edu', '', '$2y$10$HYhEouxbBWlNuc79KDHcreX6iv6RzpUxuGfmG5NoZyp2rbbm3G2w6', 'A', '6', '2021', NULL, 0, NULL),
(8048, '229202057', 'AYUSH KISHOR PATANKAR', 'ayush.229202057@muj.manipal.edu', '', '$2y$10$2RDvMU3QpxWVs8LNVE1fvOtKiRd7SIl3hDJj7.wnxqokEav4/o3qi', 'A', '6', '2021', NULL, 0, NULL),
(8049, '229209007', 'ASHRAY SINHA', 'ashray.229209007@muj.manipal.edu', '', '$2y$10$ctfWOm/9CKHPuEOQZI06XeM6ClLC.zHUSHCGEdzKFxa67q/46Rt1q', 'A', '6', '2021', NULL, 0, NULL),
(8050, '229209011', 'CHIRAG KUMAR JHA', 'chirag.229209011@muj.manipal.edu', '', '$2y$10$E/KMRDEDnCjzz7keY6SxF.idD39F9zfKbUe4rEeX0lY5k6LIH4Pfu', 'A', '6', '2021', NULL, 0, NULL),
(8051, '229302001', 'PRASHUK JAIN', 'prashuk.229302001@muj.manipal.edu', '', '$2y$10$eRVGvynPlM5GBgtIbz3ZTeCCPpLm4P4Pxznsg0tZUp6vtKeKGpIBO', 'A', '6', '2021', NULL, 0, NULL),
(8052, '229302003', 'GAUTAM YADAV', 'gautam.229302003@muj.manipal.edu', '', '$2y$10$le0mv1bpwpT2iBFmw41jkOhpxRfvsfE1/qna2UPYlPCWwytngK3Hu', 'A', '6', '2021', NULL, 0, NULL),
(8053, '229302004', 'KSHITIZ CHAUHAN', 'kshitiz.229302004@muj.manipal.edu', '', '$2y$10$s8op25WmEtb/O7mgzeZYJe./S4vAbTwHnlFOQ6iuc22L9Mw/3i4yy', 'A', '6', '2021', NULL, 0, NULL),
(8054, '229302006', 'ASHWIN KUMAR', 'ashwin.229302006@muj.manipal.edu', '', '$2y$10$efcQoaHbMSWNTaINvt0lzOjhhk0f5jb9M1MWERAG1Zm8LrTzKxVai', 'A', '6', '2021', NULL, 0, NULL),
(8055, '229302008', 'SRISHTI JAISWAL', 'srishti.229302008@muj.manipal.edu', '', '$2y$10$.0BLFBDvOWQnrIhuVvqFT.IH.FM5vcIePMb5UUsNpsBEwgTkEfxBy', 'A', '6', '2021', NULL, 0, NULL),
(8056, '229302009', 'ANKIKA CHATTERJEE', 'ankika.229302009@muj.manipal.edu', '', '$2y$10$84H2vFvZqqetmVOLcGGRj.IlwhyNFqMy4X6VJw1.OGySZIzE53wh2', 'A', '6', '2021', NULL, 0, NULL),
(8057, '229302010', 'DAKSH DEEP', 'daksh.229302010@muj.manipal.edu', '', '$2y$10$GyA80x49g7zV4CpCkTLoiuPANCM9Qnryd2Ag7rFIrpQ72DeTxFcHq', 'A', '6', '2021', NULL, 0, NULL),
(8058, '229302013', 'CHETNA VIJAY RAI', 'chetna.229302013@muj.manipal.edu', '', '$2y$10$qwEgyo.PAirTfSZQI0kqwu6aXA2ERwLjxFryRpgcaGWHMkls4iggy', 'A', '6', '2021', NULL, 0, NULL),
(8059, '229302014', 'HARSH JAISWAL', 'harsh.229302014@muj.manipal.edu', '', '$2y$10$7x1Xe/17f3bh8aW1f3GbsOpVKsPA59Y.LytCj02Tl0NqOqp42tNzy', 'A', '6', '2021', NULL, 0, NULL),
(8060, '229302016', 'SAUMYA DIPAK MALUSARE', 'saumya.229302016@muj.manipal.edu', '', '$2y$10$T1W4BYeNRuPZiNCTUxdJQOiEzOvqYTdcvlixchay53GtLX70NjP36', 'A', '6', '2021', NULL, 0, NULL),
(8061, '229302017', 'SOUMIL SHUKLA', 'soumil.229302017@muj.manipal.edu', '', '$2y$10$mwCYQvrwtpkoIQpA8F9u/.9QimT1ZXywF8c2HBjE/o6cBuUc7tB8i', 'A', '6', '2021', NULL, 0, NULL),
(8062, '229302018', 'KARTAVYA JOSHI', 'kartavya.229302018@muj.manipal.edu', '', '$2y$10$ZocHxLkRDJ5ujiLuy4LQzubSGJJluHHsCAlsIgoE8HL7EZPJxL546', 'A', '6', '2021', NULL, 0, NULL),
(8063, '229302019', 'DIVYANSHU SHUKLA', 'divyanshu.229302019@muj.manipal.edu', '', '$2y$10$oJy/5mFwt.yGnc20B6Mfkug5Aaw32C8qglch4cNk6C7XayGii.u/e', 'A', '6', '2021', NULL, 0, NULL),
(8064, '229302020', 'ANUSHKA SHARMA', 'anushka.229302020@muj.manipal.edu', '', '$2y$10$leTpOofYJX61LBTcuM3hQOVjr3X3Ub.9q8jrZtGfGYSviT8URKaSC', 'A', '6', '2021', NULL, 0, NULL),
(8065, '229302021', 'JEMIN PATIDAR', 'jemin.229302021@muj.manipal.edu', '', '$2y$10$FUJcL0Elx.gwiz/KbU.1Ru2Iy2qqbXvR7A59wwejq5WXcRHvyl/B2', 'A', '6', '2021', NULL, 0, NULL),
(8066, '229302022', 'SAJAG GUPTA', 'sajag.229302022@muj.manipal.edu', '', '$2y$10$7jrwkHx7kt8G7mJvgrZxIOhbAEAIJpbIWShXR0KSRU6cPX.uv0Vh.', 'A', '6', '2021', NULL, 0, NULL),
(8067, '229302023', 'CHINMAYEE PANDEY', 'chinmayee.229302023@muj.manipal.edu', '', '$2y$10$rcBpt7RL5y6ah22jaaXOfujVMer74fqk3cCjo.yfDG9Tks5VNQ.NO', 'A', '6', '2021', NULL, 0, NULL),
(8068, '229302024', 'SOUMYE GUPTA', 'soumye.229302024@muj.manipal.edu', '', '$2y$10$wdQv5sm3B/Mh2lYrHyJBm.yPYURs9OzAFQhZktS1QNlJ43IrV4ZLG', 'A', '6', '2021', NULL, 0, NULL),
(8069, '229302026', 'PRANAV GUPTA', 'pranav.229302026@muj.manipal.edu', '', '$2y$10$3zTvOfYulHTI0FDteMYxWu9sCb4sJBgUrGzwNfElHr4cmqNCvOTXS', 'A', '6', '2021', NULL, 0, NULL),
(8070, '229302027', 'RIDHAM KUMAWAT', 'ridham.229302027@muj.manipal.edu', '', '$2y$10$0440yRrXV31.wowAf1CiAevB/elQHF9zGnT7FsEEcKnXHQxYDBvvC', 'A', '6', '2021', NULL, 0, NULL),
(8071, '229302028', 'SAUMYA UNA', 'saumya.229302028@muj.manipal.edu', '', '$2y$10$0ZYs2YYHx3OuL3ESMBLSqeHe8JQXTzWEbZ/5D2KBD1hbkBqwJpCuK', 'A', '6', '2021', NULL, 0, NULL),
(8072, '229302029', 'NISHCHAY VIKAS LAMBA', 'nishchay.229302029@muj.manipal.edu', '', '$2y$10$ZZI7p6B2vX5bF0FERdWEtef8rhr0Cf0fO1ssB2AD0IcV3C3iaACHe', 'A', '6', '2021', NULL, 0, NULL),
(8073, '229302030', 'SUMIT POONIA', 'sumit.229302030@muj.manipal.edu', '', '$2y$10$Rm3eUVWSc.U.t4lG8W51Q.cu38OIbINe4EAv1e/xau21bVw7WkbRe', 'A', '6', '2021', NULL, 0, NULL),
(8074, '229302031', 'HRUSHIKESH RAVINDRA PADAMWAR', 'hrushikesh.229302031@muj.manipal.edu', '', '$2y$10$zmcY5/RBsi3/yjTUACe3KuzgjdlFmGJlvOIamvIrM2reHYhotNuwG', 'A', '6', '2021', NULL, 0, NULL),
(8075, '229302032', 'NAMAN KUMAWAT', 'naman.229302032@muj.manipal.edu', '', '$2y$10$s1Q7P86M2fMYLPBliSGMNugcvhxc.WtMiAtWmgQizVE9kLEkiXn5a', 'A', '6', '2021', NULL, 0, NULL),
(8076, '229302033', 'SHAURYA SAXENA', 'shaurya.229302033@muj.manipal.edu', '', '$2y$10$CHwcB.le3spWM7usf5iml.4j.5f9iM2hoOSRRBcXdRIfsvkxh9TZy', 'A', '6', '2021', NULL, 0, NULL),
(8077, '229302034', 'HARSH DHARMENDRA JAIN', 'harsh.229302034@muj.manipal.edu', '', '$2y$10$0accTsK9dR6bVPPFwgHDUetGGZTE3nkp5v00tYkp56HhapVJRJTmm', 'A', '6', '2021', NULL, 0, NULL),
(8078, '229302035', 'BRINDESHWAR SHARMA', 'brindeshwar.229302035@muj.manipal.edu', '', '$2y$10$pRVdDiAN47L/61evemL.AuIGdLyVNiaNkPQkQC5J3uagSxqd3ggAq', 'A', '6', '2021', NULL, 0, NULL),
(8079, '229302036', 'TULIKA GIRI', 'tulika.229302036@muj.manipal.edu', '', '$2y$10$fTFc7n870HCVeuwO.zCloer7VsNa9vOtHPf0CpkkUn.CuFvr/8v8O', 'A', '6', '2021', NULL, 0, NULL),
(8080, '229302037', 'ANANYA TIWARI', 'ananya.229302037@muj.manipal.edu', '', '$2y$10$hR4Nrw3RwK8eICHwqFXxSukxfcHppDI.zDKEv5J3Pq7WHdLAT5w7W', 'A', '6', '2021', NULL, 0, NULL),
(8081, '229302038', 'BHAVYE VERMA', 'bhavye.229302038@muj.manipal.edu', '', '$2y$10$ySKu9rK6pVqAosOi6hGaUe.EEei6gQXxqNfBIuh/u5jbXzSG028vG', 'A', '6', '2021', NULL, 0, NULL),
(8082, '229302039', 'AAMOGH SHRIVASTAVA', 'aamogh.229302039@muj.manipal.edu', '', '$2y$10$tZkCUHIJxF718kNs.3yAaueFLLCNK7tSMqeFDQPrKuj5K2pzyb5cW', 'A', '6', '2021', NULL, 0, NULL),
(8083, '229302046', 'SHIVAM KUMAR SINGH', 'shivam.229302046@muj.manipal.edu', '', '$2y$10$kW2LgY80H5bpGwrUQxa6eegiuNXSnGOL9EWp09NmZ8GsYaRNUO95G', 'A', '6', '2021', NULL, 0, NULL),
(8084, '229302047', 'PULKIT VERMA', 'pulkit.229302047@muj.manipal.edu', '', '$2y$10$ksAKB81Hh0EpMCOaDgDoieBwZwiJmjDGvweQkoUqzPY568G0cgL6m', 'A', '6', '2021', NULL, 0, NULL),
(8085, '229302048', 'PRANAV RAJ', 'pranav.229302048@muj.manipal.edu', '', '$2y$10$//ksWP52X/eLSJ6l3qtjIeYfETny/KVPoAlffTGWVc25jBMKcjfuO', 'A', '6', '2021', NULL, 0, NULL),
(8086, '229302051', 'PRINCE JINDAL', 'prince.229302051@muj.manipal.edu', '', '$2y$10$w8IuPxsvO1alLvgBCJVsQuZPExpjPBSrBbDEEp8cVkgJML.gHbbOy', 'A', '6', '2021', NULL, 0, NULL),
(8087, '229302055', 'SHIVAM SINGH', 'shivam.229302055@muj.manipal.edu', '', '$2y$10$ZUNnIxU7y85YWIq5Y8SaseaOFWv3ClOvOi.xph9U7F2qosSVImHuC', 'A', '6', '2021', NULL, 0, NULL),
(8088, '229302056', 'SAHIL KUMAR', 'sahil.229302056@muj.manipal.edu', '', '$2y$10$gZ6Vr6JBP056sFWcljjuBumN3n7elmL9FJCABb2Hv7aWWHrG7Hhp6', 'A', '6', '2021', NULL, 0, NULL),
(8089, '229302057', 'MARMIK CHOUDHARY', 'MARMIK.229302057@muj.manipal.edu', '', '$2y$10$XwdPf/CwtW6crLfj7Q99KuGrjMGHaz6rLZAGe6HJhvP5vubvRDpai', 'A', '6', '2021', NULL, 0, NULL),
(8090, '229302058', 'KETAN MATHUR', 'ketan.229302058@muj.manipal.edu', '', '$2y$10$hfXvWAaODIi1fALDSJDCo.68uyvEJnSOtdqu1Gsm7/xoKCD6n2xsm', 'A', '6', '2021', NULL, 0, NULL),
(8091, '229302060', 'ARMAAN VAISH', 'armaan.229302060@muj.manipal.edu', '', '$2y$10$5NBfjKXSjYdcV/jpfvl/B.FcjQPcgwmO5OUIJdCO3Z6uMZGsqgMZ2', 'A', '6', '2021', NULL, 0, NULL),
(8092, '229302061', 'DEVANSH PALIWAL', 'devansh.229302061@muj.manipal.edu', '', '$2y$10$kr2twmd64JXoxShCrJgMfOX1feaukAuFTlVR6W.p1vRj5RPGOokLW', 'A', '6', '2021', NULL, 0, NULL),
(8093, '229302062', 'RISHI JOSHI', 'rishi.229302062@muj.manipal.edu', '', '$2y$10$JLhX5JNvuhNlluVuKGG5jO5cGM6.XXiZZS5Dv/1XwKYK085ulV48C', 'A', '6', '2021', NULL, 0, NULL),
(8094, '229302063', 'DIVYA PAWA', 'divya.229302063@muj.manipal.edu', '', '$2y$10$VhrBg6USQon0nacoDDVkFOhOnlDL3ZZf3cn4HX9BsEaNNvNLVbSfy', 'A', '6', '2021', NULL, 0, NULL),
(8095, '229302065', 'RISHI MITTAL', 'rishi.229302065@muj.manipal.edu', '', '$2y$10$.OJKI9kJ5Gv9XCr7Jrr1OuJyWd7fi2rMLSGQeuZQhCsqHsFLM1sIi', 'A', '6', '2021', NULL, 0, NULL),
(8096, '229302066', 'KUMAR KARTIKAY SHANKAR', 'kumar.229302066@muj.manipal.edu', '', '$2y$10$znuj7d0GUoP8Zg/VbWoaL.cNfdX9u0hgDoth5P5rKscJgKEoUou.m', 'A', '6', '2021', NULL, 0, NULL),
(8097, '229302070', 'AYUSH KUMAR', 'ayush.229302070@muj.manipal.edu', '', '$2y$10$/sgBf43XWapRT5EYt4ZNHechL.La.YEZhLgZve1Gvv2p3LbbpYOka', 'A', '6', '2021', NULL, 0, NULL),
(8098, '229302114', 'RENESA RAJESH ISRANI', 'renesa.229302114@muj.manipal.edu', '', '$2y$10$Xbc7GXYapyT/25LA3rNL4.k8B4mLdiWst0yQoq7LQFownyMlMWxr6', 'A', '6', '2021', NULL, 0, NULL),
(8099, '229302133', 'NAINIKA SINHA', 'nainika.229302133@muj.manipal.edu', '', '$2y$10$u8FkyLu5V/mvuupJoeGtROBUW26no/FKUtn2h0Y0Xtu5Y9ULQCTFu', 'A', '6', '2021', NULL, 0, NULL),
(8100, '229302265', 'AIYAN SHAMSHAD', 'aiyan.229302265@muj.manipal.edu', '', '$2y$10$rZB6bh5lr6zvfgxnaMOa1.9N.ZSWGbf13/mFM3ne3nAoRoq0nfsd6', 'A', '6', '2021', NULL, 0, NULL),
(8101, '229302449', 'YASHVI ARYA', 'yashvi.229302449@muj.manipal.edu', '', '$2y$10$.DdS.N5cdqRQUb8Zl4uLgu5JgoeTNAWVqu02NnbwJUcX79Rn9WtYm', 'A', '6', '2021', NULL, 0, NULL),
(8102, '229302652', 'HARRY NIPUL PATTANI', 'harry.229302652@muj.manipal.edu', '', '$2y$10$J.fNp2Z7OazPj34q80LUjOnNLSokj6EYic35Xp0NA3r.eDuOzEp0O', 'A', '6', '2021', NULL, 0, NULL),
(8103, '229301218', 'RISHIT MEHROTRA', 'rishit.229301218@muj.manipal.edu', '', '$2y$10$LPEa01ND3e1jZp4.8C95a.ozJKykYdKkdypeKp9D2UYfbNYqdh1wq', 'B', '6', '2021', NULL, 0, NULL),
(8104, '229302011', 'MITISHA SINGH', 'mitisha.229302011@muj.manipal.edu', '', '$2y$10$r49trMyYj3sEKPZca/I4TuEMCx9U4kSEVqDceWDQMqvSiZBjhR.RG', 'B', '6', '2021', NULL, 0, NULL),
(8105, '229302068', 'ROHAN GUPTA', 'rohan.229302068@muj.manipal.edu', '', '$2y$10$XWrAgIqj8v4uXxjAtmRfu.s/ec2aCdhGpF00MMgtYhlNv/rRmcxKW', 'B', '6', '2021', NULL, 0, NULL),
(8106, '229302072', 'SPARSH RAWAT', 'sparsh.229302072@muj.manipal.edu', '', '$2y$10$fPF8q24lVNomtZrvrHr4peMi8J.4Xncyc4T5bC0UEK89KzxfJg07.', 'B', '6', '2021', NULL, 0, NULL),
(8107, '229302074', 'YASHIKA KHATTRI', 'yashika.229302074@muj.manipal.edu', '', '$2y$10$wpFp0WVGO6Z.z3owNr6QD.73J1CDAjOYHTy9AvypyKYV4deGieti6', 'B', '6', '2021', NULL, 0, NULL),
(8108, '229302075', 'NIVED V M', 'nived.229302075@muj.manipal.edu', '', '$2y$10$oDqrutf2e4459CeUNkMDz.OgtquwyULV.67q8qOR1GL8fyEZRf7Py', 'B', '6', '2021', NULL, 0, NULL),
(8109, '229302077', 'DHRUV GUPTA', 'dhruv.229302077@muj.manipal.edu', '', '$2y$10$W1f2/Jl3DvptV4tkw2XB2OPxnmOHo.9ITXdWeLQ34mD1CpsZYa2yq', 'B', '6', '2021', NULL, 0, NULL),
(8110, '229302078', 'KALI DOSHI', 'kali.229302078@muj.manipal.edu', '', '$2y$10$yLyXHh4EGx5iIKgkTf4Xeuhj/QmdhHzyuCndt.FG5QTnP9n1fNyvO', 'B', '6', '2021', NULL, 0, NULL),
(8111, '229302079', 'PARV', 'parv.229302079@muj.manipal.edu', '', '$2y$10$qFJvEJseMEOileaNNXvjvOqrsVcXO2BUYv0aAvpUV/KZXQwrkRgI2', 'B', '6', '2021', NULL, 0, NULL),
(8112, '229302080', 'SAYAK DAS', 'sayak.229302080@muj.manipal.edu', '', '$2y$10$pKjBt0AmKiEPy9uEefG56./cgGbEBscMJ5Wbju4Q9BnKkCxBvtpb6', 'B', '6', '2021', NULL, 0, NULL),
(8113, '229302081', 'SIDDHANT KOKATE', 'siddhant.229302081@muj.manipal.edu', '', '$2y$10$9ySSK.Pp4h349pRVfsLtU.XGVvIn1CSClkpGOTdkOWe25FFrmmkVG', 'B', '6', '2021', NULL, 0, NULL),
(8114, '229302084', 'DEDAKIA RAJ KETANKUMAR', 'dedakia.229302084@muj.manipal.edu', '', '$2y$10$xwYH79NgdmrA2i3IbgHUsOZ0H6mAlXTseuBcB3f2vw31DEcVTEVPW', 'B', '6', '2021', NULL, 0, NULL),
(8115, '229302086', 'VISHAL BIRLA', 'vishal.229302086@muj.manipal.edu', '', '$2y$10$PMd38nkmV3Jy3ds5kJ1heON2QR1lgdX4AMCc9Mdx/ZIWb0QPf1oJ.', 'B', '6', '2021', NULL, 0, NULL),
(8116, '229302087', 'CHAITANYA PATHAK', 'chaitanya.229302087@muj.manipal.edu', '', '$2y$10$VkJOUn3ipr64sWkkCRkw0uvyhbfalYVkDgRtJS119Ln/TrQE5VxGi', 'B', '6', '2021', NULL, 0, NULL),
(8117, '229302088', 'SIDDHIDE ARUN PANCHWADKAR', 'siddhide.229302088@muj.manipal.edu', '', '$2y$10$dLVRF/suMm2jzturH7ykaeUkpFiPn4FtTRySHhsgHrJ0zlFu8CwEi', 'B', '6', '2021', NULL, 0, NULL),
(8118, '229302090', 'ARYAN TAWDE', 'aryan.229302090@muj.manipal.edu', '', '$2y$10$Xt.FYFekTtgaC3VGskrmOupHc.7ukpiPw5XRg3BuakFO8XvHx2ON2', 'B', '6', '2021', NULL, 0, NULL),
(8119, '229302092', 'DEBLINA TALUKDER', 'deblina.229302092@muj.manipal.edu', '', '$2y$10$gPmeZZ/drPpmhYUQi5gWcOku8FQspyjERZR.NaOEzAF3QCouflFT.', 'B', '6', '2021', NULL, 0, NULL),
(8120, '229302093', 'PRASHASTI RAI', 'prashasti.229302093@muj.manipal.edu', '', '$2y$10$5.s7ubKgt0gjM0K3CE9p7eNAOekBwXDTVek3OGa1o7G75s4SDaBXO', 'B', '6', '2021', NULL, 0, NULL),
(8121, '229302095', 'AKSHAT SRIVASTAVA', 'akshat.229302095@muj.manipal.edu', '', '$2y$10$lfxgadxF3Uk569OfaBZZt.4uEwtHNDo.uxWBzZqRKM3R785Eh1VDe', 'B', '6', '2021', NULL, 0, NULL),
(8122, '229302096', 'HRISHI RAJ SAXENA', 'hrishi.229302096@muj.manipal.edu', '', '$2y$10$Gp4cLWK2USZdYw0ctO7Qie/GdgzFRj/zlRoyh3mxhtgzczVdEVYw.', 'B', '6', '2021', NULL, 0, NULL),
(8123, '229302097', 'VISHAL', 'vishal.229302097@muj.manipal.edu', '', '$2y$10$S.VyvTopAgVorNWXBMPMm.g8F3oQoK8DRNPhI7Y8b.QsjDNxkFsOC', 'B', '6', '2021', NULL, 0, NULL),
(8124, '229302101', 'JAIVARDHAN RANAWAT', 'jaivardhan.229302101@muj.manipal.edu', '', '$2y$10$OQH1EZkyfjFHlME6m4D8tOl80CbHmoNLEtbaTpwJNVBdRvMLhNqmG', 'B', '6', '2021', NULL, 0, NULL),
(8125, '229302102', 'MAHIKA YERNENI', 'mahika.229302102@muj.manipal.edu', '', '$2y$10$qHeN6367iTRS8aE24CefHuwiU8zKf93sUeLCBC5eYIRZ7FYAYDfDa', 'B', '6', '2021', NULL, 0, NULL),
(8126, '229302104', 'PUNYAM GUPTA', 'punyam.229302104@muj.manipal.edu', '', '$2y$10$T152eQHnZ/lXomIL7FqwReSVG/wiAvH5WGqsQq6qc8UXo0JQKG.v6', 'B', '6', '2021', NULL, 0, NULL),
(8127, '229302107', 'AMBER MISHRA', 'amber.229302107@muj.manipal.edu', '', '$2y$10$nDs/zkxpLoMK6NHe2QiAOOwFjLCZ.GdMJdkRdR10SnugovWGRoEUC', 'B', '6', '2021', NULL, 0, NULL),
(8128, '229302108', 'SANSKRITI JAISWAL', 'sanskriti.229302108@muj.manipal.edu', '', '$2y$10$dXVQp.iUp37c.V5a/.4O.O7T.MIyNe7raUxaNyeCk2T/WWfEXP9fi', 'B', '6', '2021', NULL, 0, NULL),
(8129, '229302109', 'UTKARSH SINGH', 'utkarsh.229302109@muj.manipal.edu', '', '$2y$10$cX8BpTWdy.j8UoyAHWiNJuBU9C/P8kxgzV5Bh64Tir3c/6DlMNYAi', 'B', '6', '2021', NULL, 0, NULL),
(8130, '229302111', 'AYUSH PANDEY', 'ayush.229302111@muj.manipal.edu', '', '$2y$10$6DtVWpgUlvPNS4ZCOBSDyejMVmiEy3L7rZhx9/Cf9OPW8yliYSUgm', 'B', '6', '2021', NULL, 0, NULL),
(8131, '229302112', 'AYUSH SINGH', 'ayush.229302112@muj.manipal.edu', '', '$2y$10$Pm6kzruk7owXvW6ufXrOyeznJuZsLEWmj96hxDj.WHp58kr3cJUKO', 'B', '6', '2021', NULL, 0, NULL),
(8132, '229302115', 'DHRUV SHOUNAK', 'dhruv.229302115@muj.manipal.edu', '', '$2y$10$0OnXO.nHmfWw9qvZSUJryutLkJqyzxRPdjaI5xTrg7boXzCgSBA1u', 'B', '6', '2021', NULL, 0, NULL),
(8133, '229302116', 'MD. HASSAAN', 'md.229302116@muj.manipal.edu', '', '$2y$10$WGzPYVEr0upwdUVgAsTBhejSAMADzWGjCuocIs9NXDQ6pFPeVxgrm', 'B', '6', '2021', NULL, 0, NULL),
(8134, '229302117', 'GAUTAM GOVIND', 'gautam.229302117@muj.manipal.edu', '', '$2y$10$vQ2Du0s1/SmVuHB8dm50HufWetT1VPYXmCxPBGhB1kObuLpzUk5AS', 'B', '6', '2021', NULL, 0, NULL),
(8135, '229302119', 'ADITYA SHARMA', 'aditya.229302119@muj.manipal.edu', '', '$2y$10$f1jXNXl/ZipdzFe625YbEuzF53KfxrlRGpeVPgmE0e64/4TlbYGua', 'B', '6', '2021', NULL, 0, NULL),
(8136, '229302120', 'SUMAN PALIWAR', 'suman.229302120@muj.manipal.edu', '', '$2y$10$jDEcsvMTKF7P1XOyGzm0HO24b/L4axZvwHYj6Z3VXvpMiQHUsTUHO', 'B', '6', '2021', NULL, 0, NULL),
(8137, '229302122', 'AKSHAT SINHA', 'akshat.229302122@muj.manipal.edu', '', '$2y$10$SWu2UpnqmvRwmnjMN89C.uF2d6DmsyQ.FZC1cRbtWbrzyp/35JzEm', 'B', '6', '2021', NULL, 0, NULL),
(8138, '229302125', 'SHREYASI RAY', 'shreyasi.229302125@muj.manipal.edu', '', '$2y$10$n7B1Hs58dw6zBIeHD0VdYujUVg2EBGH/9yBNEo/NFEZDZLxcy4UCi', 'B', '6', '2021', NULL, 0, NULL),
(8139, '229302127', 'ANSHIKA SETHI', 'anshika.229302127@muj.manipal.edu', '', '$2y$10$Ga7NvphfkENvt1WsTErzxOVTaVeDhTQbzYHXy7zmTWFZ/Y2HKDS7m', 'B', '6', '2021', NULL, 0, NULL),
(8140, '229302128', 'ANIRUDDHAN SRINIVASAN', 'aniruddhan.229302128@muj.manipal.edu', '', '$2y$10$j0wUPtvtvYwkRvZTv9fJQOlLEenpdAqKhzp7TDqc6HBgV/nbRqyk6', 'B', '6', '2021', NULL, 0, NULL),
(8141, '229302131', 'SUJITH VARMA MUDUNURU', 'sujith.229302131@muj.manipal.edu', '', '$2y$10$U9GfUqx3WgbWeAcAzaJvb.eepLqD8XTFkOwb9uIP9em3T7AnxN0ry', 'B', '6', '2021', NULL, 0, NULL),
(8142, '229302134', 'SUMEET CHATURVEDI', 'sumeet.229302134@muj.manipal.edu', '', '$2y$10$iR6KIcLgL4XfKS8AnXtv2.JuOGmIfQjP4pM0tTRwt/cqLXozpdgaC', 'B', '6', '2021', NULL, 0, NULL),
(8143, '229302135', 'SIDDHARTH DUTTA', 'siddharth.229302135@muj.manipal.edu', '', '$2y$10$RvVvGorUA0IpaCUrc8rsyeLks1sbNnCHsUKBUO.O1REAq4A31F7K6', 'B', '6', '2021', NULL, 0, NULL),
(8144, '229302137', 'PALAK SRIVASTAVA', 'palak.229302137@muj.manipal.edu', '', '$2y$10$3WUNh/ZYfxCmJT.X8GkA7OYcfInGdUIVVDepjR7/URhOR7B/UhZRa', 'B', '6', '2021', NULL, 0, NULL),
(8145, '229302139', 'GURBANI KAUR SALUJA', 'gurbani.229302139@muj.manipal.edu', '', '$2y$10$uJQXgrS5iJdnVn0skEFQ2.jvoDrDxgySZLZsy1G8yDpSRAv7BoqPS', 'B', '6', '2021', NULL, 0, NULL),
(8146, '229302140', 'MANAV SINGH', 'manav.229302140@muj.manipal.edu', '', '$2y$10$jbB0AM5KT/laCuxrp6nr.OSUlnbSyfB28swwr.0qNDgkrGWBmdtC6', 'B', '6', '2021', NULL, 0, NULL),
(8147, '229302143', 'SHIVAM JIWAT RAMDASANI', 'shivam.229302143@muj.manipal.edu', '', '$2y$10$F.Zqz9.IE/st9iqYhJOYlOVAvk25sprL1e/Ufuy5aYux.C2Emh9.6', 'B', '6', '2021', NULL, 0, NULL),
(8148, '229302144', 'LAKSH GUPTA', 'laksh.229302144@muj.manipal.edu', '', '$2y$10$/3RsIDbzkkyOs2yUGscnp.GdfL1foIOIX14yR9sk1f3BmKy/8I63C', 'B', '6', '2021', NULL, 0, NULL),
(8149, '229302148', 'SIDDHANT JAISWAL', 'siddhant.229302148@muj.manipal.edu', '', '$2y$10$65CB2cMCVW1QmEHyThC1wemzH3.ce48lsl3zSWy1PiWhEgshmVcu.', 'B', '6', '2021', NULL, 0, NULL),
(8150, '229302149', 'VARUN LALL SRIVASTAVA', 'varun.229302149@muj.manipal.edu', '', '$2y$10$MDuyRsUvmULl5fsQyXmfqOJVfeL2KR7K8.q6HBU75uTVqdssa7mxy', 'B', '6', '2021', NULL, 0, NULL),
(8151, '229302152', 'SHAYAN KUNDU', 'shayan.229302152@muj.manipal.edu', '', '$2y$10$oPKPl2YOfFGWI.mOyKB/l.XiAbpW3d877t3h6mq16MpD4TTrshS/e', 'B', '6', '2021', NULL, 0, NULL),
(8152, '229302155', 'AYUSHI JAIN', 'ayushi.229302155@muj.manipal.edu', '', '$2y$10$56VRP6Zmbm8YlR61py9NQecHIPyrjM.IFradqScnE2by2ZEdSg1Py', 'B', '6', '2021', NULL, 0, NULL),
(8153, '229302156', 'RISHIT MEHROTRA', 'g.229302156@muj.manipal.edu', '', '$2y$10$BfbkbnNXJ5.Gq5j/TedoGu7OEyqQdMqj0XKHa646YBXtCJhgRLyA.', 'B', '6', '2021', NULL, 0, NULL),
(8154, '229302158', 'ARNAV KAMAL', 'arnav.229302158@muj.manipal.edu', '', '$2y$10$INI9mmAi/1DuyrAHuo1xDe3hIfFLoTB9bN2YUFAumkMzTfPJmkRQK', 'B', '6', '2021', NULL, 0, NULL),
(8155, '229302159', 'UTKARSH VIJAY', 'utkarsh.229302159@muj.manipal.edu', '', '$2y$10$XeEgP6qKqJ1yQAOlge/zEufjAf/RueYeL9fZ7WxbEW71pV2n24A2a', 'B', '6', '2021', NULL, 0, NULL),
(8156, '229302162', 'YASH SHARMA', 'yash.229302162@muj.manipal.edu', '', '$2y$10$aauusrfqCulthTf1IWsDj.UvC49ijrEyiuy08UhB/lLwDJWJvsHnO', 'B', '6', '2021', NULL, 0, NULL),
(8157, '229302163', 'ACHINTYA SINGH', 'achintya.229302163@muj.manipal.edu', '', '$2y$10$TL6wvRwqYX3FnxHSGOZi8ecTrCM4J8htfnFiVWvwfLujuO1f4jALa', 'B', '6', '2021', NULL, 0, NULL),
(8158, '229302165', 'SARTHAK REKHI', 'sarthak.229302165@muj.manipal.edu', '', '$2y$10$1eO5IV74A0oIv/8so517JOte1y2xixO5SQxSSKR12TlT9Qm7q6VR6', 'B', '6', '2021', NULL, 0, NULL),
(8159, '229302166', 'YOGENDRA SAINI', 'yogendra.229302166@muj.manipal.edu', '', '$2y$10$TXKIVmPCGJh8/BirSS78COGrCCq6p1t0n3PkiPSZsDC0tq/W9q5Fy', 'B', '6', '2021', NULL, 0, NULL),
(8160, '229302167', 'ISHIKA SINGH', 'ishika.229302167@muj.manipal.edu', '', '$2y$10$2KbIkk4e3nJ/a/xtq88woufXbwpRphFltr3gG7WY.DZ/UYZTCNAiC', 'B', '6', '2021', NULL, 0, NULL),
(8161, '229302168', 'SANA SINGH', 'sana.229302168@muj.manipal.edu', '', '$2y$10$biYv8rNsU8BElDmUZB6Epuf5ITUYzy3YBSmfp0AA9oWiHZGHud9vS', 'B', '6', '2021', NULL, 0, NULL),
(8162, '229302171', 'SUPASH AGARWAL', 'supash.229302171@muj.manipal.edu', '', '$2y$10$mR4bQDlm35WyFzqW8zb5y.tFMygRuwqQFmJbFf66vOALM07IAyJBe', 'B', '6', '2021', NULL, 0, NULL),
(8163, '229302172', 'MK PAVANI', 'mk.229302172@muj.manipal.edu', '', '$2y$10$BZy7/jF.IJRxqU3O.eUmA.m1XPzOiy/vNyuCVyTA8/Z8Ffswam0Vq', 'B', '6', '2021', NULL, 0, NULL),
(8164, '229302654', 'SHIMON AALAM', 'shimon.229302654@muj.manipal.edu', '', '$2y$10$1Axr5FIEkAKm21tLfRfVKOGPDGHnM5GNUwt6OCp4RVVFXNkZO5dsa', 'B', '6', '2021', NULL, 0, NULL),
(8165, '229302173', 'AYONIJA', 'ayonija.229302173@muj.manipal.edu', '', '$2y$10$2F9yaORPSvQdtnZCi8SHgeROqZTaEKon3rAkToED2UsZ6wv8I5/kG', 'C', '6', '2021', NULL, 0, NULL),
(8166, '229302176', 'MANAS MISHRA', 'manas.229302176@muj.manipal.edu', '', '$2y$10$8rsp2/K/ESWirfN2oXJHsOw3zFYvByuPunVYec2wMW7ILcv96oyaW', 'C', '6', '2021', NULL, 0, NULL),
(8167, '229302177', 'LAKSHYA PAWAR', 'lakshya.229302177@muj.manipal.edu', '', '$2y$10$6Qu98NpGT4oDGDrIuzBMYutBTS815NC9.5Ye68O54m0mB318xmjgu', 'C', '6', '2021', NULL, 0, NULL),
(8168, '229302178', 'SATVIK AGARWAL', 'satvik.229302178@muj.manipal.edu', '', '$2y$10$Iug8upSKEjlD5zlW4OJECeXN5nknmkV2Mvsl0jmmKG7gk17iIjQ/a', 'C', '6', '2021', NULL, 0, NULL),
(8169, '229302179', 'MANAV DAS', 'manav.229302179@muj.manipal.edu', '', '$2y$10$iTWCf8Us5QqZNNyiA.r1buIn6s.4/Pt1ClD4KmCw9g6tuZE8mC1B.', 'C', '6', '2021', NULL, 0, NULL),
(8170, '229302183', 'ISHIKA SAXENA', 'ishika.229302183@muj.manipal.edu', '', '$2y$10$5O6eHq/BjdYRcVgNCQG5FensMKks5cBzqALhfjq.5YbvnRchKZRRi', 'C', '6', '2021', NULL, 0, NULL),
(8171, '229302186', 'NISHTHA SAXENA', 'nishtha.229302186@muj.manipal.edu', '', '$2y$10$ShbL4SsycHtiZ7lCrN0o5eVYCOzqlXJVDk6CyOvi5rQSC3wZp75d.', 'C', '6', '2021', NULL, 0, NULL),
(8172, '229302187', 'RAJVEER SINGH BASAN', 'rajveer.229302187@muj.manipal.edu', '', '$2y$10$ZXQseiFhLZUr8RaE3wx/9eel/4YxiGEae6Bd7lht9mjFfKAXy7W1a', 'C', '6', '2021', NULL, 0, NULL),
(8173, '229302189', 'SHIKHAR SRIVASTAV', 'shikhar.229302189@muj.manipal.edu', '', '$2y$10$HA.spiU5riiWPLaPaGQcmuZFX58FbjQzkMS.4DSUMpJPm4lhGj4VS', 'C', '6', '2021', NULL, 0, NULL),
(8174, '229302190', 'PRATIKSHA ASHWIN KAMATH', 'pratiksha.229302190@muj.manipal.edu', '', '$2y$10$J4TKeDzgkmD3pgqMZxP0FerxFmhalTMipdc12d7eY0DQwaT0J0pce', 'C', '6', '2021', NULL, 0, NULL),
(8175, '229302191', 'SIDHALI SINGH', 'sidhali.229302191@muj.manipal.edu', '', '$2y$10$fLIgtMRyrScR1zv0cEc76OHXF67d7t8iiWv/XoNSZnBY.i2jl0e2.', 'C', '6', '2021', NULL, 0, NULL),
(8176, '229302194', 'DIYA THAKUR', 'diya.229302194@muj.manipal.edu', '', '$2y$10$GtN8yIuP0KnHRN9zgJCDSOIvpoUKbRYHIvx4iBpv7xYrEAvatFSBu', 'C', '6', '2021', NULL, 0, NULL),
(8177, '229302196', 'SUPRIYA MISHRA', 'supriya.229302196@muj.manipal.edu', '', '$2y$10$c.o8NKcsH2RCV0M8Y.ugFebneQNOmcIMKSuVjUo3BYK//si0db.Bq', 'C', '6', '2021', NULL, 0, NULL),
(8178, '229302197', 'ARYAN MISHAL', 'aryan.229302197@muj.manipal.edu', '', '$2y$10$O5Lo6.h2OKDBr3VHeaFFeOkXrDkx6KLV3YgPXmyvFOVa2na1KOHEi', 'C', '6', '2021', NULL, 0, NULL),
(8179, '229302199', 'YUVAN LAKHMANI', 'yuvan.229302199@muj.manipal.edu', '', '$2y$10$swGFXuHgwlq7jACb9S0zFeNfxJ.7beXBK.WLxjDQY1KzNbgmkvdHe', 'C', '6', '2021', NULL, 0, NULL),
(8180, '229302200', 'SUSHMIT SETIYA', 'sushmit.229302200@muj.manipal.edu', '', '$2y$10$QcdMIm6OHr13GAKdcKFMq.Ee8NoiXb35PLZaKMmj/0.OR73a/n/.6', 'C', '6', '2021', NULL, 0, NULL),
(8181, '229302201', 'TEJAM PRAVIN JAISWAL', 'tejam.229302201@muj.manipal.edu', '', '$2y$10$S4dAyc5c6ViGqNI72.1XAOu4ToPw2VD5HfiTLmpdv4yS0PqoqzFm.', 'C', '6', '2021', NULL, 0, NULL),
(8182, '229302204', 'NAVODIT KAPOOR', 'navodit.229302204@muj.manipal.edu', '', '$2y$10$BSrLfD51ieJvIkR6tSH30uLMK8eurUp/k/JBI75ZnLMS8VRMGYCyq', 'C', '6', '2021', NULL, 0, NULL),
(8183, '229302205', 'ARNAV VINOD NAIR', 'arnav.229302205@muj.manipal.edu', '', '$2y$10$VvQ1v0BusWBc3TX9FyD/NOCwcH7vcQbv/MjaMexcFhbAo/uICDKGG', 'C', '6', '2021', NULL, 0, NULL),
(8184, '229302206', 'RITESH MISHRA', 'ritesh.229302206@muj.manipal.edu', '', '$2y$10$8RfcBX0ljhVpZKKFoAPBo.7cA8yHhjW5uxR0rCWg11dynfH98V5ti', 'C', '6', '2021', NULL, 0, NULL),
(8185, '229302207', 'HONEY TRIVEDI', 'honey.229302207@muj.manipal.edu', '', '$2y$10$eruCbCR99RAEHkR258yo7.veTgF2yuuz0YzdW.aCL7JdwOruHjnJS', 'C', '6', '2021', NULL, 0, NULL),
(8186, '229302208', 'RASHI MALVIYA', 'rashi.229302208@muj.manipal.edu', '', '$2y$10$Ekncorvi8hhsgtsbg19y7eIRm8Rnd.ebBMmaX5gg4UuRcJuNUuKC6', 'C', '6', '2021', NULL, 0, NULL),
(8187, '229302209', 'MANNAN ARORA', 'mannan.229302209@muj.manipal.edu', '', '$2y$10$tgtsTEMsRETrWcK3C4Ocd./c8ri8ez2UpGgJ7kFHTuSZaphX5AJ1.', 'C', '6', '2021', NULL, 0, NULL),
(8188, '229302211', 'ADITYA CHANDRASHEKAR PRABHUDESSAI', 'aditya.229302211@muj.manipal.edu', '', '$2y$10$4pL19AQK4cL2H5F9P5SiOeayuUHqXNZJ2iiL3.e8HLF4saf9YaE8G', 'C', '6', '2021', NULL, 0, NULL),
(8189, '229302215', 'GUNISH BAKSHI', 'gunish.229302215@muj.manipal.edu', '', '$2y$10$PluH7lttHfaBR8pdha7Z/uehxaMpPsSgZ.nzZB/UrQR0Qc45nrqf.', 'C', '6', '2021', NULL, 0, NULL),
(8190, '229302217', 'SYAMANTAK PAUL', 'syamantak.229302217@muj.manipal.edu', '', '$2y$10$KW9odA6BfQLgAgvX.0ZSfOLhKqG11k6hTEZFZJfeZmnTGAUO7SKwa', 'C', '6', '2021', NULL, 0, NULL),
(8191, '229302220', 'ISHANKBANSAL', 'ishankbansal.229302220@muj.manipal.edu', '', '$2y$10$hAEAqzs33Yq7ld.w/N0hj./tfC7ZMDT7RAzq0s4CX4kRSuTcQvg16', 'C', '6', '2021', NULL, 0, NULL),
(8192, '229302221', 'CHIRAG MISHRA', 'chirag.229302221@muj.manipal.edu', '', '$2y$10$sX9lCDBTTfuwkaSwbOoOhuG1iXHZmwcWOyzRgEHRB8sTQMtEv6NGm', 'C', '6', '2021', NULL, 0, NULL),
(8193, '229302222', 'KRISHNA SHARMA', 'krishna.229302222@muj.manipal.edu', '', '$2y$10$RJE9eYYk2zkQASSlrf3X.OtJuHrF3YDK.1voWIBuYGY.dAS9C6WvG', 'C', '6', '2021', NULL, 0, NULL),
(8194, '229302223', 'SHIKHA CHHABRA', 'shikha.229302223@muj.manipal.edu', '', '$2y$10$yxC1D9B7H/GDY3u8a3kaM.zOGwmevslY5oHNu8bBiJtkyv5oX3AJG', 'C', '6', '2021', NULL, 0, NULL),
(8195, '229302227', 'PAKSH RAHEJA', 'paksh.229302227@muj.manipal.edu', '', '$2y$10$VZevk3rjSFZgyQy2bydXYOComht/yHs3OxSPPpBf145NuUniHR9RG', 'C', '6', '2021', NULL, 0, NULL),
(8196, '229302229', 'AILIN CHEN', 'ailin.229302229@muj.manipal.edu', '', '$2y$10$ZM6X3UfqeveGXI3cQUvFp.XCFxeze.TZgxtAoAXsDA89NoYI0vLR.', 'C', '6', '2021', NULL, 0, NULL),
(8197, '229302230', 'SHREYA GUPTA', 'shreya.229302230@muj.manipal.edu', '', '$2y$10$dApqQKDuC30j1RTwc2P56ORnpAcJdPcQScQwvqsC9vEN/sVmf0ljW', 'C', '6', '2021', NULL, 0, NULL),
(8198, '229302231', 'KUSHAGRA DWIVEDI', 'kushagra.229302231@muj.manipal.edu', '', '$2y$10$1okVozcIG4imcUM5C.8nn.4CEqlwnr31RqTI0Wp9LGV6ukTTqipFe', 'C', '6', '2021', NULL, 0, NULL),
(8199, '229302232', 'B VENKATA VISHWAJEETH SAI', 'b.229302232@muj.manipal.edu', '', '$2y$10$9HgoH1EoTq4kzAyxGpHEje3yzkizNbTMMWOrOrF/WRZY4FDCZS9Xu', 'C', '6', '2021', NULL, 0, NULL),
(8200, '229302236', 'HARSHNEET KHANNA', 'harshneet.229302236@muj.manipal.edu', '', '$2y$10$/kJxS0Rld95MVp.hHP/hLuDrmuSY0ibmZM.jiDdvS2U2jlImoR6py', 'C', '6', '2021', NULL, 0, NULL),
(8201, '229302237', 'DEEPANSHU SINHA', 'deepanshu.229302237@muj.manipal.edu', '', '$2y$10$A6ssGCbdi3WfJC3IduoaT.k6vK0nj6vLzxQw1ntuziKs11FQqo6w6', 'C', '6', '2021', NULL, 0, NULL),
(8202, '229302238', 'RHYTHEM SHARMA', 'rhythem.229302238@muj.manipal.edu', '', '$2y$10$KPKUMwL0qDsjehrQcxeovu./jGid.06hrgp/xi7tS80s8yBzdOzyO', 'C', '6', '2021', NULL, 0, NULL),
(8203, '229302240', 'SHASHWAT SINGH', 'shashwat.229302240@muj.manipal.edu', '', '$2y$10$wWVEyfMQVtD.FKvs8zqYveAOOFyUUhcTqwua4Q2yHyHuqasHV5VJu', 'C', '6', '2021', NULL, 0, NULL),
(8204, '229302242', 'PRANJAL SINGH', 'pranjal.229302242@muj.manipal.edu', '', '$2y$10$NG3rxg4BY8IFyG.RHsHzAO5DJLsnGF8Dr8NpaVKnOW213epRyacWe', 'C', '6', '2021', NULL, 0, NULL),
(8205, '229302244', 'NAVNEET', 'navneet.229302244@muj.manipal.edu', '', '$2y$10$LqilD6J.pyep6I698X1Ksuy9NpbuVax93IjOxJm0woWykBEnn8MsG', 'C', '6', '2021', NULL, 0, NULL),
(8206, '229302246', 'SHIV SINGH', 'shiv.229302246@muj.manipal.edu', '', '$2y$10$Yk74tut3eIywv/BcELkAsOrKErk1TYsjqfolADJOJttH2NkKWhlBC', 'C', '6', '2021', NULL, 0, NULL),
(8207, '229302251', 'SNEHA MANAN', 'sneha.229302251@muj.manipal.edu', '', '$2y$10$A.xzeckjhP6nMlnT4q9fCO9r4veqMzQ8o.Uu6JSfnZV2/cr79DDkC', 'C', '6', '2021', NULL, 0, NULL),
(8208, '229302252', 'PRIYAL ALOK GOENKA', 'priyal.229302252@muj.manipal.edu', '', '$2y$10$cG0/X3pPnf2o5LqxiXlUpuX64e7C/dsgRidmcqSTpSoP1cDMD0FKm', 'C', '6', '2021', NULL, 0, NULL),
(8209, '229302253', 'KARTIKEYA GUPTA', 'kartikeya.229302253@muj.manipal.edu', '', '$2y$10$upCBaUMDsUaV5xUM53QTfu9iI4rpwvM1tQFK7EJ3fLUtLWyRtj1Vy', 'C', '6', '2021', NULL, 0, NULL),
(8210, '229302254', 'KAMYA SINGH', 'kamya.229302254@muj.manipal.edu', '', '$2y$10$5t1/b8NgR9gXgFeAe51AeezFa.G0.wqMgaqn/22KMvo3QfjQX1pGS', 'C', '6', '2021', NULL, 0, NULL),
(8211, '229302255', 'ARPIT GOSWAMI', 'arpit.229302255@muj.manipal.edu', '', '$2y$10$lBMPyiG0IELv/Fzqtb80E.ip8SeRYRKvF8pnS0mtAhgUIJTTw5n0e', 'C', '6', '2021', NULL, 0, NULL),
(8212, '229302257', 'YASH DHRUV', 'yash.229302257@muj.manipal.edu', '', '$2y$10$ufktp3RoiIWfE.t.TnuXM.zYbvXYcbYJoC0dr.C4KBIsZ8X/HifEO', 'C', '6', '2021', NULL, 0, NULL),
(8213, '229302259', 'PRAVEEN PUROHIT', 'praveen.229302259@muj.manipal.edu', '', '$2y$10$FjUI4AZFdtJ4Nv.oPtAPo.v.RuewolEkNpFleC.jH4.KUZqk0diJa', 'C', '6', '2021', NULL, 0, NULL),
(8214, '229302260', 'ANSHUL KUMAR SINGH', 'anshul.229302260@muj.manipal.edu', '', '$2y$10$pl5TtxOceD3WwKh4AtcMu.teZgaE3kNJ3q9lwbRopbaI2JqYkizVq', 'C', '6', '2021', NULL, 0, NULL),
(8215, '229302261', 'LAKSHAY TYAGI', 'lakshay.229302261@muj.manipal.edu', '', '$2y$10$XXTwWzG4N0DaDCY.k/jjNu2oDnnsORu0hiRSV45jWKaQ8nfKGne9u', 'C', '6', '2021', NULL, 0, NULL),
(8216, '229302262', 'HARSH YADAV', 'harsh.229302262@muj.manipal.edu', '', '$2y$10$W6ptqaVWTuZp8PEAxYSRwun4caHY8wda3E5V6bFzpAEFiHaKaikoO', 'C', '6', '2021', NULL, 0, NULL),
(8217, '229302263', 'ALDEN SAVIO DCUNHA', 'alden.229302263@muj.manipal.edu', '', '$2y$10$oPvum149n5LWS8dsFsj6mOdJqvviDJwbomtrtOqrRscL/hC4XNDp6', 'C', '6', '2021', NULL, 0, NULL),
(8218, '229302266', 'UTKARSH', 'utkarsh.229302266@muj.manipal.edu', '', '$2y$10$eQQvoZmENWcMTwJW.W.Vk.RHP.oQh/ud/l/q.jOKV.vSjaEkdq9kW', 'C', '6', '2021', NULL, 0, NULL),
(8219, '229302268', 'OM VEER SINGH', 'om.229302268@muj.manipal.edu', '', '$2y$10$ob71cKkqcFwKFj07FsVgSuU1bdE3MolSlgPxy6M5ASwmod9oLiJXW', 'C', '6', '2021', NULL, 0, NULL),
(8220, '229302269', 'DIYA JEEVAN', 'diya.229302269@muj.manipal.edu', '', '$2y$10$PCEAQzNaIw5LwNq.P6dOpuvj56QPWchOuN.0B6H2tLSl0AMQt0n8i', 'C', '6', '2021', NULL, 0, NULL),
(8221, '229302272', 'ANANYA GUPTA', 'ananya.229302272@muj.manipal.edu', '', '$2y$10$iNm62uLtRtwYi7MARwmE0eiJEwiwsNiw17Vhy3gCn/j2jq8CEL6wC', 'C', '6', '2021', NULL, 0, NULL),
(8222, '229302274', 'RAGHAV KALRA', 'raghav.229302274@muj.manipal.edu', '', '$2y$10$AKfO.PBbL2cqkmoFGNQSCuIONVOvtqk.9SPt2CtZBjyC45W4ty/PO', 'C', '6', '2021', NULL, 0, NULL),
(8223, '229302275', 'SWATI NAYAK', 'swati.229302275@muj.manipal.edu', '', '$2y$10$giknBsjGT3kbX04ThMpT5.PCJS5BdmfxYkwPyzbBRy8YTji6ZIXGy', 'C', '6', '2021', NULL, 0, NULL),
(8224, '229302276', 'DINESH JAKHAR', 'dinesh.229302276@muj.manipal.edu', '', '$2y$10$Irdpn5urcXh8Glb1DIzFDOoetjEdoqqB2rJSHIdoF4Att2mhqAEBO', 'C', '6', '2021', NULL, 0, NULL),
(8225, '229302299', 'SNEHA JADHAV', 'sneha.229302299@muj.manipal.edu', '', '$2y$10$yI/a.6szrfJhOq54qvY6eOFSjr5KljkFPV7f8VuVlbrmdLSoua6ga', 'C', '6', '2021', NULL, 0, NULL),
(8226, '229302651', 'RAJ PATIL', 'raj.229302651@muj.manipal.edu', '', '$2y$10$rZPn7mclLcGvnU5vRX8HJOspUGYpNFz8.hzSoS2dbfHTZ22fuXpc.', 'C', '6', '2021', NULL, 0, NULL),
(8227, '229302239', 'SHIVAM KUMAR', 'shivam.229302239@muj.manipal.edu', '', '$2y$10$g0YZLuEgV2BZbigO5oSytu4d3eCJz98oEJgEitY41O.tlJilEafaS', 'D', '6', '2021', NULL, 0, NULL),
(8228, '229302277', 'NISHA SINGH', 'nisha.229302277@muj.manipal.edu', '', '$2y$10$XnKvjlVZAZQxj/k8nu/0tuLf.8x5RJpuo62mAiey4oKEF3jDFQ.ty', 'D', '6', '2021', NULL, 0, NULL),
(8229, '229302278', 'YUVRAJ SINGH BHULLAR', 'yuvraj.229302278@muj.manipal.edu', '', '$2y$10$8DYmLbglr9/R1pNP.DI8q.TBMUtfUQqZVxmyiae0o0GmUJx4VsvdO', 'D', '6', '2021', NULL, 0, NULL),
(8230, '229302279', 'PRIYANSH SINGH PATEL', 'priyansh.229302279@muj.manipal.edu', '', '$2y$10$5tPCpo/01ZS7JA0DKIRXvOB/93CyD8T1mxdnTf0mF3rr0hDmoHwEC', 'D', '6', '2021', NULL, 0, NULL),
(8231, '229302282', 'ASHRAF VALIYAPEEDIYAKKALSHOUKATH', 'ashraf.229302282@muj.manipal.edu', '', '$2y$10$Foztl4YztqQ.1tQhB.YRYucjWzsctcSRj5urZia2t7rd51aDrCmBi', 'D', '6', '2021', NULL, 0, NULL),
(8232, '229302284', 'SIDDHARTH PAL', 'siddharth.229302284@muj.manipal.edu', '', '$2y$10$OD/rCjHKxgKMvuTILbJrLu3GKA3IHnkFRYUaOdR.uTO.si/FHfdJq', 'D', '6', '2021', NULL, 0, NULL),
(8233, '229302285', 'SWATANTRA CHOUDHARY', 'swatantra.229302285@muj.manipal.edu', '', '$2y$10$LaccbQnaPsLd1/oLVDaqmOwvwARxuGyGDqVDmxhkyug3uiR/S6noy', 'D', '6', '2021', NULL, 0, NULL),
(8234, '229302286', 'MOHARIL SAHIL SANJAY', 'moharil.229302286@muj.manipal.edu', '', '$2y$10$NAc/5tNFss9ljQvHaDAn9uIFQeoa5CP21Sg8guQt58Ko56BCdQ/me', 'D', '6', '2021', NULL, 0, NULL),
(8235, '229302290', 'ADITYA KUMAR', 'aditya.229302290@muj.manipal.edu', '', '$2y$10$Z5FxiiWnDJFLjVyKdu2n5u7RbjvRkPpQWCP9hU1fWmLXqoEM/dMTm', 'D', '6', '2021', NULL, 0, NULL),
(8236, '229302291', 'KARAN SINGH', 'karan.229302291@muj.manipal.edu', '', '$2y$10$2oELrtJkQKO4m0xtrfJWCO2mMdvYcVhIKq/PZUX5mbvlWdkkalZFu', 'D', '6', '2021', NULL, 0, NULL),
(8237, '229302292', 'KUSHAGRA PRIYAM', 'kushagra.229302292@muj.manipal.edu', '', '$2y$10$huHrzvtxeqVFEREu24xXfuVWjHyCA7JTbulS/n3cZ0VDFlSIeHtwC', 'D', '6', '2021', NULL, 0, NULL),
(8238, '229302293', 'KISHOR MEYYAPPAN', 'kishor.229302293@muj.manipal.edu', '', '$2y$10$nkstIDI/IYNGtYjJ5PpLi.n7qw2.p8Vx3w4aCde.BKs1utnd9AZCi', 'D', '6', '2021', NULL, 0, NULL),
(8239, '229302294', 'RAHUL DENDUKURI', 'rahul.229302294@muj.manipal.edu', '', '$2y$10$gbwFNXtu.4Cy6663/9gpHeiFXKhSnCoMVNBzRtSqxiDaeRYZrU0nK', 'D', '6', '2021', NULL, 0, NULL),
(8240, '229302295', 'CHIRAG PATRA', 'chirag.229302295@muj.manipal.edu', '', '$2y$10$KcHjKxebtuN4A1RgR8G0DOLVNKVZ5n7j4AjE8XKR0Yj6Nn7XXwBOW', 'D', '6', '2021', NULL, 0, NULL),
(8241, '229302297', 'ASHWIN PARAG JIWANE', 'ashwin.229302297@muj.manipal.edu', '', '$2y$10$vW88rPkhGO5GpIIhdd7cOOxoQMTiGgl0q1KD/T6paOpSaSFnAx80e', 'D', '6', '2021', NULL, 0, NULL),
(8242, '229302298', 'KRISHNAV GUPTA', 'krishnav.229302298@muj.manipal.edu', '', '$2y$10$E6fs1bUZfqkM72PQlyip4Onia8eXe/SjYTXa1EKHuMvF0eiPpjdFm', 'D', '6', '2021', NULL, 0, NULL),
(8243, '229302301', 'RAAHIM', 'raahim.229302301@muj.manipal.edu', '', '$2y$10$uMjmboLn0V3Kx8DxNv6sheUAYF2PhcfLPdwGT.lSVpf4yuA7CuciC', 'D', '6', '2021', NULL, 0, NULL),
(8244, '229302302', 'SAMRIDDHI DWIVEDI', 'samriddhi.229302302@muj.manipal.edu', '', '$2y$10$VroFQubUnoCG3R9v0NHguu78b3Te1wKl9ZmuWWwEXcZn/dg.34SgW', 'D', '6', '2021', NULL, 0, NULL),
(8245, '229302303', 'ABHISHEK RAJESH DESHPANDE', 'abhishek.229302303@muj.manipal.edu', '', '$2y$10$0lg8pkAEdDpmD3ADIpt.Z.B87jQ/YHJmv71od2ZO2XYR5HIRxuQDO', 'D', '6', '2021', NULL, 0, NULL),
(8246, '229302304', 'PRAGYA SINGH', 'pragya.229302304@muj.manipal.edu', '', '$2y$10$Yh0DhH0pojl0FFaLKAlBSucOoDeUKk6GXHjSeRyOSKStNifE.z.Z6', 'D', '6', '2021', NULL, 0, NULL),
(8247, '229302305', 'AKANKSHA SINHA', 'akanksha.229302305@muj.manipal.edu', '', '$2y$10$vQif0dndYj1MduLp91aAAeWb1XhcbX9.6dLwpjnXevKek1ifaisD6', 'D', '6', '2021', NULL, 0, NULL),
(8248, '229302306', 'VISHANK GAUTAM', 'vishank.229302306@muj.manipal.edu', '', '$2y$10$V5yef7sPWR1W6b22MA4OT.9zz0ziuyr4gFtHp2vTh1fYa52ka0g/e', 'D', '6', '2021', NULL, 0, NULL),
(8249, '229302309', 'ANURAG TIWARI', 'anurag.229302309@muj.manipal.edu', '', '$2y$10$Zamd4Bw3xyFXovOlZ1rqeu9kO8qZq32IDHwUwpkrv34Lv2kj72zZ.', 'D', '6', '2021', NULL, 0, NULL),
(8250, '229302310', 'PUSHKAR GAUR', 'pushkar.229302310@muj.manipal.edu', '', '$2y$10$EaYjV1GNWr4FXNhGcEhIC.9yjUD4hsjcJbAxxbHOl4x8LbTwRtwJC', 'D', '6', '2021', NULL, 0, NULL),
(8251, '229302311', 'OJAS MAHAJAN', 'ojas.229302311@muj.manipal.edu', '', '$2y$10$Ax6eAPnonj3ZqgPpCxpFSelhMRXNjLba1W3tlquXAyeakA8Vpcr3G', 'D', '6', '2021', NULL, 0, NULL),
(8252, '229302312', 'ADVIT CHUDIWALE', 'advit.229302312@muj.manipal.edu', '', '$2y$10$E6FfCpqAG/bJa0NVwjnMju7Zm/ihKSflAEvHLDbLPP3mt.TYZFTVm', 'D', '6', '2021', NULL, 0, NULL),
(8253, '229302314', 'BHAVYA BHASKAR', 'bhavya.229302314@muj.manipal.edu', '', '$2y$10$bxfD.eDw4cugmpIys/7Yu.tB5VMBlQ2XHt97MR5/1tP8QFJKL490K', 'D', '6', '2021', NULL, 0, NULL),
(8254, '229302317', 'SIDDHANT GARG', 'siddhant.229302317@muj.manipal.edu', '', '$2y$10$3KyyyEgURla6ftKd.8DCRuG25TxJJrqO2u0uBQ3yUP7yWxZBU5N3G', 'D', '6', '2021', NULL, 0, NULL),
(8255, '229302318', 'AJAY SHARMA', 'ajay.229302318@muj.manipal.edu', '', '$2y$10$RHdHBiTZ5PgqYOLRAaP1AuGshmb3wnt0WZkJvkJ2Q/oDCB03P8uY.', 'D', '6', '2021', NULL, 0, NULL),
(8256, '229302319', 'AKSHAT MISHRA', 'akshat.229302319@muj.manipal.edu', '', '$2y$10$NyGMI5VAnnLfjSzZH/QenekLoiIuk.Uk7ld7HjAs5k7Ir/mbr4kaq', 'D', '6', '2021', NULL, 0, NULL),
(8257, '229302320', 'ARYAN SRIVASTAVA', 'aryan.229302320@muj.manipal.edu', '', '$2y$10$cUl6yg/.0fHxjjzR0XJ8v.3voO.KnU97T0sm2oxlRfYKz4G8qnXL.', 'D', '6', '2021', NULL, 0, NULL),
(8258, '229302321', 'NAMAN SACHDEVA', 'naman.229302321@muj.manipal.edu', '', '$2y$10$wRXLKK39FoFlK2CuIBL8bONAJkTzm0WWSoUi1MEDxsuOIa.aYn9l2', 'D', '6', '2021', NULL, 0, NULL),
(8259, '229302323', 'VANSHAJ AGARWAL', 'vanshaj.229302323@muj.manipal.edu', '', '$2y$10$jVJgoaxJpsG2DdoICHnCDeScmdwN58A3FEyeJMw5kIe1OMhEERRrO', 'D', '6', '2021', NULL, 0, NULL),
(8260, '229302324', 'NISHANT KUMAR SINHA', 'nishant.229302324@muj.manipal.edu', '', '$2y$10$5YF59hSWqnZWss8aWWNjleRqAqGtjVqGK6okhlPYeoB6tHDirHS4C', 'D', '6', '2021', NULL, 0, NULL),
(8261, '229302326', 'RISHI BAKLIWAL', 'rishi.229302326@muj.manipal.edu', '', '$2y$10$riRO.vftPjm/9a1099t7K.2QhaWBJi.K7aoMso92YSqB8PYNQrmLO', 'D', '6', '2021', NULL, 0, NULL),
(8262, '229302329', 'GARVIT SINGH', 'garvit.229302329@muj.manipal.edu', '', '$2y$10$hltkTI7tcj4nG2egtewW4uTtfxby01yQxDPqywZebsJlpe636tcWe', 'D', '6', '2021', NULL, 0, NULL),
(8263, '229302331', 'ARYAN MITTAL', 'aryan.229302331@muj.manipal.edu', '', '$2y$10$xR.2VRnISbe7dSjO9D8S.OMWbf4SGuq3ZZWHbLg7GnvV4IxlT6rKK', 'D', '6', '2021', NULL, 0, NULL),
(8264, '229302333', 'ROUNAK AMBASTHA', 'rounak.229302333@muj.manipal.edu', '', '$2y$10$PEjL38O7yAeiWe/kQLSKxOQsr9yCMSBv/s0lg2ozYw8EMXHyvwBTu', 'D', '6', '2021', NULL, 0, NULL),
(8265, '229302335', 'SHIVAM SHANDILYA', 'shivam.229302335@muj.manipal.edu', '', '$2y$10$nvEffrAy396gZNCZmi96oOCFmAPeE22oI1Ew/NeGt9EXQ/13V6x3W', 'D', '6', '2021', NULL, 0, NULL),
(8266, '229302338', 'ABHINAV UPADHYAY', 'abhinav.229302338@muj.manipal.edu', '', '$2y$10$gl9/5ua0zqkiJ40.Axz0VeOQ.P2wHd5ULq4PQG/zJUVVcneaJDnAy', 'D', '6', '2021', NULL, 0, NULL),
(8267, '229302339', 'SUSHANK CHOUDHARY', 'sushank.229302339@muj.manipal.edu', '', '$2y$10$EbDEosROGE1jUoiQ1qVQQe.WGCBOwBNgWpsYUqkxNxLnpdfYFRKii', 'D', '6', '2021', NULL, 0, NULL),
(8268, '229302340', 'SHREYA SAIHGAL', 'shreya.229302340@muj.manipal.edu', '', '$2y$10$redYVFoH/BDjiHRYIrqDauXawf6jYNSk316GinSc9ajuVEUQCu23q', 'D', '6', '2021', NULL, 0, NULL),
(8269, '229302341', 'ARYAN MATHUR', 'aryan.229302341@muj.manipal.edu', '', '$2y$10$66AYKgaHnKazMmsxiT7Y4.ITtGFIRowqQ4ry47D/sqZKiBSKGgDQi', 'D', '6', '2021', NULL, 0, NULL),
(8270, '229302343', 'VINAMRA BHONSLE', 'vinamra.229302343@muj.manipal.edu', '', '$2y$10$TuvkgwvJgo.dkm9wv0rRFexG3LHuKH7bh0Nz2frLR0gn8X3V.brwy', 'D', '6', '2021', NULL, 0, NULL),
(8271, '229302344', 'ARYAN GUPTA', 'aryan.229302344@muj.manipal.edu', '', '$2y$10$Upxv6jKxkNn4K6eHYIQ2jOjayk.1eSi8htVZKz2YPPULKV8cuVG1K', 'D', '6', '2021', NULL, 0, NULL),
(8272, '229302346', 'AARYA ABHIJIT JOSHI', 'aarya.229302346@muj.manipal.edu', '', '$2y$10$IZM6aSbpDzNblVw7WZfDZ.Yo0JuIFL4z7qqcdjwNWdwUq1yJDb85m', 'D', '6', '2021', NULL, 0, NULL),
(8273, '229302349', 'PRIYANSH YADAV', 'priyansh.229302349@muj.manipal.edu', '', '$2y$10$YhUnxS20DRPn7KU80XqqXuSkx3tBHO9OJKB8.vK7cLsRiG0HbisLK', 'D', '6', '2021', NULL, 0, NULL),
(8274, '229302350', 'ARIN JAIN', 'arin.229302350@muj.manipal.edu', '', '$2y$10$z3X4H84lHa/2JalsaPT69OEnAr2wStyOtco5H9K6QsIFDApmDRlPu', 'D', '6', '2021', NULL, 0, NULL),
(8275, '229302351', 'ROHAN JOGALE', 'rohan.229302351@muj.manipal.edu', '', '$2y$10$45XxzxSFVm3cHjOIuLd43e8uKUDQCtU1tlbiUYyFtyhhsW5Xcmwfq', 'D', '6', '2021', NULL, 0, NULL),
(8276, '229302353', 'VASANT TOMAR', 'vasant.229302353@muj.manipal.edu', '', '$2y$10$yZwYIqeMf193MN2MVyQLnuJvwhT4jbbqoUjd8OjlwxakQb35MoxiC', 'D', '6', '2021', NULL, 0, NULL),
(8277, '229302355', 'RAHUL MANOHAR KENDRE', 'rahul.229302355@muj.manipal.edu', '', '$2y$10$/0FaXfzyv9pXvU/JeKNcnelkUbZA1JpXRi8rqu.H9RAayjYY9FoWi', 'D', '6', '2021', NULL, 0, NULL),
(8278, '229302359', 'SHIVENDRA PRATAP SINGH', 'shivendra.229302359@muj.manipal.edu', '', '$2y$10$e7DhuA4bx67co2t394pnh.aSR/SvK31gVq1hfoub3qdvXqdzeFu9W', 'D', '6', '2021', NULL, 0, NULL),
(8279, '229302360', 'RISHABH ALOK VASHISHTH', 'rishabh.229302360@muj.manipal.edu', '', '$2y$10$dJxMxGE3lKPsqQG16iyQcOlL73pFRGO6kctXFoZ/qv0lwjbvbjLgG', 'D', '6', '2021', NULL, 0, NULL),
(8280, '229302362', 'VEDANT KEOTE', 'vedant.229302362@muj.manipal.edu', '', '$2y$10$yHbFD6pITLNy1zU6MskWO.tzax6Jz50iAkQtVRng.nMnkjxnYNmrm', 'D', '6', '2021', NULL, 0, NULL),
(8281, '229302365', 'MANAS KUMAR', 'manas.229302365@muj.manipal.edu', '', '$2y$10$dqGpadfFanEPVzwjEvlFB.udWYgigrEFtrpIyqw6DJeKoLbKt.EYu', 'D', '6', '2021', NULL, 0, NULL),
(8282, '229302366', 'BAIBHAV KUMAR', 'baibhav.229302366@muj.manipal.edu', '', '$2y$10$pWXLM7Etk3sE6Z05m1H3jucDEBoTAVA/whHxsx/orE5CZS0ru6Vz2', 'D', '6', '2021', NULL, 0, NULL),
(8283, '229302367', 'MOHAMMAD FARAZ ALAM', 'mohammad.229302367@muj.manipal.edu', '', '$2y$10$758QH5mAEMil/wDUh.unNu9n4LE400rKffTJPVchDTiR8LojlZW9q', 'D', '6', '2021', NULL, 0, NULL),
(8284, '229302368', 'DHYAN', 'dhyan.229302368@muj.manipal.edu', '', '$2y$10$OM74icZeV4bsLe7QZjAQiO/uEXmPDLhho5x2wXkiv9mWYz8cOLZqO', 'D', '6', '2021', NULL, 0, NULL),
(8285, '229302369', 'LAKSHAY DHAWAN', 'lakshay.229302369@muj.manipal.edu', '', '$2y$10$cDn95kGUYnMVV7fn4I20IenUDUoBTt6hALEZcALTCEzQfupNBvN02', 'D', '6', '2021', NULL, 0, NULL),
(8286, '229302371', 'RISHIKA BHAGAWATI', 'rishika.229302371@muj.manipal.edu', '', '$2y$10$E6NjwXPSwqDcZk1S.onf9OaO99Eou/HABOEk87UgLCXDDzEoh4xq.', 'D', '6', '2021', NULL, 0, NULL),
(8287, '229302372', 'NAKUL J P SHRIVASTAVA', 'nakul.229302372@muj.manipal.edu', '', '$2y$10$6uwBaKypWqyw6KrRpTx8mOcRz/AVYJbDhLUdmVLCJ2GVGAd3rcw1S', 'D', '6', '2021', NULL, 0, NULL),
(8288, '229302050', 'ADITI PANDEY', 'aditi.229302050@muj.manipal.edu', '', '$2y$10$Tgv2KZDHOugobej/8k/ZkO.olRCzL56PqFrf7pOHaIOSYvL.Rtc2C', 'E', '6', '2021', NULL, 0, NULL),
(8289, '229302373', 'NEET JAIN', 'neet.229302373@muj.manipal.edu', '', '$2y$10$9J.jqjFBz5vXfBJ2jVGayeF2Q8VuXqbW4Pa2HM5ZKb7WI9WZPS5Hi', 'E', '6', '2021', NULL, 0, NULL),
(8290, '229302374', 'RACHIT SRIVASTAVA', 'rachit.229302374@muj.manipal.edu', '', '$2y$10$M7T9qVuKdfIKNPPEh5zaxu1tP8.sOTyigGXJX3ZauXzXC1j9ZzNUq', 'E', '6', '2021', NULL, 0, NULL),
(8291, '229302376', 'VANDANA', 'vandana.229302376@muj.manipal.edu', '', '$2y$10$BJYVacWgPS/N.KhedkptAOnFsujWxbq54OtSqgibwk0S9XFw4j/Z6', 'E', '6', '2021', NULL, 0, NULL),
(8292, '229302377', 'TANMAY TUSHAR', 'tanmay.229302377@muj.manipal.edu', '', '$2y$10$C66JR8tLFQdgnL9ZbfaVrO8aMso1OSnK.R2Rb6IC/aFh7kQuGQKAW', 'E', '6', '2021', NULL, 0, NULL),
(8293, '229302379', 'PRISHITA AWASTHI', 'prishita.229302379@muj.manipal.edu', '', '$2y$10$wUHNo3JrhC4V.h8x8MMqE.LEhYODbdonjSjDck9Cf/67pDexI/HBC', 'E', '6', '2021', NULL, 0, NULL),
(8294, '229302380', 'RITAM RAJ', 'ritam.229302380@muj.manipal.edu', '', '$2y$10$2KS66sBogNj9cmeZE0TYo.CXDQU4AcWEXKLXeNycWJtO/tJZx.zHC', 'E', '6', '2021', NULL, 0, NULL),
(8295, '229302381', 'VASU YADAV', 'vasu.229302381@muj.manipal.edu', '', '$2y$10$nGVwYoOu2DSDVGXj//hd6Oau4FZTO6G.0wb.6dmF3qqgNRJwMjleO', 'E', '6', '2021', NULL, 0, NULL),
(8296, '229302383', 'DEV KALRA', 'dev.229302383@muj.manipal.edu', '', '$2y$10$mnm9qmt2KJnk/zIy8/yyeOamCoh/8hhFofWttE7nMXmENYDR7mew6', 'E', '6', '2021', NULL, 0, NULL),
(8297, '229302384', 'AYAZ ALAM', 'ayaz.229302384@muj.manipal.edu', '', '$2y$10$mIVDWXo2G.sdM0FPZprxTu5V6vAFiqvoMVev8P2uDsxxlt1bqURKu', 'E', '6', '2021', NULL, 0, NULL),
(8298, '229302385', 'AJITESH DASGUPTA', 'ajitesh.229302385@muj.manipal.edu', '', '$2y$10$g.p5aghyMcEZefpfEEt9IeYluBP2gLA0dsNikGhOaslMIX3aOG6CK', 'E', '6', '2021', NULL, 0, NULL),
(8299, '229302387', 'PRAKARSH MEHROTRA', 'prakarsh.229302387@muj.manipal.edu', '', '$2y$10$fX0/sR9F4ZrA1et8OJGVROBv5CDicFP6K1Sr1.G.Kp6Clxeizy6Ie', 'E', '6', '2021', NULL, 0, NULL),
(8300, '229302388', 'RAJAT JOSHI', 'rajat.229302388@muj.manipal.edu', '', '$2y$10$Px/kptETAAnaSpCnJPGguOCvML9Hp/fQvMS8mp5GkPIX5WH0PBDHi', 'E', '6', '2021', NULL, 0, NULL),
(8301, '229302390', 'NISHANT MISHRA', 'nishant.229302390@muj.manipal.edu', '', '$2y$10$KG9qXa3VNq5mBXZP21K7f.OgWS0HtP0lUQ04to5nRB.bEYm3vI.wu', 'E', '6', '2021', NULL, 0, NULL),
(8302, '229302391', 'ERWIN PIMENTA', 'erwin.229302391@muj.manipal.edu', '', '$2y$10$.k7CXWyk2MHefbN5zHQUyeL7oW7ecIiztfSOMUfSWWJF.q23avFAm', 'E', '6', '2021', NULL, 0, NULL),
(8303, '229302393', 'KISLAY KUMAR', 'kislay.229302393@muj.manipal.edu', '', '$2y$10$1CBFZOTf56mr28NsRt8JOe7w5S/pjbeogEM0W6yE2nolLI.qdvBA.', 'E', '6', '2021', NULL, 0, NULL),
(8304, '229302395', 'HEER KHALASI', 'heer.229302395@muj.manipal.edu', '', '$2y$10$sBgg4mqlzeGt/T710D0npuS28kMYvLopKRmWWD4PXIyNIY.JdR0RS', 'E', '6', '2021', NULL, 0, NULL),
(8305, '229302398', 'MOHD AYAN KHAN', 'mohd.229302398@muj.manipal.edu', '', '$2y$10$vvH/r5enMC8yDzMbabuJK.Bc7n5F83ZQ1IlDwUHMbcl1JCmfQiptS', 'E', '6', '2021', NULL, 0, NULL),
(8306, '229302399', 'KRISH SHARMA', 'krish.229302399@muj.manipal.edu', '', '$2y$10$I/1Vm5.EANhZwfL97lF9VO0CjVO/ccb5Mt9Nutxppg1g5YURTJN2i', 'E', '6', '2021', NULL, 0, NULL),
(8307, '229302400', 'YASH THAPA', 'yash.229302400@muj.manipal.edu', '', '$2y$10$W4O7qhJJIKy4X9ThwZ3YZOcubWXrzDtCkXJysDHx0SRiysY4wS9Zm', 'E', '6', '2021', NULL, 0, NULL),
(8308, '229302401', 'ANSH GWARI', 'ansh.229302401@muj.manipal.edu', '', '$2y$10$4PsVYBRqnfOkwlmxnwvo9uJBLAta9kDuDgKvVBqFVsfvkjbPisGSu', 'E', '6', '2021', NULL, 0, NULL),
(8309, '229302407', 'DHRUV MENON', 'dhruv.229302407@muj.manipal.edu', '', '$2y$10$9Pv/Cby8swgvIG5P4VkiguXC1SODkgjbv1igug0S1SG0TkeIxMCIy', 'E', '6', '2021', NULL, 0, NULL),
(8310, '229302408', 'VARSHITA JAIN', 'varshita.229302408@muj.manipal.edu', '', '$2y$10$Ahq8jn1F0yrdhyuwY/U/EOK3gcHKgmzKB9X4dfLqEDdkdA9x2dMb.', 'E', '6', '2021', NULL, 0, NULL),
(8311, '229302410', 'ARYAN SINGH', 'aryan.229302410@muj.manipal.edu', '', '$2y$10$kMzzM123mUIjqPZpL3KHNu6IVuWtmnC9Bf2S9SN/Q474vymv/H7De', 'E', '6', '2021', NULL, 0, NULL),
(8312, '229302412', 'TSHERING THENDUP BHUTIA', 'tshering.229302412@muj.manipal.edu', '', '$2y$10$qxld6vXvrKV2nqgSlb0XkukK7nHzg0.uXGjZUiDQOxkuRBgMB1UhO', 'E', '6', '2021', NULL, 0, NULL),
(8313, '229302414', 'ANOUSHKA HITENDRA SHETTY', 'anoushka.229302414@muj.manipal.edu', '', '$2y$10$1IWMbW1FPJhAjCWSIzqwF.Asajmk5ngjmWZkkt1aAzVcIGsyu/i16', 'E', '6', '2021', NULL, 0, NULL),
(8314, '229302415', 'ARCHIT NIGAM', 'archit.229302415@muj.manipal.edu', '', '$2y$10$aj82tlTD.QNFFRvzirROv.l0GgHzzhDBLF0ymwIllT0mf72FuwcMa', 'E', '6', '2021', NULL, 0, NULL),
(8315, '229302417', 'AKSHAY PRATAP', 'akshay.229302417@muj.manipal.edu', '', '$2y$10$Ww1WzHv3tpX8FVuXbKxoYegqYkUQrbk63KLQ827MxVUOBjAJINwNq', 'E', '6', '2021', NULL, 0, NULL),
(8316, '229302420', 'JATIN TILWANI', 'jatin.229302420@muj.manipal.edu', '', '$2y$10$8grZa9WhrH6A7BN415T6gudsytbD8k4UhsORG007R0eE62LF7q45e', 'E', '6', '2021', NULL, 0, NULL),
(8317, '229302421', 'JYOTIRADITYA SINGH PARIHAR', 'jyotiraditya.229302421@muj.manipal.edu', '', '$2y$10$MJJ7vPEpNeeBVhX9K0I7Ou9qCcKvF4Rn.4z2oYWlOj2rtx7s6Z9QK', 'E', '6', '2021', NULL, 0, NULL),
(8318, '229302422', 'SHUBHAM KUKRETI', 'shubham.229302422@muj.manipal.edu', '', '$2y$10$eeojVFeFrvVjpwvqmHhbpek5pRoexc1SmvpokGlKHxdLTcw3ukOKO', 'E', '6', '2021', NULL, 0, NULL),
(8319, '229302423', 'RACHIT SRIVASTAVA', 'rachit.229302423@muj.manipal.edu', '', '$2y$10$Miqno828bobatmr.2kB2eumMWPHsq0fEELjgpQbIMjxs3UiU.odzy', 'E', '6', '2021', NULL, 0, NULL),
(8320, '229302424', 'ARVIND SHYLESH K', 'arvind.229302424@muj.manipal.edu', '', '$2y$10$L7jvs/0VUZo9Gj4urg2ITeElEBuqq6Z9pztciT2elth8ZusOYya8.', 'E', '6', '2021', NULL, 0, NULL),
(8321, '229302425', 'YUKTA MAHAJAN', 'yukta.229302425@muj.manipal.edu', '', '$2y$10$AHtA/kFwTP5JEXeVQZc63OkxSUZfwF7AMgM/jEgiCD8R4tAba.kxq', 'E', '6', '2021', NULL, 0, NULL),
(8322, '229302427', 'ANIMESH YADAV', 'animesh.229302427@muj.manipal.edu', '', '$2y$10$m1paB4jOmK9l0ao7uK61/eXPDmk6y7/p3u4gJ4uxuEPHICT2ibyWW', 'E', '6', '2021', NULL, 0, NULL),
(8323, '229302429', 'SHIVANSH PRATAP SINGH', 'shivansh.229302429@muj.manipal.edu', '', '$2y$10$WyvPOvvKKHYuZ.Gh2sEE4.T5iPAaBaUDWzEanK0wliyi43ObMH97C', 'E', '6', '2021', NULL, 0, NULL),
(8324, '229302430', 'KISLAY KUMAR', 'kislay.229302430@muj.manipal.edu', '', '$2y$10$I4MDIQBMYsHn3pdhsLGO3.Fmg/PzUE9r//0d6/qeRvK4m.xVwjJvm', 'E', '6', '2021', NULL, 0, NULL),
(8325, '229302431', 'T MRUDUL AMBARISH', 't.229302431@muj.manipal.edu', '', '$2y$10$rzihJkiXt3UpaTTJp83zVOYCq04SOiYf8Yg6OHJlVrTi3UcJun8ly', 'E', '6', '2021', NULL, 0, NULL),
(8326, '229302434', 'VEDIKA SACHIN BHOSALE', 'vedika.229302434@muj.manipal.edu', '', '$2y$10$jTqgR3F3wHCVEZbdeaHIbuo2aa0PqIitYkD6wSrOELtRX2L0etUbS', 'E', '6', '2021', NULL, 0, NULL),
(8327, '229302438', 'GAGAN MALIK', 'gagan.229302438@muj.manipal.edu', '', '$2y$10$nuwOI2QczekHhLkggg5VhuyWSKLzVb1ODVfZo1bqv1.prLgZZlGxq', 'E', '6', '2021', NULL, 0, NULL);
INSERT INTO `student` (`sr_no`, `registration_no`, `name`, `email`, `mobile_no`, `password`, `section`, `semester`, `year`, `image`, `failed_attempts`, `lock_until`) VALUES
(8328, '229302441', 'SHIVAM KUMAR', 'shivam.229302441@muj.manipal.edu', '', '$2y$10$YoH6Ba73hfNRw.cnTeWp6OGS9blfbbwgKvksSUjaWDD37omDDqsb6', 'E', '6', '2021', NULL, 0, NULL),
(8329, '229302443', 'ILIKA MAHAJAN', 'ilika.229302443@muj.manipal.edu', '', '$2y$10$UesKV6SyqeJcwZFKuV/VJutPwOZfQrX8PCRcqaMiZGbdFIhptJ6hW', 'E', '6', '2021', NULL, 0, NULL),
(8330, '229302445', 'VIKRANT JINDAL', 'vikrant.229302445@muj.manipal.edu', '', '$2y$10$cn57G7MEeMtId7czqjFlGuxacHgaJ8JJOJmwpcFWgc7qUDE3uRpUu', 'E', '6', '2021', NULL, 0, NULL),
(8331, '229302446', 'M DIG VIJAY', 'm.229302446@muj.manipal.edu', '', '$2y$10$kttFSy0wyDZs/wv2hx4pSO3SwMM0zxQNmBTvFLP7un4y2U6sH100C', 'E', '6', '2021', NULL, 0, NULL),
(8332, '229302447', 'KANISHK DHAWAN', 'kanishk.229302447@muj.manipal.edu', '', '$2y$10$ZzDOoefbsaW2QI//RKLhUuWPPLLTQothp5LSKBpjipB3nMK1MID96', 'E', '6', '2021', NULL, 0, NULL),
(8333, '229302448', 'ARYAN YADAV', 'aryan.229302448@muj.manipal.edu', '', '$2y$10$q1rOMFppD8CpXLyWb.4Hw.U3F0gwzvLfhsf2Yv.2/PkG0cExqcFjG', 'E', '6', '2021', NULL, 0, NULL),
(8334, '229302453', 'DHRUV BHARDWAJ', 'dhruv.229302453@muj.manipal.edu', '', '$2y$10$.VRAC2vRJcngz3TjQSZ7gur33NtdD7YEPobGk18dte9M3CEF4044G', 'E', '6', '2021', NULL, 0, NULL),
(8335, '229302454', 'KRISH RAO', 'krish.229302454@muj.manipal.edu', '', '$2y$10$RweePslju7DCcKfqq06uBOT4nu7G2uPiEh.cFBuPPcrUPNfL13TT.', 'E', '6', '2021', NULL, 0, NULL),
(8336, '229302455', 'VIDUSHI GUPTA', 'vidushi.229302455@muj.manipal.edu', '', '$2y$10$p4Q5PxE5SmXp3ZUMnegxr.wLs72fxU6nYNDwOoydlYVu6r0HK4kei', 'E', '6', '2021', NULL, 0, NULL),
(8337, '229302456', 'SAMARDEEP SINGH BHASIN', 'samardeep.229302456@muj.manipal.edu', '', '$2y$10$Ef6ICZqgg/I41FEkQMQZXe.PHdwLsqgQYTFQjYdQAD7Cn4.VK.3Zi', 'E', '6', '2021', NULL, 0, NULL),
(8338, '229302457', 'ANANDA CHATURVEDI', 'ananda.229302457@muj.manipal.edu', '', '$2y$10$siy2Q5f88kznx5DpOP19iu//nsNqumMoP1.57cLDUty2Gl0HiCgB2', 'E', '6', '2021', NULL, 0, NULL),
(8339, '229302459', 'MADHU G', 'madhu.229302459@muj.manipal.edu', '', '$2y$10$czK6h4RHrolF.qem4LC5VuD.9rRbpalgVBkCl3tlT1IIvxKvtxMwq', 'E', '6', '2021', NULL, 0, NULL),
(8340, '229302461', 'TANISHK NAGDA', 'tanishk.229302461@muj.manipal.edu', '', '$2y$10$oF.enqV4CVxIZ1Q9wVK6yOpQ0pJYeWm3cTPqI1bqStv/2k7AOI5xK', 'E', '6', '2021', NULL, 0, NULL),
(8341, '229302462', 'VARUN PUROHIT', 'varun.229302462@muj.manipal.edu', '', '$2y$10$MUfbLH6dss49X4X2euPN0OXcz6ZxXNhVJIijT.dBQ9hGa5E3LMiYm', 'E', '6', '2021', NULL, 0, NULL),
(8342, '229302463', 'SATYAM CHAUDHARY', 'satyam.229302463@muj.manipal.edu', '', '$2y$10$einOnsUgRAEPf6IpNOlzcOoQBI4gLwK4hJ7e4x8fvwHbRocKPNdgm', 'E', '6', '2021', NULL, 0, NULL),
(8343, '229302464', 'MAHIKA SHUKLA', 'mahika.229302464@muj.manipal.edu', '', '$2y$10$qes29KOv05THZ8RWY34zgeKnDbLVoelT5jqdED5lRQX8HWQDVLCZe', 'E', '6', '2021', NULL, 0, NULL),
(8344, '229302468', 'ARYAMAN SINGH', 'aryaman.229302468@muj.manipal.edu', '', '$2y$10$MUUvSuGJWbYf3lznfRGa/Ov/4Sdp0uSBeFKpm1xxyiWm68PODAjY2', 'E', '6', '2021', NULL, 0, NULL),
(8345, '229302469', 'RAGHAVKAKANI', 'raghavkakani.229302469@muj.manipal.edu', '', '$2y$10$AonXJVPjrB3xQ5aovVJY.eKAr9WG7.i.UBbS0QmMZctDDkCvaeKMC', 'E', '6', '2021', NULL, 0, NULL),
(8346, '229302470', 'POULAM SAHA', 'poulam.229302470@muj.manipal.edu', '', '$2y$10$OaGafl33SRKayZMujzcTI.oLqUf0Hza6Sg88MMCHFAUdb/Yhk5Jim', 'E', '6', '2021', NULL, 0, NULL),
(8347, '229302498', 'ANI GUPTA', 'ani.229302498@muj.manipal.edu', '', '$2y$10$B8.O/BX5.tsw9vG/ns8b3e2vKOnlKJyoITxXhuTnc6E.xFDAfNKbG', 'E', '6', '2021', NULL, 0, NULL),
(8348, '229302520', 'ASMAN BINDRA', 'asman.229302520@muj.manipal.edu', '', '$2y$10$rl.Ss9ZRca.PHXq9JyQBleXzJA4V891NPIawFLHqaKTMIpMtGCkd2', 'E', '6', '2021', NULL, 0, NULL),
(8349, '229302653', 'GUNJAN TICKOO', 'gunjan.229302653@muj.manipal.edu', '', '$2y$10$EJVowifJIzKwMLJJCAdj0OnzP5c43eWEMhmgwOiOkecuuT/Bf5qCu', 'E', '6', '2021', NULL, 0, NULL),
(8350, '229303065', 'PUNEET SHARMA', 'puneet.229303065@muj.manipal.edu', '', '$2y$10$DJyA7o4ELNSNQX.bbDmZiOe.rLaKRD0iLc3rZJZ4G4UK/DaZZoOFu', 'E', '6', '2021', NULL, 0, NULL),
(8351, '219302288', 'Manav', 'manav.219302288@muj.manipal.edu', '', '$2y$10$iMsTEk7YUlxlOv6muWMokeOXdiXg3Qg0ZJSXxOEzIL3m7RvGux0yC', 'E', '6', '2021', NULL, 0, NULL),
(8352, '229302466', 'MANAS GUPTA', 'manas.229302466@muj.manipal.edu', '', '$2y$10$ZQHytSpS8whgYIh0yAA8IeYytljnZng9leq7YqgNNrXeu7qgRGUny', 'F', '6', '2021', NULL, 0, NULL),
(8353, '229302467', 'VINAY', 'vinay.229302467@muj.manipal.edu', '', '$2y$10$wRhLhjSIWO/Uy5onj5gQderGwwB75bJxNsfHpDrfwTpNcsvkUoH6i', 'F', '6', '2021', NULL, 0, NULL),
(8354, '229302471', 'ROHIT KOSHY', 'rohit.229302471@muj.manipal.edu', '', '$2y$10$ZAYk.3UYe8VdWfKxhTihUuyynS1HyuMfEXosrJaMMlJxEQ.i7pQEu', 'F', '6', '2021', NULL, 0, NULL),
(8355, '229302472', 'VAIBHAV SRIVASTAVA', 'vaibhav.229302472@muj.manipal.edu', '', '$2y$10$ugm2c6WVP.tAjtdUtEkXQe6vOKlhm86fAQ3qhAPcB3igtQZenCoFy', 'F', '6', '2021', NULL, 0, NULL),
(8356, '229302473', 'ROHIT SINGH', 'rohit.229302473@muj.manipal.edu', '', '$2y$10$UAp4UAF2Ah9er9YvG6bvjedhPdLXMa4wICQ5RDcLp1w5Iy6RvF3Xy', 'F', '6', '2021', NULL, 0, NULL),
(8357, '229302474', 'SANIA SUNIL', 'sania.229302474@muj.manipal.edu', '', '$2y$10$FwibS4Bgr1ALwhe3Qcf0DuF9c9boOOgUMl/Gh6lH9bdn71oDZFU/6', 'F', '6', '2021', NULL, 0, NULL),
(8358, '229302475', 'TISHA DHAMSANIA', 'tisha.229302475@muj.manipal.edu', '', '$2y$10$SkshIl9oe/o4GKwf4C5iA.87Rp2laRew8b/PfJQQowETW8icYSQDe', 'F', '6', '2021', NULL, 0, NULL),
(8359, '229302476', 'ASEEM RAI', 'aseem.229302476@muj.manipal.edu', '', '$2y$10$xyrQu48LLWYk.bGe/LfB6O9Yz9R3P9gaH9TPvSVdg59Ke2czwDhVO', 'F', '6', '2021', NULL, 0, NULL),
(8360, '229302477', 'SAUNIL BAJPAI', 'saunil.229302477@muj.manipal.edu', '', '$2y$10$KpNasiMH1fgJVa5ArY9vKe.EqvJ2OVyx1bK.LWwjs88LbfgAgng7C', 'F', '6', '2021', NULL, 0, NULL),
(8361, '229302478', 'DIVYAM SHARMA', 'divyam.229302478@muj.manipal.edu', '', '$2y$10$Vv.5./S9sgYXbLVsx8DZHOJzLokWgwSGdkNJWekRw.pvz9g7R9ZoC', 'F', '6', '2021', NULL, 0, NULL),
(8362, '229302479', 'ANSH SHARMA', 'ansh.229302479@muj.manipal.edu', '', '$2y$10$edzSdlTV75KhP6gKmaB6A.XvmqgvpJaOvH2StJuUbQt9pqy18P8mq', 'F', '6', '2021', NULL, 0, NULL),
(8363, '229302480', 'KARTIK', 'kartik.229302480@muj.manipal.edu', '', '$2y$10$GAtF98OxDI.Souv3KJ6tluH5xKA9yehgCkvWbcAUhyvAMPXyknzq.', 'F', '6', '2021', NULL, 0, NULL),
(8364, '229302481', 'PRATYUSH DEEP', 'pratyush.229302481@muj.manipal.edu', '', '$2y$10$wcxAUicruS5SXZrFnYcX3O9BuGnEuv8c0lGIWpTruV4X5jRU0DQFu', 'F', '6', '2021', NULL, 0, NULL),
(8365, '229302483', 'DHRUV MAHARISHI', 'dhruv.229302483@muj.manipal.edu', '', '$2y$10$XjeLO6LVP6qGDFYVbnlIVezExCtadZMMCR5L9OSQAo0yeJYwA6gbq', 'F', '6', '2021', NULL, 0, NULL),
(8366, '229302484', 'PRAJWAL MALPANI', 'prajwal.229302484@muj.manipal.edu', '', '$2y$10$dPUH.SpMjlHnZvdFBkhQFeUai2LA8Q125hjNA7w.vc6E6Jsz3.A.i', 'F', '6', '2021', NULL, 0, NULL),
(8367, '229302485', 'AAYUSHI SHARMA', 'aayushi.229302485@muj.manipal.edu', '', '$2y$10$sR02AfHDPLiKnV9PGfi02eBAvz5Vwfpvn3qjKGiSXsfMPkzDbRCeS', 'F', '6', '2021', NULL, 0, NULL),
(8368, '229302486', 'VAISHNAVI PAROLIA', 'vaishnavi.229302486@muj.manipal.edu', '', '$2y$10$UHq/vII61X.8yyzl6rQKJ.rNEh8slJbTfni0LuDLQNAzG0w3ec0CK', 'F', '6', '2021', NULL, 0, NULL),
(8369, '229302487', 'KUNAL KUMAR', 'kunal.229302487@muj.manipal.edu', '', '$2y$10$AwoKDdPRn0VSMAxoa4BT2O8E.UhffoaN0Ad3bfo03s0duUeTiSnM.', 'F', '6', '2021', NULL, 0, NULL),
(8370, '229302489', 'VITARNA SHARMA', 'vitarna.229302489@muj.manipal.edu', '', '$2y$10$eX.InQwHwGCIY1wQvCljjuD2s7eF8JYxV60LddrTq1bJ0BBsMBGEC', 'F', '6', '2021', NULL, 0, NULL),
(8371, '229302490', 'ASHUTOSH NARAYAN', 'ashutosh.229302490@muj.manipal.edu', '', '$2y$10$sQg0KwP4R.IkXiFj7HJSYeH8nIfLqdBTqChyWY/vmVGzjkLvxXBIu', 'F', '6', '2021', NULL, 0, NULL),
(8372, '229302491', 'DIVYAANSH SINGH', 'divyaansh.229302491@muj.manipal.edu', '', '$2y$10$jv/uEu7KO5fTYgNywmpIsOMMcLBJqhH5cjM7sjKVTVU8p4lALWhMy', 'F', '6', '2021', NULL, 0, NULL),
(8373, '229302492', 'PRABHAV TEWARI', 'prabhav.229302492@muj.manipal.edu', '', '$2y$10$5Lm77IBY1NCEz1RBep9sm.oTHrqp8j/UP75fRq.ljNhScHiZCzCFi', 'F', '6', '2021', NULL, 0, NULL),
(8374, '229302494', 'AYUSH RAJ', 'ayush.229302494@muj.manipal.edu', '', '$2y$10$/UqfDOM4IeVuL6.aDZsFu.xczAa/HjAcVdi2zF6271RBUhmc6UYn.', 'F', '6', '2021', NULL, 0, NULL),
(8375, '229302496', 'MAAHIN AFNAAN ALAM KHAN', 'maahin.229302496@muj.manipal.edu', '', '$2y$10$LNxrBRz/fs/54KoC2Jwx8.JaR2Df7u7JZiffp4BrxCy/JbwXp5JaC', 'F', '6', '2021', NULL, 0, NULL),
(8376, '229302499', 'AVNI GOEL', 'avni.229302499@muj.manipal.edu', '', '$2y$10$dsChbD44RpGyaW/DdXh34.ILlUoHK3bxtEjCva1YtjzWaQZCjQxEe', 'F', '6', '2021', NULL, 0, NULL),
(8377, '229302500', 'ANSH MAURYA', 'ansh.229302500@muj.manipal.edu', '', '$2y$10$dcmYMKGGqAkqqi3Ab9UkEucVe7K8jcNIMjlQCUdbbQJbzNV/6rbKW', 'F', '6', '2021', NULL, 0, NULL),
(8378, '229302501', 'SUJAL KUMAR SETHI', 'sujal.229302501@muj.manipal.edu', '', '$2y$10$i433.GMKUXuXTZYRc7breu7YAmMj0dpFFNTdsunl87t29sGgd0Mt6', 'F', '6', '2021', NULL, 0, NULL),
(8379, '229302502', 'DIGVIJAY NANDAN', 'digvijay.229302502@muj.manipal.edu', '', '$2y$10$62fh1EJjhJny6tjsw0JB9OpmfdNhv3k.XqXcur6wmQArIj/cDoMpi', 'F', '6', '2021', NULL, 0, NULL),
(8380, '229302503', 'TUSHAR KHANCHANDANI', 'tushar.229302503@muj.manipal.edu', '', '$2y$10$c80.ux3FYiVrLIWvLhHtK.ogmqt.FJhQIsBTWbFFrDehxkzKYICMO', 'F', '6', '2021', NULL, 0, NULL),
(8381, '229302504', 'VISHU SHUKLA', 'vishu.229302504@muj.manipal.edu', '', '$2y$10$ZXwk2Uv0KMuU8TpT9JOP2ePN6vkThI65tLRpr4yQLz9kYDw.RG2Ri', 'F', '6', '2021', NULL, 0, NULL),
(8382, '229302505', 'AHTESHAM HAIDER', 'ahtesham.229302505@muj.manipal.edu', '', '$2y$10$6SIzT5hiUhGUIN2.XjKSNevbABjeGHNbyVX6CaWkCL0/fqsklGWuG', 'F', '6', '2021', NULL, 0, NULL),
(8383, '229302506', 'AYUSH CHATURVEDI', 'ayush.229302506@muj.manipal.edu', '', '$2y$10$2.L2yuTakT/2PkAsRk9cWOHTQiazcBPB5nemhHiIUIbx/C9CINPeu', 'F', '6', '2021', NULL, 0, NULL),
(8384, '229302507', 'ASTHA AGRAWAL', 'astha.229302507@muj.manipal.edu', '', '$2y$10$5sHrbms7C/0P2I56uxv/muAcxJND6sydoV1ZC/Ty2dGdp.LXlyU7.', 'F', '6', '2021', NULL, 0, NULL),
(8385, '229302508', 'MUSKAN GUPTA', 'muskan.229302508@muj.manipal.edu', '', '$2y$10$a8Z05/d1Fdz9Ru1rdBbn7eqXL9nXo29Kn99NZOvvD8OCJJzCMliji', 'F', '6', '2021', NULL, 0, NULL),
(8386, '229302509', 'PIYUSH SHARMA', 'piyush.229302509@muj.manipal.edu', '', '$2y$10$cfpr5niOBwyhB00rd2AOPeFWUO5QtYvQpbxSnTB3EzARZ4QfQDDeC', 'F', '6', '2021', NULL, 0, NULL),
(8387, '229302510', 'PREET GAHLAWAT', 'preet.229302510@muj.manipal.edu', '', '$2y$10$6ny54CJJPAqxVo9RmEXbHeuFWrW0jNrMHUfWQd4CqUUf0Z.B54oFq', 'F', '6', '2021', NULL, 0, NULL),
(8388, '229302511', 'UJJWAL SINGH', 'ujjwal.229302511@muj.manipal.edu', '', '$2y$10$zYCxwSaOre6rBV05D7kYZefD2yJp9AIuWw2Vs0iuvEfrt9NU1Hrr2', 'F', '6', '2021', NULL, 0, NULL),
(8389, '229302512', 'SHOBHIT SRIVASTAVA', 'shobhit.229302512@muj.manipal.edu', '', '$2y$10$zXNYSeVqdANCEGHrzxTbYed7MKuysFK2E75PayBmR94VzrMDBHJeC', 'F', '6', '2021', NULL, 0, NULL),
(8390, '229302513', 'PRARTHANA SRIVASTAVA', 'prarthana.229302513@muj.manipal.edu', '', '$2y$10$DoPJoD0YL15dNrkcVJJ7TO65y3zu.f7IH5CWL61mNE.wG1MGXFEZi', 'F', '6', '2021', NULL, 0, NULL),
(8391, '229302514', 'HARDIK KHANNA', 'hardik.229302514@muj.manipal.edu', '', '$2y$10$GfF13OXuXr0edj.8ckQXkeSo3.6iNAyOuP2mK6Wwul3w.XOpYzJBq', 'F', '6', '2021', NULL, 0, NULL),
(8392, '229302515', 'NAVYA MEHTA', 'navya.229302515@muj.manipal.edu', '', '$2y$10$dIrbaHcm9jJxDOAhfCQJAOOiHPOpsaPUTPLV5Xl.1b6DCTZOUoiuq', 'F', '6', '2021', NULL, 0, NULL),
(8393, '229302516', 'ROHIT OJHA', 'rohit.229302516@muj.manipal.edu', '', '$2y$10$7Vz.1ss3qreal01LxZo3auonDAYoMR8LtjIWig63UBXcrETxKCN/y', 'F', '6', '2021', NULL, 0, NULL),
(8394, '229302517', 'DEVANSH SINGH', 'devansh.229302517@muj.manipal.edu', '', '$2y$10$wPn2rgLzeh0HCmPJODtoh.3uy6zqN84/qMnzgHGH4ocTOdz.t0zZO', 'F', '6', '2021', NULL, 0, NULL),
(8395, '229302518', 'SURYANSH MISHRA', 'suryansh.229302518@muj.manipal.edu', '', '$2y$10$QwUdNZzneBc2GDgteZMFh.8r.ScMJERkf2ZwMBJnYLnOQ6wc2HhbK', 'F', '6', '2021', NULL, 0, NULL),
(8396, '229302519', 'GAURAV KALYANKAR', 'gaurav.229302519@muj.manipal.edu', '', '$2y$10$c62n/p5SbZn7eEy6Uv.wxuxKj1uEW28nClxg30CLDKxVq/hyUNjZG', 'F', '6', '2021', NULL, 0, NULL),
(8397, '229302521', 'PIYUSH KUMAR MAURYA', 'piyush.229302521@muj.manipal.edu', '', '$2y$10$aF9L5ZyHto2FcvUaST.yy..LcTPqV3ogU/LKltkIPe3xyPetUaWEe', 'F', '6', '2021', NULL, 0, NULL),
(8398, '229302522', 'ARYAN SINGH', 'aryan.229302522@muj.manipal.edu', '', '$2y$10$ssnSlpOYfQ91r1PwSMw2xuxv.DAzBuXKFneoaEurLgQjDCpESPyEa', 'F', '6', '2021', NULL, 0, NULL),
(8399, '229302523', 'ABHINAV ANAND', 'abhinav.229302523@muj.manipal.edu', '', '$2y$10$xiya0GgnbGxm4Ar4bvG4/eYbSpPmFyV5DHtzio09OJwx17OzpaGjW', 'F', '6', '2021', NULL, 0, NULL),
(8400, '229302524', 'YASHVI SUMIT NEEMA', 'yashvi.229302524@muj.manipal.edu', '', '$2y$10$wdxzGOIMjbyYwcmkj14FDeADLtM3QxymIJntH40Yr1iO0eOma7xIK', 'F', '6', '2021', NULL, 0, NULL),
(8401, '229302525', 'ATASHI SARASWAT', 'atashi.229302525@muj.manipal.edu', '', '$2y$10$RdO5v6g3XUjdytoVPMnQnu36Ewyqipxea6pavbDUrKX5aCz4PEUcm', 'F', '6', '2021', NULL, 0, NULL),
(8402, '229302526', 'DHRUV BAREJA', 'dhruv.229302526@muj.manipal.edu', '', '$2y$10$1Pmcbmo8JaNrIO62JHZi8OAq2cR5xgI8PvpKCvJ6vDHWQmTb8p3wm', 'F', '6', '2021', NULL, 0, NULL),
(8403, '229302527', 'ARYAN SAXENA', 'aryan.229302527@muj.manipal.edu', '', '$2y$10$J1vcDiN8XMjhUCce5sq//.a13SDJ8ZGg8I24I3vBKyc4MYH0SxKTq', 'F', '6', '2021', NULL, 0, NULL),
(8404, '229302528', 'MUKUL YADAV', 'mukul.229302528@muj.manipal.edu', '', '$2y$10$IlJgYpOLTzSK9lglm2BUn.iHy4mV4RMSGyLftfHAhB1.BKqZb//Ki', 'F', '6', '2021', NULL, 0, NULL),
(8405, '229302529', 'UTKARSH KALRA', 'utkarsh.229302529@muj.manipal.edu', '', '$2y$10$6UuP4k34EhiHrn.mZX3pzuVyjrYo/rBkVfkfRo8VzK8Hjvsd6faDi', 'F', '6', '2021', NULL, 0, NULL),
(8406, '229302530', 'KHUSHI AGARWAL', 'khushi.229302530@muj.manipal.edu', '', '$2y$10$4uwgwDoilQo4v3eXbhDpruH/jfpoxNpNuRA6JpMQupJxVd7o36ZZ6', 'F', '6', '2021', NULL, 0, NULL),
(8407, '229302531', 'MAYANK GUPTA', 'mayank.229302531@muj.manipal.edu', '', '$2y$10$LYzf8J./jeSoMDOG4Hayq.ERPhbCq6L1WpKKUCi3mzngbLmXSFq0i', 'F', '6', '2021', NULL, 0, NULL),
(8408, '229302532', 'SAMEER KUMAR', 'sameer.229302532@muj.manipal.edu', '', '$2y$10$zcGOudtHcxr.vPuFyTYKf.1PuX1eUdZu0983cPIRKcO01BQSadMnC', 'F', '6', '2021', NULL, 0, NULL),
(8409, '229302534', 'RASHI SHIVA', 'rashi.229302534@muj.manipal.edu', '', '$2y$10$nFRy0Qhw7l9sP92PX9kYieTLBSGriPb3Tc4Nu1pFZngHxU7i5tBsG', 'F', '6', '2021', NULL, 0, NULL),
(8410, '229302535', 'ASLESH PRIYADARSAN PATRA', 'aslesh.229302535@muj.manipal.edu', '', '$2y$10$n4IplXZz93ZA67MhREF0QuS1tzkIY42urIccnmzSHJbSa665zYqQq', 'F', '6', '2021', NULL, 0, NULL),
(8411, '229302536', 'SHREJA SHEKHAR', 'shreja.229302536@muj.manipal.edu', '', '$2y$10$GGqon8yxMwAZpuRqDwnoTukX71k26hw6OeIAXaHHtdgDC319HIWJe', 'F', '6', '2021', NULL, 0, NULL),
(8412, '229302538', 'ANUBHAV BHARDWAJ', 'anubhav.229302538@muj.manipal.edu', '', '$2y$10$dDXjhfXC7tNzUVAT6UvnieRHkHU6LuLsRUTpJXvhjgw1cl2tW7ltm', 'F', '6', '2021', NULL, 0, NULL),
(8413, '229302539', 'SANCHIT RANA', 'sanchit.229302539@muj.manipal.edu', '', '$2y$10$S4HdKVaeIBEa9BUf3Jaohe9VeAmLkCsOwNDBEWjSi4qwlBZieA5eu', 'F', '6', '2021', NULL, 0, NULL),
(8414, '229303164', 'ANUSHKA SINGH', 'anushka.229303164@muj.manipal.edu', '', '$2y$10$p1AS/DXYGcPZtP..A/oHruzTQowvr1mLkQfrD5tGxfugId8jl7ZeC', 'F', '6', '2021', NULL, 0, NULL),
(8415, '229302540', 'ABHINEET MATHUR', 'abhineet.229302540@muj.manipal.edu', '', '$2y$10$Hyyh0gAvbRybKeKWHeuXq.OTHO9zUNp57tWxYDO2rUH.XeTnzL8fq', 'G', '6', '2021', NULL, 0, NULL),
(8416, '229302541', 'PALAK AGRAWAL', 'palak.229302541@muj.manipal.edu', '', '$2y$10$bZqUUS79Mhwhkg1G/8SaR.jlK9.20DTgFw4UXSKP3yJSKJJCdvfcS', 'G', '6', '2021', NULL, 0, NULL),
(8417, '229302542', 'AYUSHI SHUKLA', 'ayushi.229302542@muj.manipal.edu', '', '$2y$10$yuOJOZYquByP8VbWAt5aRO1fJkCv31qsgUWnlK/w8SY.8CUMiWbyK', 'G', '6', '2021', NULL, 0, NULL),
(8418, '229302543', 'SPARSH SRIVASTAVA', 'sparsh.229302543@muj.manipal.edu', '', '$2y$10$4Cp/CtApLtjxedG6hzb7/O1V.bfuRfUg6hEqmNV5cG2NBYzoM9u4i', 'G', '6', '2021', NULL, 0, NULL),
(8419, '229302545', 'MOHIT', 'mohit.229302545@muj.manipal.edu', '', '$2y$10$1Wp5qfXTqBtb/YXyYjJLYuF32Lmog0khIF0hryobcVZ6UFIgmLkjW', 'G', '6', '2021', NULL, 0, NULL),
(8420, '229302546', 'KASHISH ADWANI', 'kashish.229302546@muj.manipal.edu', '', '$2y$10$wa3zrfrH.B3uCu4yxTdCveSDN51Ag5l/Rf9WJaCi4huvcqr90jE8.', 'G', '6', '2021', NULL, 0, NULL),
(8421, '229302547', 'HARSH UPADHYAY', 'harsh.229302547@muj.manipal.edu', '', '$2y$10$h2gjr9IOWHv3MJeph08bMuqIsy912quAfFFN4yyKGwRgQ6q209bHK', 'G', '6', '2021', NULL, 0, NULL),
(8422, '229302548', 'HARSHIT RAWAT', 'harshit.229302548@muj.manipal.edu', '', '$2y$10$w4NRyIIaCdq5BEeq6NH2W.oUYOX4c8RWOXc2/6q1.Bd15r.6e8RAa', 'G', '6', '2021', NULL, 0, NULL),
(8423, '229302549', 'PARTH CHATURVEDI', 'parth.229302549@muj.manipal.edu', '', '$2y$10$6sEPKEkqAOeApUY6e/kMleTDu1qQrqsTgVtdhwXp1re6qg4j3Ss/O', 'G', '6', '2021', NULL, 0, NULL),
(8424, '229302550', 'SRIJNAA KHATTAR', 'srijnaa.229302550@muj.manipal.edu', '', '$2y$10$OYvXXMewtUFTFdv35US4GOzP71Hh3VMjPWvdOMvBuGjZZH7ssyV5q', 'G', '6', '2021', NULL, 0, NULL),
(8425, '229302551', 'JANHVI ARVIND KURKURE', 'janhvi.229302551@muj.manipal.edu', '', '$2y$10$NEKR7BBZ9WtZAMUBfyBLT.KHiogLUnrfEA9u5rXb05wYbCaUn9oka', 'G', '6', '2021', NULL, 0, NULL),
(8426, '229302553', 'LAKSHYA KASANA', 'lakshya.229302553@muj.manipal.edu', '', '$2y$10$dS9fYN7Oj275gURE5UtpUOl8VM6PhvhSfKF0ajLwQiYvsXoZPYf4a', 'G', '6', '2021', NULL, 0, NULL),
(8427, '229302555', 'HARSH BHALWAR', 'harsh.229302555@muj.manipal.edu', '', '$2y$10$xqmZkaNKddS5NDdlehVe3uJLvewAVS5MVAPngNVszk4JtKZXoVLnq', 'G', '6', '2021', NULL, 0, NULL),
(8428, '229302557', 'SMRITI YADAV', 'smriti.229302557@muj.manipal.edu', '', '$2y$10$r1NKa3dfig0rc81uuMDMmOn.49qcEtD9jOGpgrY.iPW6D9GYbPROu', 'G', '6', '2021', NULL, 0, NULL),
(8429, '229302558', 'UTKARSH PALIWAL', 'utkarsh.229302558@muj.manipal.edu', '', '$2y$10$njO2ZU61cERABaIxr6lhiOfMIXn/I2Bh2YNm9V1Yh/b4s7q5re9VK', 'G', '6', '2021', NULL, 0, NULL),
(8430, '229302559', 'KUMAR RAUNAK', 'kumar.229302559@muj.manipal.edu', '', '$2y$10$kSZ7rK9zSqN4SqUXGDGvOO/Punzv0lLALvhDHQHTnYWTW4FVwY3UW', 'G', '6', '2021', NULL, 0, NULL),
(8431, '229302560', 'AVIKA SOMYA', 'avika.229302560@muj.manipal.edu', '', '$2y$10$GqY.zNnYpS0aUzukORcKnuOaSYRlTTPbUjE4NgqL4RkymIrM4FCYC', 'G', '6', '2021', NULL, 0, NULL),
(8432, '229302561', 'RAGHAV', 'raghav.229302561@muj.manipal.edu', '', '$2y$10$LcfSospY5.Ln6T9btYZe8.l6oPaXroUW6jK3wi5hQel6Oftm3J4Gq', 'G', '6', '2021', NULL, 0, NULL),
(8433, '229302563', 'DIVYANSH MAROO', 'divyansh.229302563@muj.manipal.edu', '', '$2y$10$ig86lu9ViGzQVwv9HC9cYeE.vaJpGOXRqDpI2bf8XHlkJHdAxXpJa', 'G', '6', '2021', NULL, 0, NULL),
(8434, '229302564', 'SHAURYA KUMAR SINGH', 'shaurya.229302564@muj.manipal.edu', '', '$2y$10$Cea/tZoC3tgAlHM0H3JR7ezMf7uxXZvIlCs2XRXOSxbeELGrNioQq', 'G', '6', '2021', NULL, 0, NULL),
(8435, '229302565', 'DHRUV KHANDELWAL', 'dhruv.229302565@muj.manipal.edu', '', '$2y$10$iiGQEGQtDHZ5rUPbwKe8i.OsJvc1SkXDq.SIAIchPqTndWgNEXua6', 'G', '6', '2021', NULL, 0, NULL),
(8436, '229302566', 'ANMOL SRIVASTAVA', 'anmol.229302566@muj.manipal.edu', '', '$2y$10$e9txAphnh2TDBE/bJHZhR.26mHyE5j0p8.KBTEGsPJGxg.LmEJSiG', 'G', '6', '2021', NULL, 0, NULL),
(8437, '229302567', 'SARTHAK', 'sarthak.229302567@muj.manipal.edu', '', '$2y$10$Aa0zmY/gk7r1BxOhce/RSODOpUMtUZ5.KpzHSGias6orP0bnwrH46', 'G', '6', '2021', NULL, 0, NULL),
(8438, '229302568', 'SHREYASH YADUWANSHI', 'shreyash.229302568@muj.manipal.edu', '', '$2y$10$I6ifY.x3syZ4012a5zLNCOmQXIP0ufTdi8ZuOcX4vuK5ujTQJ8u5.', 'G', '6', '2021', NULL, 0, NULL),
(8439, '229302569', 'NYASHA DAGA', 'nyasha.229302569@muj.manipal.edu', '', '$2y$10$Qh/3KnfXiRupjtYzi8o0VeQVKdEq7h4UtGUTNpjkioKEBolzy4adS', 'G', '6', '2021', NULL, 0, NULL),
(8440, '229302570', 'NANDINI SHARMA', 'nandini.229302570@muj.manipal.edu', '', '$2y$10$I8lT5O2yoj3HXSebF9kmW.EsvWNNaK/lbPusl4yS0C4r4hyXEBT0G', 'G', '6', '2021', NULL, 0, NULL),
(8441, '229302571', 'SHREYA KUMARI', 'shreya.229302571@muj.manipal.edu', '', '$2y$10$89uYaMPhjYVRmbNy0bkez.Jw5wI2fYOQba6LPr9NxphoRSFgnOVTm', 'G', '6', '2021', NULL, 0, NULL),
(8442, '229302572', 'HANSHITA POPLANI', 'hanshita.229302572@muj.manipal.edu', '', '$2y$10$idsMoycoNSQ1b5G9pq2k4O7005oFYNlNmSzPufYHtwJTDpCxf1PFe', 'G', '6', '2021', NULL, 0, NULL),
(8443, '229302573', 'GAURAV SINGH SHEKHAWAT', 'gaurav.229302573@muj.manipal.edu', '', '$2y$10$X3MlTuWYkAn20YdO0DSIG.0tvP.EM4yfR4C03hBReYfvnngKSRTwm', 'G', '6', '2021', NULL, 0, NULL),
(8444, '229302574', 'SUPRIYA KATIYAR', 'supriya.229302574@muj.manipal.edu', '', '$2y$10$RHNVU4CRShyNVekREsVT/OuzqvnTL/Gz5rWpF1LoxDKoQ4PtwCn9m', 'G', '6', '2021', NULL, 0, NULL),
(8445, '229302575', 'RISHABH NENAWATI', 'rishabh.229302575@muj.manipal.edu', '', '$2y$10$2pSkGUZW.6z7Ye.vxkmsV.0SO7vxCEKx2IRsOKuXBA2WRa4plUydy', 'G', '6', '2021', NULL, 0, NULL),
(8446, '229302576', 'MAHESHARDEEP SINGH', 'maheshardeep.229302576@muj.manipal.edu', '', '$2y$10$zRl9GDVcQzdqOWwxPHjAG.xjVrF9MjQqfq3CYpneqIcTFQvqa7Scu', 'G', '6', '2021', NULL, 0, NULL),
(8447, '229302578', 'PARUL BHALOTHIA', 'parul.229302578@muj.manipal.edu', '', '$2y$10$A8LzPmoWFtHym8JNj4AA1es7lGQWLP5sutnNaDni/x9XB1XoQABHa', 'G', '6', '2021', NULL, 0, NULL),
(8448, '229302580', 'SHASHANK GUPTA', 'shashank.229302580@muj.manipal.edu', '', '$2y$10$XSSV4cE6Y3LyK1Hwc0NoqOMD5eiio2KFEyc8.ZZMjGokhfZjvZL5O', 'G', '6', '2021', NULL, 0, NULL),
(8449, '229302583', 'SHREYANSH AGARWAL', 'shreyansh.229302583@muj.manipal.edu', '', '$2y$10$xUISv.2EcUDTzzh0fylKxeEt.tVwpOKLaLrPKE2DyqKC1Q8QoAY9.', 'G', '6', '2021', NULL, 0, NULL),
(8450, '229302584', 'SHASHWAT RAJ', 'shashwat.229302584@muj.manipal.edu', '', '$2y$10$JM.4a55WGseOG0GTHel/3.hKfSdBogf95lQmvp4jRbj98jw1LD4oG', 'G', '6', '2021', NULL, 0, NULL),
(8451, '229302585', 'VAIBHAV KUMAR', 'vaibhav.229302585@muj.manipal.edu', '', '$2y$10$POg9Eq8zDUXLjQs7pr.8n.nuKrtdZaTbBMOKeujNXJJ9yiSFY32si', 'G', '6', '2021', NULL, 0, NULL),
(8452, '229302587', 'PRIYANSU MUKESHBHAI PATEL', 'priyansu.229302587@muj.manipal.edu', '', '$2y$10$LiNLeoF9U2hr14bLd0SKKO9/bnLPTheJLFsgCBxZM.CrCaUk6uxsq', 'G', '6', '2021', NULL, 0, NULL),
(8453, '229302588', 'TARUN GUPTA', 'tarun.229302588@muj.manipal.edu', '', '$2y$10$3aXOC1OK3VABPDglvguyY.bzkfQDtROeqnFUOIDv6lE48Gr1nFeYW', 'G', '6', '2021', NULL, 0, NULL),
(8454, '229302589', 'SABRINA KHANNA', 'sabrina.229302589@muj.manipal.edu', '', '$2y$10$vrtNPDwZVdmkTc.9IgqxYOLVaO7zpIA40QvnKguvMnoyleO6Q41ka', 'G', '6', '2021', NULL, 0, NULL),
(8455, '229302590', 'G.SAI LINISHA REDDY', 'linisha.229302590@muj.manipal.edu', '', '$2y$10$HttDFbCrEVL3bTWskxhAwuFGx/9S0nPIwP.4Y.LKX6Jj6L.B5AvPG', 'G', '6', '2021', NULL, 0, NULL),
(8456, '229302591', 'PRANAV BHARDWAJ', 'pranav.229302591@muj.manipal.edu', '', '$2y$10$cHANcgtmK.rFnpWjxOGvseDK1X9MOAIJrXuXyq9/2wp1hdTnMc1Oe', 'G', '6', '2021', NULL, 0, NULL),
(8457, '229302592', 'VIVEK YADAV', 'vivek.229302592@muj.manipal.edu', '', '$2y$10$stw0mFXgddb8pNXMlzxr0uiQMdFGUE42B5qiSKqcLc7lHEL6tM6my', 'G', '6', '2021', NULL, 0, NULL),
(8458, '229302593', 'SHEERSH BANSAL', 'sheersh.229302593@muj.manipal.edu', '', '$2y$10$7X3xQZCWBWfOM6xsqp9oQO5ojynIhtKZwPlz80OpqfggAbaqzUiLe', 'G', '6', '2021', NULL, 0, NULL),
(8459, '229302594', 'DEVYANSH MISHRA', 'devyansh.229302594@muj.manipal.edu', '', '$2y$10$pyNtpzro5UKX4Y7Hg7uhgOemiH8ZO5YWKLoCMeQcxt4AzvzJGj24i', 'G', '6', '2021', NULL, 0, NULL),
(8460, '229302595', 'SWARNIM RAJPUT', 'swarnim.229302595@muj.manipal.edu', '', '$2y$10$26VHvlZIWOQyovuFeiI.1.q1siYiMP2dV.YdYErMS43otktmo/UeG', 'G', '6', '2021', NULL, 0, NULL),
(8461, '229302596', 'AASTHA CHOUBEY', 'aasttha.229302596@muj.manipal.edu', '', '$2y$10$uedt69hPnzN6/C.RRC3CUudEJ.w9qlb3xsNv4a3qsVleAPxNGPioC', 'G', '6', '2021', NULL, 0, NULL),
(8462, '229302597', 'SAKSHAM LAKHANI', 'saksham.229302597@muj.manipal.edu', '', '$2y$10$NlNCLrWaNAPgr1HbbW4rgutLoVFXW.rQOq0aagfVgIhrBHS61eNTG', 'G', '6', '2021', NULL, 0, NULL),
(8463, '229302598', 'SHASHANK SONI', 'shashank.229302598@muj.manipal.edu', '', '$2y$10$ArLWQhOQe0gYL0YHFrV71O.ar3XEgqHAsS4N5ru1yK98nmpParcFC', 'G', '6', '2021', NULL, 0, NULL),
(8464, '229302599', 'VAIBHAV CHOUHAN', 'vaibhav.229302599@muj.manipal.edu', '', '$2y$10$oWKjoyhvtdU.cpn/Uw08EurnEDrS.cblfM/c80lYYxBH6nqmcXQQC', 'G', '6', '2021', NULL, 0, NULL),
(8465, '229302600', 'GAURAV JAIN', 'gaurav.229302600@muj.manipal.edu', '', '$2y$10$/9RtxPPSJRtEVe0NSPzldOdDRkh1gS94T8/VWRY2hlcKetDXqRtDG', 'G', '6', '2021', NULL, 0, NULL),
(8466, '229302601', 'ARJUN KUMAR', 'arjun.229302601@muj.manipal.edu', '', '$2y$10$bPBkZvoqZNOQHIst34BD3.G6N0Znaa95Bv0j.3cIbxaFp1QGlq/fa', 'G', '6', '2021', NULL, 0, NULL),
(8467, '229302602', 'JAY GUPTA', 'jay.229302602@muj.manipal.edu', '', '$2y$10$vcolY49TOfUoGtsab3FaAuFzAzSpcwfNftN7KrFD.elLE06tbAkOW', 'G', '6', '2021', NULL, 0, NULL),
(8468, '229302603', 'BHAWNA RELHAN', 'bhawna.229302603@muj.manipal.edu', '', '$2y$10$sUALC6SEYexD0WvL3d5EtujKF9YBohoP62chesNNKRsq/LRG37r7O', 'G', '6', '2021', NULL, 0, NULL),
(8469, '229302604', 'PRAGATI SINHA', 'pragati.229302604@muj.manipal.edu', '', '$2y$10$/kUC.FzwhEno5ic7/lWxMeYnJGFD7A5QYeGhFTr/E7kwUnHo/iiPm', 'G', '6', '2021', NULL, 0, NULL),
(8470, '229302605', 'DHRUV RATHEE', 'dhruv.229302605@muj.manipal.edu', '', '$2y$10$V4ho41qMVSYopMZFFRBQZOLiLNKKOpTEpNMOBmm0Tk4p5kZOrAbWe', 'G', '6', '2021', NULL, 0, NULL),
(8471, '229302609', 'ARYAN MISHRA', 'aryan.229302609@muj.manipal.edu', '', '$2y$10$RmD3OM1gOYtNtkhvpLSqBO9OlijIKU4in4e1.bufu/S1ExsfGwK86', 'G', '6', '2021', NULL, 0, NULL),
(8472, '229302614', 'HONEY NAGPAL', 'honey.229302614@muj.manipal.edu', '', '$2y$10$Zua7GG66FUGxb1m6eCZNO.AcNKRQe4UTdm.rVOdd2dJg2D3ikUlYS', 'G', '6', '2021', NULL, 0, NULL),
(8473, '229302617', 'ADITYA RAJ', 'aditya.229302617@muj.manipal.edu', '', '$2y$10$VXvT0uM6ziwmhe0x8A.bJe8slRMfEy2XuScds.W.x27XSFhcZfOFe', 'G', '6', '2021', NULL, 0, NULL),
(8474, '229302618', 'SHOBHIT MATHURIA', 'shobhit.229302618@muj.manipal.edu', '', '$2y$10$AJm5Itvac29EsMd5Xe0cvuDy2HppVKMV5bsAY1pHKeVotPMMd29DK', 'G', '6', '2021', NULL, 0, NULL),
(8475, '229302621', 'ARSH GUPTA', 'arsh.229302621@muj.manipal.edu', '', '$2y$10$PlnQ4GDAXUaeAdJVY3CtCeMzJA6CcCqLmnxYoHTfnOMAzvR2ZNKX.', 'G', '6', '2021', NULL, 0, NULL),
(8476, '229302644', 'Ankur Kumar', 'ankur.229302644@muj.manipal.edu', '', '$2y$10$M5Co0emPf0MWl8j0D2DaF.Qmahn34b2cMzrswmU60DaIMFYvRPgQ2', 'G', '6', '2021', NULL, 0, NULL),
(8477, '229302428', 'PRATEEK SINGH', 'prateek.229302428@muj.manipal.edu', '', '$2y$10$sSQjLvxEHD40zF8CPt0qae4PXClAG/xv7H7jQ2MwpIU4N7A5r7xnq', 'H', '6', '2021', NULL, 0, NULL),
(8478, '229302622', 'SANYA GULATI', 'sanya.229302622@muj.manipal.edu', '', '$2y$10$2p4Zt5t1T1FLyIpHND5AVuzz9BEVtQdK5Mjrsq67Ch5hZlJZho6i2', 'H', '6', '2021', NULL, 0, NULL),
(8479, '229302623', 'AMOL GUPTA', 'amol.229302623@muj.manipal.edu', '', '$2y$10$snv/EuF13tT0KaOgue3BdO2VnVTX7V0lnBKHj2UacaD7nqz9Z2XmS', 'H', '6', '2021', NULL, 0, NULL),
(8480, '229302626', 'DAMAN DEEP KAUR', 'daman.229302626@muj.manipal.edu', '', '$2y$10$wP/wtiy.5.eeYNYTmnFR.uk0ffHNSmxF0LlWPWaFM4x4oqUdRak86', 'H', '6', '2021', NULL, 0, NULL),
(8481, '229302627', 'RISHITA JAIN', 'rishita.229302627@muj.manipal.edu', '', '$2y$10$OL8n6GE8tWCxKdH8q9NYvu3.oIS1UO5mGmoiNVws75SHcTLBKBBqK', 'H', '6', '2021', NULL, 0, NULL),
(8482, '229302628', 'YASH LABANA', 'yash.229302628@muj.manipal.edu', '', '$2y$10$ftebeLzkACUt/A9ScIxq1O//V9pCARjfaThyms4e/lbIFlaRHztN2', 'H', '6', '2021', NULL, 0, NULL),
(8483, '229302629', 'SIDDHARTH MISHRA', 'siddharth.229302629@muj.manipal.edu', '', '$2y$10$smXGbBJxOl67s3zp6kWHN.7udZhbhdk3MfE1oiW4Wk73.c.nxrMre', 'H', '6', '2021', NULL, 0, NULL),
(8484, '229302630', 'RONAK DHILLON', 'ronak.229302630@muj.manipal.edu', '', '$2y$10$OytHj4YlV2TmHR6Jkccf6.15CgXTA/7Ay.05hT934y45HSRaYBoTi', 'H', '6', '2021', NULL, 0, NULL),
(8485, '229302631', 'TANYA GOYANKA', 'tanya.229302631@muj.manipal.edu', '', '$2y$10$yKYfGcS6yBSgMTN/5HX/F.Ay8Nn9JFDiMG5JUUOwt/Io6zPJGAF2a', 'H', '6', '2021', NULL, 0, NULL),
(8486, '229302633', 'KHUSHANT YADAV', 'khushant.229302633@muj.manipal.edu', '', '$2y$10$CBRDeZMYcBr4V6kKv.Xu1Ofoih3leAGNpEEJA6JzahTOJvplau8bG', 'H', '6', '2021', NULL, 0, NULL),
(8487, '229302635', 'ANUSHKA TIWARY', 'anushka.229302635@muj.manipal.edu', '', '$2y$10$tNJBBXO.FDyn8CHLK0uJ6O6jRl9i3UgC5s.4mgGvTgWUspvYrZ7Ta', 'H', '6', '2021', NULL, 0, NULL),
(8488, '229302636', 'AAYUSH MISHRA', 'aayush.229302636@muj.manipal.edu', '', '$2y$10$6BdRW2V58tQisAZ1GHRsje.Hm7Nc3aIG.J2Ej5j.iD4TQ95ON8fFS', 'H', '6', '2021', NULL, 0, NULL),
(8489, '229302638', 'NAMAN SHARMA', 'naman.229302638@muj.manipal.edu', '', '$2y$10$gA4pXkHf904lpCxifOJcC.xOCQu2o8270QbokZsM0bgKrVu2ynXSS', 'H', '6', '2021', NULL, 0, NULL),
(8490, '229302639', 'G.KEERTHI PRANEETH REDDY', 'geerthi.229302639@muj.manipal.edu', '', '$2y$10$Wmwm.2.VeuLBlmsYREBuCegSqfE3CJINxSHsInIrM7WFTIv3NS4TK', 'H', '6', '2021', NULL, 0, NULL),
(8491, '229302641', 'PANKAJ PATEL', 'pankaj.229302641@muj.manipal.edu', '', '$2y$10$WHnamjXbL4Q3H2nAqgdoOu6CFLoIAov3FMvmI1y1OUW.k4C8YvYHC', 'H', '6', '2021', NULL, 0, NULL),
(8492, '229302642', 'RIYA MATHUR', 'riya.229302642@muj.manipal.edu', '', '$2y$10$7CXiv1CmzqgrJAFajDmrMOcPQLrxKFhsndCiosdQw2Za9ql4yGXIi', 'H', '6', '2021', NULL, 0, NULL),
(8493, '229302646', 'VIGHNESH KIRAN NIKAM', 'vighnesh.229302646@muj.manipal.edu', '', '$2y$10$VruuoONVcXqBysfMwqkB7OffLNTAT7RQsBHZGXoNFbB2lgOst6cbG', 'H', '6', '2021', NULL, 0, NULL),
(8494, '229302647', 'BHAVESH BADHE', 'bhavesh.229302647@muj.manipal.edu', '', '$2y$10$i7kRE1.Ublf9oPQpzujre.gQStR68DTlcKRPvAoBf00oVlO.Qztd2', 'H', '6', '2021', NULL, 0, NULL),
(8495, '229302648', 'SHASHI GUPTA', 'shashi.229302648@muj.manipal.edu', '', '$2y$10$WYkIZOKpM685L1tLW4P.2uCEnx.Fkp.8XHhPsi3CY2ZINrXRRNwCm', 'H', '6', '2021', NULL, 0, NULL),
(8496, '229302650', 'RAKESH SAVALRAM MALI', 'rakesh.229302650@muj.manipal.edu', '', '$2y$10$NB5CnVR1xfZaEOvfJFs9h.0hbDUVgsdailnL9cEQ8EkLEGmGSiEr.', 'H', '6', '2021', NULL, 0, NULL),
(8497, '229303024', 'SHAGUN VERMA', 'shagun.229303024@muj.manipal.edu', '', '$2y$10$IzC/xLpwE.T9y86IMMO9gOWNZpW/J6haltZUaiiZQgBDh42XUV2LO', 'H', '6', '2021', NULL, 0, NULL),
(8498, '229303037', 'NISHCHAY MOHAN', 'nishchay.229303037@muj.manipal.edu', '', '$2y$10$g6447l5QiBxav3Vj80G3OO8hNKxtC591lXoGXga05uLDUUFl3TMbe', 'H', '6', '2021', NULL, 0, NULL),
(8499, '229303041', 'JAYANT SINGH BHOJ', 'jayant.229303041@muj.manipal.edu', '', '$2y$10$9.ItF8PYHaupIX2ZVSgBJeUi9KvTdjxZmwkL9CGQVGWy471c0eQx2', 'H', '6', '2021', NULL, 0, NULL),
(8500, '229303062', 'PARTH AGRAWAL', 'parth.229303062@muj.manipal.edu', '', '$2y$10$yXPviendHGMc5sK0J7SMauL5xjsWph8zu9otOw6vwUthcAITBaxwy', 'H', '6', '2021', NULL, 0, NULL),
(8501, '229303084', 'LIKITH H R', 'likith.229303084@muj.manipal.edu', '', '$2y$10$cH3OUc3tXfSfS0G4.UNaJOWb.suTpzTw1nNyma.U94ptryejiUn0.', 'H', '6', '2021', NULL, 0, NULL),
(8502, '229303096', 'DHAIRYA M BALANI', 'dhairya.229303096@muj.manipal.edu', '', '$2y$10$kvguCe6OupxdqwIQz/txXudyhFx7YawlZ4XeOUIfrcb.sfJQzd5.C', 'H', '6', '2021', NULL, 0, NULL),
(8503, '229303104', 'HIMANSHU RAJ', 'himanshu.229303104@muj.manipal.edu', '', '$2y$10$msVAYc8kLUgTU8/OaGpvg.GU4cV63I/Hd0.1v8haJEWc3T7AawdTu', 'H', '6', '2021', NULL, 0, NULL),
(8504, '229303112', 'ANSH SRIVASTAVA', 'ansh.229303112@muj.manipal.edu', '', '$2y$10$4km6Xko9h/azxHoluamakOSSIoFHefBWCmH/VTSECZlX.EtMlv6Wu', 'H', '6', '2021', NULL, 0, NULL),
(8505, '229303121', 'SHUBHAM GARG', 'shubham.229303121@muj.manipal.edu', '', '$2y$10$JupGdZaGAr4H5ovf0a1ldOrxyJ.rCe/vECN97DJLtsQKixdYnpkVW', 'H', '6', '2021', NULL, 0, NULL),
(8506, '229303138', 'SRISHTI MAHAPATRA', 'srishti.229303138@muj.manipal.edu', '', '$2y$10$DssbjJ6WefFHZGQ3fCM/.Oan/l7Yufz7PF/pJVimQysAGg1PjI2.m', 'H', '6', '2021', NULL, 0, NULL),
(8507, '229303147', 'ATHARVA KALHAPURE', 'atharva.229303147@muj.manipal.edu', '', '$2y$10$/TCIn4GRM88E/aPxy/cjge8UulYWVuwEsTnjegRU8AqrbnI2qAY46', 'H', '6', '2021', NULL, 0, NULL),
(8508, '229303155', 'ANIRUDH BHATNAGAR', 'anirudh.229303155@muj.manipal.edu', '', '$2y$10$TjIfTuDdbUMOzbwcIb8Ja.db6CUyFf83toQGjvbMG6iryQs84X0hu', 'H', '6', '2021', NULL, 0, NULL),
(8509, '229303163', 'ISHAAN SAMAL', 'ishaan.229303163@muj.manipal.edu', '', '$2y$10$2MeC1.y0QMUnYQZnkg8mv.y5SCfXtXXdiYt4Tyu2vAdCtzUtlyeBa', 'H', '6', '2021', NULL, 0, NULL),
(8510, '229303179', 'YASH SHARMA', 'yash.229303179@muj.manipal.edu', '', '$2y$10$9mw.C.T4EiMiE/sxZXnMuOYJsLzPSI8.34GFxTt4zhKln/8ycE3u.', 'H', '6', '2021', NULL, 0, NULL),
(8511, '229303193', 'KOLLAM SUPREET', 'kollam.229303193@muj.manipal.edu', '', '$2y$10$SMo0Is6Qg/mwXYyRmiE76uNKYgx8o1hUWoEAer7haN9ypW/DKg15q', 'H', '6', '2021', NULL, 0, NULL),
(8512, '229303195', 'TANU TRIPATHI', 'tanu.229303195@muj.manipal.edu', '', '$2y$10$bTaMw5/Ga8QUdntY1UcfpOU.BjIakshSr2.9tPdty.Wj3pBqEKp/y', 'H', '6', '2021', NULL, 0, NULL),
(8513, '229303197', 'ADITHAM ROHIT RAO', 'aditham.229303197@muj.manipal.edu', '', '$2y$10$J1qpbbKs9Qdd.QDmG129SefPymiP/fL7aC6AU.WFoz5wyMJjedoye', 'H', '6', '2021', NULL, 0, NULL),
(8514, '229303207', 'RITIK LAXWANI', 'ritik.229303207@muj.manipal.edu', '', '$2y$10$Dh0njvPbqDHSKGh3PGYEbOG3YasJzymal/OQZNTB0.8K.1Qg5w5y.', 'H', '6', '2021', NULL, 0, NULL),
(8515, '229303216', 'TANUJ SHARMA', 'tanuj.229303216@muj.manipal.edu', '', '$2y$10$It8eGLxJ/U0a58RfbFB6/OtScoJbbnNZhNOFjix9Ie..AGzw.5K0q', 'H', '6', '2021', NULL, 0, NULL),
(8516, '229303218', 'NALIN DATTA', 'nalin.229303218@muj.manipal.edu', '', '$2y$10$5C5pcE10dNNDNdRaWWba1uzBagf.bRfKQCKWtDSxzwwK02bh.7A5O', 'H', '6', '2021', NULL, 0, NULL),
(8517, '229303223', 'BHAVYA METHI', 'bhavya.229303223@muj.manipal.edu', '', '$2y$10$OsETf9RNSFwXHngMzrsczOiRQOkHsNMgUB0k5UgoAm6WKy4IqlhU6', 'H', '6', '2021', NULL, 0, NULL),
(8518, '229303226', 'MANNAT VIJ', 'mannat.229303226@muj.manipal.edu', '', '$2y$10$698TRLN4787X5.v.e4EFn.qQBlDEZbEV5F4wiomy6M4CLpBaMHDv2', 'H', '6', '2021', NULL, 0, NULL),
(8519, '229303246', 'ARAMBH SINGH RAJPUT', 'arambh.229303246@muj.manipal.edu', '', '$2y$10$FrPgAnkLXV845StBaVcvRekFIK6mG2lpkVAYc.dFGbgPnrN767xqO', 'H', '6', '2021', NULL, 0, NULL),
(8520, '229303255', 'GAUTAM KUMAR YADAV', 'gautam.229303255@muj.manipal.edu', '', '$2y$10$UMk0OALTcVBjwIdO/GXigeZs4ij6Jgi6GgDGVByo0WmpEWzFe5xZ.', 'H', '6', '2021', NULL, 0, NULL),
(8521, '229303258', 'TANISHA', 'tanisha.229303258@muj.manipal.edu', '', '$2y$10$Qm2w4B.zWsXktFvRplzvaeryIS7XHk/iTB55OZIwEJSR8FBBgNj0C', 'H', '6', '2021', NULL, 0, NULL),
(8522, '229303261', 'SATVIK SHUKLA', 'satvik.229303261@muj.manipal.edu', '', '$2y$10$ZnUS5xeXtqq3Z8iFngNPcOmJ811N1TGrXn1rCO4ICa.S9rA30f7Dm', 'H', '6', '2021', NULL, 0, NULL),
(8523, '229303281', 'VAIBHAV SHARMA', 'vaibhav.229303281@muj.manipal.edu', '', '$2y$10$vj/uDI4UfescvEVFZSzKq.tIXf0e2iDg59HtPIIs2cvCpkIqKAy/6', 'H', '6', '2021', NULL, 0, NULL),
(8524, '229303296', 'HIMESH REDDY MADIREDDY', 'himesh.229303296@muj.manipal.edu', '', '$2y$10$lO.gIkrM10sSi.bj1pgteuZNBrpSMhhIruJuXyBjHEd3kyhEXHOEK', 'H', '6', '2021', NULL, 0, NULL),
(8525, '229303298', 'AMAN SHARMA', 'aman.229303298@muj.manipal.edu', '', '$2y$10$f761T0O8weUIcibeAj81F.kRbhcs.SlBdgXMrfPAVZCUv55vkYfre', 'H', '6', '2021', NULL, 0, NULL),
(8526, '229303302', 'MANAN MISHRA', 'manan.229303302@muj.manipal.edu', '', '$2y$10$EsFmYNZKyW4JxEk2VA49kOjbS./lIVTnJsRoGXQabs.gQXWb3ckvK', 'H', '6', '2021', NULL, 0, NULL),
(8527, '229303306', 'MANISH CHAUDHARY', 'manish.229303306@muj.manipal.edu', '', '$2y$10$Ls/Vw3TfyUz175QUwcTC3.1xcjnSVvPC02eksXJLRNkvrPC6pAYYO', 'H', '6', '2021', NULL, 0, NULL),
(8528, '229303319', 'HARSH PRAKASH KUSHWAHA', 'harsh.229303319@muj.manipal.edu', '', '$2y$10$L9kgq7Tz6Xo4lxrCXmDm4.QcfHOuJdtqZ0XaEuUqKgUMRAg7FV5J2', 'H', '6', '2021', NULL, 0, NULL),
(8529, '229303323', 'YASH TALREJA', 'yash.229303323@muj.manipal.edu', '', '$2y$10$Zx6pFq7EcGjzriaULZAPXeR9LfZjOgXF2LEOKyL0cjBGKkMMNVNTa', 'H', '6', '2021', NULL, 0, NULL),
(8530, '229303324', 'DHAWAL VERMA', 'dhawal.229303324@muj.manipal.edu', '', '$2y$10$lcq0rCUFTaHa4dmEjWutiO5aMHqN9hCrjb.2iHJTQM5ZcWWqLzxvC', 'H', '6', '2021', NULL, 0, NULL),
(8531, '229303347', 'ANIKET MISHRA', 'aniket.229303347@muj.manipal.edu', '', '$2y$10$bHTkLJJfdmuL9TYcvsquv.6C/CiV5kkfpMm.AKcuF6ETuIW0DpMfa', 'H', '6', '2021', NULL, 0, NULL),
(8532, '229303446', 'SAMEER PRATAP SINGH', 'sameer.229303446@muj.manipal.edu', '', '$2y$10$PjiRRu2cjDpLrEQUCdoEe.STubHuYFuniMifv3fLUUDESWBygvar2', 'H', '6', '2021', NULL, 0, NULL),
(8533, '229309035', 'KRISHANG GOEL', 'krishang.229309035@muj.manipal.edu', '', '$2y$10$D/wm4uMW3sD75nFQRRoC5eBxAueLg6bys18SJNe29LIcR1B1S.rcq', 'H', '6', '2021', NULL, 0, NULL),
(8534, '229309099', 'JOE CHERIAN DOMINIC', 'joe.229309099@muj.manipal.edu', '', '$2y$10$KwYNZtgwTF7D6CZW0jQ1auiWUSjzsS.VNgwQylVKCTuDLkGujM0b2', 'H', '6', '2021', NULL, 0, NULL),
(8535, '229309147', 'SHRUTI RUPESH SUNTHWAL', 'shruti.229309147@muj.manipal.edu', '', '$2y$10$fBR6PapQWd9qJMrA.7ByYOa19PELiQD2zXfv25g8PAg1h3t9nxwG2', 'H', '6', '2021', NULL, 0, NULL),
(8536, '229309158', 'YASH KAMRA', 'yash.229309158@muj.manipal.edu', '', '$2y$10$u4FQDfO5vKBSha29OieWq.hcM7aA6JPwt8iwsHQ6Qn7mp3tQyGZY6', 'H', '6', '2021', NULL, 0, NULL),
(8537, '229309169', 'HIMANSHU SHARMA', 'himanshu.229309169@muj.manipal.edu', '', '$2y$10$5RUjmV4kNGn4gwNre4OcI.Uogl.YBWyQKWOuHX.pisntd9o.IO/h2', 'H', '6', '2021', NULL, 0, NULL),
(8538, '229309188', 'BHAVESH CHOUDHARY', 'bhavesh.229309188@muj.manipal.edu', '', '$2y$10$aKFsOLwCa8GZOfS.i8Jk7.JSU8UfadTv0COSlojuH25wSBx1kGsmO', 'H', '6', '2021', NULL, 0, NULL),
(8539, '229309253', 'RIDHIMA PODDAR', 'ridhima.229309253@muj.manipal.edu', '', '$2y$10$HdcAf0EB.0hLAeLiO4YVVO3G2dh.kDrdYXaJJI1xQSQr2Ho9kJ/ia', 'H', '6', '2021', NULL, 0, NULL),
(8540, '229309258', 'ABHIRAJ ANAND', 'abhiraj.229309258@muj.manipal.edu', '', '$2y$10$yqeyoeKmmDtvUBV7LCbb9ua0AdW9MLRoV3z8GLCUnvwJrRsMAmTTe', 'H', '6', '2021', NULL, 0, NULL),
(8541, '229311236', 'AROHI SINGH', 'arohi.229311236@muj.manipal.edu', '', '$2y$10$IuX0HUo/Cf3jWG29xeyGTeijr5CkdyMwKoPh7uB7uCBXvkHsfyvn.', 'H', '6', '2021', NULL, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_project_mark`
--
ALTER TABLE `add_project_mark`
  ADD PRIMARY KEY (`student_enrollment`,`project_id`);

--
-- Indexes for table `adminlogin`
--
ALTER TABLE `adminlogin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`id`);

--
-- Indexes for table `admin_add_contain`
--
ALTER TABLE `admin_add_contain`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `allocated_project`
--
ALTER TABLE `allocated_project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `circular_notices`
--
ALTER TABLE `circular_notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`sr_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminlogin`
--
ALTER TABLE `adminlogin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `admin_add_contain`
--
ALTER TABLE `admin_add_contain`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `allocated_project`
--
ALTER TABLE `allocated_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14029;

--
-- AUTO_INCREMENT for table `circular_notices`
--
ALTER TABLE `circular_notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1138;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16628;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8542;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
