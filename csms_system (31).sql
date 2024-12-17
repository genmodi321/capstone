-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2024 at 05:51 AM
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
-- Database: `csms_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('quiz','activity','project','exam') NOT NULL,
  `message` text DEFAULT NULL,
  `due_date` date NOT NULL,
  `due_time` text NOT NULL,
  `min_points` int(11) NOT NULL,
  `max_points` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `term` enum('midterm','final','other') DEFAULT 'other'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `title`, `type`, `message`, `due_date`, `due_time`, `min_points`, `max_points`, `class_id`, `subject_id`, `created_at`, `updated_at`, `term`) VALUES
(22, 'Quiz 1 ', 'quiz', 'Test', '2024-12-10', '12:00AM', 25, 50, 64, 43, '2024-12-09 20:58:20', '2024-12-09 20:58:20', 'midterm'),
(23, 'Major Exam 1', 'exam', 'Test', '2024-12-31', '01:30PM', 25, 50, 64, 43, '2024-12-09 21:33:02', '2024-12-09 21:33:02', 'midterm'),
(24, 'Quiz 2', 'quiz', 'Quiz 2', '2024-12-10', '12:35PM', 25, 50, 64, 43, '2024-12-09 21:33:30', '2024-12-09 21:33:30', 'midterm'),
(25, 'Quiz 3', 'quiz', 'Quiz 3', '2024-12-10', '01:30PM', 25, 50, 64, 43, '2024-12-09 21:33:49', '2024-12-09 21:33:49', 'midterm'),
(26, 'Act 1', 'activity', 'test', '2024-12-10', '12:40PM', 12, 55, 64, 43, '2024-12-09 21:34:17', '2024-12-09 21:34:17', 'midterm'),
(27, 'Create an Iot software engineering module', 'project', 'Example', '2024-12-10', '06:34PM', 25, 55, 64, 43, '2024-12-09 21:35:00', '2024-12-09 21:35:00', 'midterm'),
(28, 'Quiz 4', 'quiz', 'Test', '2024-12-10', '02:55PM', 0, 20, 64, 43, '2024-12-09 22:07:30', '2024-12-09 22:07:30', 'final'),
(29, 'Quiz 5', 'quiz', 'Test', '2024-12-10', '01:08PM', 5, 10, 64, 43, '2024-12-09 22:07:51', '2024-12-09 22:07:51', 'final'),
(30, 'Quiz 6', 'quiz', 'test', '2024-12-12', '01:17PM', 12, 50, 64, 43, '2024-12-09 22:14:53', '2024-12-09 22:14:53', 'final'),
(31, 'Test', 'activity', 'test', '2024-12-10', '06:15PM', 25, 55, 64, 43, '2024-12-09 22:15:15', '2024-12-10 05:17:38', 'final'),
(32, 'Build a glass', 'activity', 'Build a glass', '2024-12-10', '01:18PM', 10, 50, 64, 43, '2024-12-09 22:15:40', '2024-12-09 22:15:40', 'final'),
(33, 'Build a laptop', 'project', 'Laptop!', '2024-12-10', '01:17PM', 25, 55, 64, 43, '2024-12-09 22:16:00', '2024-12-09 22:16:00', 'final'),
(34, 'Major Exam #2', 'exam', 'Final', '2024-12-10', '02:20PM', 70, 100, 64, 43, '2024-12-09 22:16:21', '2024-12-09 22:16:21', 'final'),
(35, 'HAHAHHA', 'activity', 'test', '2024-12-11', '07:52PM', 25, 50, 64, 43, '2024-12-11 04:47:43', '2024-12-11 04:47:43', 'midterm'),
(37, 'Act 1', 'activity', 'test', '2024-12-12', '05:43PM', 25, 25, 80, 44, '2024-12-12 02:37:35', '2024-12-12 02:37:35', 'midterm'),
(38, 'Act 2', 'activity', 'test', '2024-12-12', '05:40PM', 2, 55, 80, 44, '2024-12-12 02:37:52', '2024-12-12 02:37:52', 'final'),
(39, 'Midterms Exam', 'exam', 'test', '2024-12-26', '05:44PM', 25, 55, 80, 44, '2024-12-12 02:38:14', '2024-12-12 02:38:14', 'midterm'),
(40, 'hehe', 'exam', 'exam', '2024-12-17', '02:55PM', 25, 55, 80, 44, '2024-12-12 02:38:45', '2024-12-12 02:38:45', 'final'),
(41, 'Test 1', 'project', 'test', '2024-12-12', '06:04PM', 25, 50, 80, 44, '2024-12-12 03:04:47', '2024-12-12 03:04:47', 'midterm');

-- --------------------------------------------------------

--
-- Table structure for table `activity_attachments`
--

CREATE TABLE `activity_attachments` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `activity_attachments`
--

INSERT INTO `activity_attachments` (`id`, `activity_id`, `file_name`, `file_path`, `uploaded_at`) VALUES
(12, 26, 'Capstone 2 - FINAL DOCUMENTATION (Updated).pdf', '../../../../uploads/files/6757c4c9654fe-Capstone 2 - FINAL DOCUMENTATION (Updated).pdf', '2024-12-10 05:34:17'),
(13, 28, 'IT140_CapstoneProjectAndResearch2_FINAL_DOCUMENTATION-updated file.pdf', '../../../../uploads/files/6757cc93012e0-IT140_CapstoneProjectAndResearch2_FINAL_DOCUMENTATION-updated file.pdf', '2024-12-10 06:07:30'),
(14, 29, '70c38235368af2a05f64687638fd755e.jpg', '../../../../uploads/files/6757cca76dbf9-70c38235368af2a05f64687638fd755e.jpg', '2024-12-10 06:07:51'),
(15, 31, 'vawc (1).docx', '../../../../uploads/files/6757ce639e1d2-vawc (1).docx', '2024-12-10 06:15:15'),
(16, 32, 'f1317e02-f3f9-4bd7-a599-12374e96e15c.jpg', '../../../../uploads/files/6757ce7ca0f27-f1317e02-f3f9-4bd7-a599-12374e96e15c.jpg', '2024-12-10 06:15:40'),
(17, 33, 'csms_system (20).sql', '../../../../uploads/files/6757ce90ea444-csms_system (20).sql', '2024-12-10 06:16:00'),
(18, 35, 'sample_students_data.xlsx', '../../../../uploads/files/67597bdfa65ff-sample_students_data.xlsx', '2024-12-11 12:47:43'),
(19, 37, 'CERTIFICATE.pdf', '../../../../uploads/files/675aaedfbcd9b-CERTIFICATE.pdf', '2024-12-12 10:37:35'),
(20, 38, 'f1317e02-f3f9-4bd7-a599-12374e96e15c.jpg', '../../../../uploads/files/675aaef011019-f1317e02-f3f9-4bd7-a599-12374e96e15c.jpg', '2024-12-12 10:37:52'),
(21, 39, 'f1317e02-f3f9-4bd7-a599-12374e96e15c.jpg', '../../../../uploads/files/675aaf069772e-f1317e02-f3f9-4bd7-a599-12374e96e15c.jpg', '2024-12-12 10:38:14'),
(22, 40, 'vawc (1).docx', '../../../../uploads/files/675aaf2536f31-vawc (1).docx', '2024-12-12 10:38:45'),
(23, 41, 'HEADER (1).docx', '../../../../uploads/files/675ab53f33672-HEADER (1).docx', '2024-12-12 11:04:47');

-- --------------------------------------------------------

--
-- Table structure for table `activity_submissions`
--

CREATE TABLE `activity_submissions` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `submission_date` datetime DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT 0,
  `feedback` text DEFAULT NULL,
  `status` enum('pending','submitted','graded') DEFAULT 'pending',
  `file_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_submissions`
--

INSERT INTO `activity_submissions` (`id`, `activity_id`, `student_id`, `submission_date`, `score`, `feedback`, `status`, `file_path`) VALUES
(81, 26, 12345679, NULL, 0, NULL, 'pending', NULL),
(82, 32, 12345679, NULL, 0, NULL, 'pending', NULL),
(83, 33, 12345679, NULL, 2, NULL, 'pending', NULL),
(84, 27, 12345679, NULL, 0, NULL, 'pending', NULL),
(85, 35, 12345679, NULL, 0, NULL, 'pending', NULL),
(86, 34, 12345679, NULL, 0, NULL, 'pending', NULL),
(87, 23, 12345679, NULL, 0, NULL, 'pending', NULL),
(88, 22, 12345679, '2024-12-13 06:08:16', 0, NULL, 'submitted', 'submission_675bc140d56c35.63602041_tumblr_28ad0ec9de393cfba06646a45c7ce7ba_8565602b_500.jpg'),
(89, 24, 12345679, NULL, 0, NULL, 'pending', NULL),
(90, 25, 12345679, NULL, 0, NULL, 'pending', NULL),
(91, 28, 12345679, NULL, 2, NULL, 'pending', NULL),
(92, 29, 12345679, NULL, 2, NULL, 'pending', NULL),
(93, 30, 12345679, NULL, 0, NULL, 'pending', NULL),
(94, 31, 12345679, NULL, 0, NULL, 'pending', NULL),
(123, 26, 12345677, NULL, 0, NULL, 'pending', NULL),
(124, 32, 12345677, NULL, 0, NULL, 'pending', NULL),
(125, 33, 12345677, NULL, 5, NULL, 'pending', NULL),
(126, 27, 12345677, NULL, 0, NULL, 'pending', NULL),
(127, 35, 12345677, NULL, 0, NULL, 'pending', NULL),
(128, 34, 12345677, NULL, 0, NULL, 'pending', NULL),
(129, 23, 12345677, NULL, 0, NULL, 'pending', NULL),
(130, 22, 12345677, NULL, 0, NULL, 'pending', NULL),
(131, 24, 12345677, NULL, 0, NULL, 'pending', NULL),
(132, 25, 12345677, NULL, 0, NULL, 'pending', NULL),
(133, 28, 12345677, NULL, 0, NULL, 'pending', NULL),
(134, 29, 12345677, NULL, 0, NULL, 'pending', NULL),
(135, 30, 12345677, NULL, 0, NULL, 'pending', NULL),
(136, 31, 12345677, NULL, 0, NULL, 'pending', NULL),
(137, 26, 12345677, NULL, 0, NULL, 'pending', NULL),
(138, 32, 12345677, NULL, 0, NULL, 'pending', NULL),
(139, 33, 12345677, NULL, 0, NULL, 'pending', NULL),
(140, 27, 12345677, NULL, 0, NULL, 'pending', NULL),
(141, 35, 12345677, NULL, 0, NULL, 'pending', NULL),
(142, 34, 12345677, NULL, 0, NULL, 'pending', NULL),
(143, 23, 12345677, NULL, 0, NULL, 'pending', NULL),
(145, 24, 12345677, NULL, 0, NULL, 'pending', NULL),
(146, 25, 12345677, NULL, 0, NULL, 'pending', NULL),
(147, 28, 12345677, NULL, 0, NULL, 'pending', NULL),
(148, 29, 12345677, NULL, 0, NULL, 'pending', NULL),
(149, 30, 12345677, NULL, 0, NULL, 'pending', NULL),
(150, 31, 12345677, NULL, 0, NULL, 'pending', NULL),
(170, 41, 12345677, NULL, 0, NULL, 'pending', NULL),
(171, 26, 12345677, NULL, 0, NULL, 'pending', NULL),
(172, 37, 12345677, NULL, 0, NULL, 'pending', NULL),
(173, 38, 12345677, NULL, 0, NULL, 'pending', NULL),
(174, 32, 12345677, NULL, 0, NULL, 'pending', NULL),
(175, 33, 12345677, NULL, 0, NULL, 'pending', NULL),
(176, 27, 12345677, NULL, 0, NULL, 'pending', NULL),
(177, 35, 12345677, NULL, 0, NULL, 'pending', NULL),
(178, 40, 12345677, NULL, 0, NULL, 'pending', NULL),
(179, 34, 12345677, NULL, 0, NULL, 'pending', NULL),
(180, 23, 12345677, NULL, 0, NULL, 'pending', NULL),
(181, 39, 12345677, NULL, 0, NULL, 'pending', NULL),
(182, 22, 12345677, NULL, 0, NULL, 'pending', NULL),
(183, 24, 12345677, NULL, 0, NULL, 'pending', NULL),
(184, 25, 12345677, NULL, 0, NULL, 'pending', NULL),
(185, 28, 12345677, NULL, 0, NULL, 'pending', NULL),
(186, 29, 12345677, NULL, 0, NULL, 'pending', NULL),
(187, 30, 12345677, NULL, 0, NULL, 'pending', NULL),
(188, 31, 12345677, NULL, 0, NULL, 'pending', NULL),
(189, 41, 12345677, NULL, 0, NULL, 'pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `date_created` date DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `phone_number` varchar(255) NOT NULL,
  `gender` text NOT NULL,
  `role` text NOT NULL DEFAULT 'Admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `first_name`, `middle_name`, `last_name`, `date_created`, `last_login`, `phone_number`, `gender`, `role`) VALUES
(11, 'admin_ccs', 'admin_ccs@wmsu.com', '$2y$10$wpEG6wnmQVbA2OTEFlCOJOMRuoFSq2kW4yzoR7FrIxF9UwNqg1oqG', 'Lucas', 'Alexander', 'Mitchell', '2024-09-22', '2024-12-14 06:52:12', '+639123456789', 'Male', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `admin_auto_notifications`
--

CREATE TABLE `admin_auto_notifications` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin_auto_notifications`
--

INSERT INTO `admin_auto_notifications` (`id`, `name`, `status`) VALUES
(1, 'semester_transition', 'false'),
(2, 'semester_ending_notice', 'true'),
(3, 'semester_near_ending', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notes`
--

CREATE TABLE `admin_notes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `datetime_created` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` int(11) NOT NULL,
  `type` enum('teacher','student','class','subject','semester','account') NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `link` text NOT NULL,
  `status` enum('read','unread') NOT NULL DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin_notifications`
--

INSERT INTO `admin_notifications` (`id`, `type`, `title`, `description`, `date`, `link`, `status`) VALUES
(49, 'teacher', 'New Staff Account Registration', 'A new staff account has been registered successfully.', '2024-12-14 02:13:31', 'teacher_management.php', 'read'),
(50, 'teacher', 'New Class Additon with Teacher', 'A new class to be taught has been added by .John Doe', '2024-12-14 02:20:11', 'teacher_management.php', 'read'),
(51, 'teacher', 'New Class Addition', 'A new class to be taught has been added by John Doe', '2024-12-14 02:20:33', 'teacher_management.php', 'read'),
(52, 'teacher', 'New Class Addition', 'A new class to be taught has been added by John Doe', '2024-12-14 02:21:57', 'teacher_management.php', 'read');

-- --------------------------------------------------------

--
-- Table structure for table `admin_reminders`
--

CREATE TABLE `admin_reminders` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `level` text NOT NULL,
  `due_date` text NOT NULL,
  `due_time` text NOT NULL,
  `datetime_created` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archived_semesters`
--

CREATE TABLE `archived_semesters` (
  `id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `archive_reason` text NOT NULL,
  `archived_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `archived_semesters`
--

INSERT INTO `archived_semesters` (`id`, `semester_id`, `archive_reason`, `archived_at`) VALUES
(2, 18, 'WOWAOWOAWODA', '2024-12-07 02:37:10');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `status` enum('present','late','absent') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `date` date NOT NULL,
  `ip_address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `class_id`, `meeting_id`, `status`, `timestamp`, `date`, `ip_address`) VALUES
(65, 12345679, 64, 42, 'present', '2024-12-12 06:34:23', '2024-12-12', ''),
(66, 12345679, 64, 43, 'present', '2024-12-12 06:34:23', '2024-12-12', ''),
(71, 12345677, 64, 42, 'absent', '2024-12-12 06:51:01', '2024-12-12', ''),
(72, 12345677, 64, 43, 'absent', '2024-12-12 06:51:01', '2024-12-12', ''),
(74, 12345677, 80, 46, 'absent', '2024-12-13 13:37:08', '2024-12-13', '');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` text DEFAULT NULL,
  `subject` text NOT NULL,
  `subject_id` int(11) NOT NULL,
  `code` text DEFAULT NULL,
  `teacher` text NOT NULL,
  `semester` text NOT NULL,
  `studentTotal` int(11) NOT NULL,
  `description` text NOT NULL,
  `classCode` text DEFAULT NULL,
  `requestor` text DEFAULT NULL,
  `status` text NOT NULL,
  `reason` text DEFAULT NULL,
  `datetime_added` datetime NOT NULL DEFAULT current_timestamp(),
  `is_archived` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`, `type`, `subject`, `subject_id`, `code`, `teacher`, `semester`, `studentTotal`, `description`, `classCode`, `requestor`, `status`, `reason`, `datetime_added`, `is_archived`) VALUES
(64, 'BSIT-1A', 'Lecture', 'Software Engineerings', 43, 'IT - 141', 'John Doe', '1st Semester', 0, 'haha', '4OZJ86', NULL, 'Ongoing', NULL, '2024-10-29 23:02:19', 0),
(75, 'BSIT-1A', 'Lecture', 'Introduction to Computing', 44, 'IT - 141', 'John Doe', '1st Semester', 0, 'hehe', 'ITN8J8', 'John Doe', 'accepted', NULL, '2024-12-07 16:53:29', 0),
(80, 'BSIT-1A', 'Laboratory', 'Introduction to Computing', 44, 'IT - 141', 'John Doe', '1st Semester', 0, 'test', 'Q096XO', NULL, 'accepted', NULL, '2024-12-09 11:01:22', 0),
(84, 'BSIT-4A', 'Lecture', 'Capstone Project and Research 1', 47, 'IT 145', 'Ahmad Pandaog Aquino', '1st Semester', 0, 'test', 'KW69PB', NULL, 'accepted', NULL, '2024-12-14 06:55:23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `classes_meetings`
--

CREATE TABLE `classes_meetings` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `class_id` int(11) NOT NULL,
  `status` text NOT NULL,
  `start_time` text NOT NULL,
  `end_time` text NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `classes_meetings`
--

INSERT INTO `classes_meetings` (`id`, `date`, `class_id`, `status`, `start_time`, `end_time`, `type`) VALUES
(42, '2024-12-08', 64, 'Finished', '1:13 AM', '1:55 AM', 'Regular'),
(43, '2024-12-08', 64, 'Finished', '1:13 AM', '1:55 AM', 'Regular'),
(46, '2024-12-12', 80, 'Ongoing', '5:27 AM', '5:28 PM', 'Regular'),
(47, '2024-12-13', 64, 'Ongoing', '12:42 PM', '5:55 PM', 'Regular'),
(48, '2024-12-14', 64, 'Scheduled', '12:42 PM', '5:55 PM', 'Regular');

-- --------------------------------------------------------

--
-- Table structure for table `class_students`
--

CREATE TABLE `class_students` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `enrollment_date` datetime DEFAULT current_timestamp(),
  `status` enum('active','completed','dropped','withdrawn') DEFAULT 'active',
  `grade` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `current_semester`
--

CREATE TABLE `current_semester` (
  `id` int(11) NOT NULL,
  `semester` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `current_semester`
--

INSERT INTO `current_semester` (`id`, `semester`) VALUES
(38, '1st Semester');

-- --------------------------------------------------------

--
-- Table structure for table `laboratory_rubrics`
--

CREATE TABLE `laboratory_rubrics` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `major_exam` float NOT NULL,
  `laboratory_exercises` float NOT NULL,
  `assignments` float NOT NULL,
  `attendance` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laboratory_rubrics`
--

INSERT INTO `laboratory_rubrics` (`id`, `class_id`, `major_exam`, `laboratory_exercises`, `assignments`, `attendance`, `created_at`, `updated_at`) VALUES
(1, 0, 20, 20, 20, 20, '2024-12-13 14:07:50', '2024-12-13 14:07:58'),
(2, 80, 25, 25, 25, 25, '2024-12-13 14:09:07', '2024-12-13 14:09:07');

-- --------------------------------------------------------

--
-- Table structure for table `learning_resources`
--

CREATE TABLE `learning_resources` (
  `resource_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `resource_name` varchar(255) NOT NULL,
  `resource_type` text NOT NULL,
  `resource_description` text DEFAULT NULL,
  `resource_url` varchar(500) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `learning_resources`
--

INSERT INTO `learning_resources` (`resource_id`, `class_id`, `subject_id`, `resource_name`, `resource_type`, `resource_description`, `resource_url`, `uploaded_at`) VALUES
(5, 64, 43, 'Test', 'document', 'test', 'CERTIFICATE.pdf', '2024-12-06 02:52:09'),
(6, 64, 43, 'hey', 'document', 'hey', 'tumblr_28ad0ec9de393cfba06646a45c7ce7ba_8565602b_500.jpg', '2024-12-13 06:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `lectures`
--

CREATE TABLE `lectures` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `type` enum('jpg','jpeg','png','pdf','docx','xlsx','mp4','mpeg') NOT NULL,
  `file` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lecture_rubrics`
--

CREATE TABLE `lecture_rubrics` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `major_exam` decimal(5,2) NOT NULL,
  `quizzes` decimal(5,2) NOT NULL,
  `activities` decimal(5,2) NOT NULL,
  `attendance` decimal(5,2) NOT NULL,
  `projects` decimal(5,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_type` enum('admin','student','staff') NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `receiver_type` enum('admin','student','staff') NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `sender_name` varchar(255) NOT NULL,
  `receiver_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `sender_type`, `receiver_id`, `receiver_type`, `message`, `timestamp`, `sender_name`, `receiver_name`) VALUES
(488, 11, 'admin', 29, 'staff', 'hey', '2024-12-13 11:14:59', 'Lucas Mitchell', 'John Doe'),
(489, 29, 'staff', 11, 'admin', 'hey', '2024-12-13 11:15:03', 'John Doe', 'Lucas Mitchell'),
(490, 29, 'staff', 11, 'admin', 'hey', '2024-12-13 11:18:27', 'John Doe', 'Lucas Mitchell'),
(491, 11, 'admin', 29, 'staff', 'hey', '2024-12-13 11:18:53', 'Lucas Mitchell', 'John Doe'),
(492, 29, 'staff', 11, 'admin', 'yoo', '2024-12-13 11:18:58', 'John Doe', 'Lucas Mitchell'),
(493, 29, 'staff', 11, 'admin', 'hehe', '2024-12-13 11:19:00', 'John Doe', 'Lucas Mitchell'),
(494, 29, 'staff', 11, 'admin', 'musta', '2024-12-13 11:19:02', 'John Doe', 'Lucas Mitchell'),
(495, 202001523, 'student', 103, 'student', 'hey', '2024-12-13 12:33:05', 'Leonardo da Vinci Aquino', 'Fatima Fitra'),
(496, 202001523, 'student', 29, 'staff', 'hey', '2024-12-13 12:33:23', 'Leonardo da Vinci Aquino', 'John Doe'),
(497, 29, 'staff', 202001523, 'student', 'hry', '2024-12-13 12:33:29', 'John Doe', 'Leonardo da Vinci Aquino'),
(498, 29, 'staff', 202001523, 'student', 'hey', '2024-12-13 12:33:30', 'John Doe', 'Leonardo da Vinci Aquino'),
(499, 11, 'admin', 29, 'staff', 'test', '2024-12-13 14:30:13', 'Lucas Mitchell', 'John Doe'),
(500, 29, 'staff', 11, 'admin', 'hey', '2024-12-13 14:30:43', 'John Doe', 'Lucas Mitchell'),
(501, 11, 'admin', 29, 'staff', 'This is from the admin', '2024-12-13 14:30:56', 'Lucas Mitchell', 'John Doe'),
(502, 29, 'staff', 11, 'admin', 'This is from the teacher', '2024-12-13 14:31:04', 'John Doe', 'Lucas Mitchell'),
(503, 11, 'admin', 29, 'staff', 'Hello leo', '2024-12-13 14:34:02', 'Lucas Mitchell', 'John Doe'),
(504, 29, 'staff', 11, 'admin', 'hello developer naming mabagal masyado', '2024-12-13 14:34:18', 'John Doe', 'Lucas Mitchell'),
(505, 29, 'staff', 202001523, 'student', 'hey', '2024-12-13 14:42:31', 'John Doe', 'Leonardo da Vinci Aquino'),
(506, 29, 'staff', 202001523, 'student', 'ito si leo diba', '2024-12-13 14:42:35', 'John Doe', 'Leonardo da Vinci Aquino'),
(507, 202001523, 'student', 29, 'staff', 'uy', '2024-12-13 14:42:58', 'Leonardo da Vinci Aquino', 'John Doe'),
(508, 202001523, 'student', 29, 'staff', 'hello po sir', '2024-12-13 14:43:01', 'Leonardo da Vinci Aquino', 'John Doe'),
(509, 202001523, 'student', 29, 'staff', 'ahsdadhas', '2024-12-13 15:36:10', 'Leonardo da Vinci Aquino', 'John Doe'),
(510, 29, 'staff', 202001523, 'student', 'hey', '2024-12-13 15:36:36', 'John Doe', 'Leonardo da Vinci Aquino'),
(511, 29, 'staff', 202001523, 'student', 'hello student', '2024-12-13 15:36:46', 'John Doe', 'Leonardo da Vinci Aquino'),
(512, 11, 'admin', 4, 'student', 'hi', '2024-12-13 15:46:54', 'Lucas Mitchell', 'Nifled Sespene'),
(513, 202001523, 'student', 11, 'admin', 'hi', '2024-12-13 15:47:19', 'Leonardo da Vinci Aquino', 'Lucas Mitchell'),
(514, 11, 'admin', 202001523, 'student', 'hi', '2024-12-13 15:47:50', 'Lucas Mitchell', 'Leonardo da Vinci Aquino'),
(515, 29, 'staff', 202001523, 'student', 'yooo', '2024-12-13 16:04:27', 'John Doe', 'Leonardo da Vinci Aquino'),
(516, 12345679, 'student', 29, 'staff', 'hey', '2024-12-13 16:04:43', 'Nifled Sespene', 'John Doe'),
(517, 29, 'staff', 12345679, 'student', 'heyy', '2024-12-13 16:04:53', 'John Doe', 'Nifled Sespene');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive','archived') DEFAULT 'inactive',
  `archived` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id`, `name`, `start_date`, `end_date`, `description`, `status`, `archived`, `created_at`, `updated_at`) VALUES
(18, '1st Semester', '2024-10-25', '2025-02-01', '1st semester test', 'archived', 1, '2024-10-25 13:36:11', '2024-12-07 09:37:10'),
(20, '2nd Semester', '2024-12-07', '2024-12-14', '2nd semester test', 'active', 0, '2024-12-07 08:38:34', '2024-12-07 09:32:57');

-- --------------------------------------------------------

--
-- Table structure for table `staff_accounts`
--

CREATE TABLE `staff_accounts` (
  `id` int(11) NOT NULL,
  `fullName` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `department` text DEFAULT NULL,
  `class` text DEFAULT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  `phone_number` text DEFAULT NULL,
  `gender` text NOT NULL,
  `datetime_added` datetime NOT NULL DEFAULT current_timestamp(),
  `role` text NOT NULL DEFAULT 'Staff',
  `status` text NOT NULL DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `staff_accounts`
--

INSERT INTO `staff_accounts` (`id`, `fullName`, `email`, `password`, `department`, `class`, `date_created`, `phone_number`, `gender`, `datetime_added`, `role`, `status`) VALUES
(29, 'John Doe', 'johndoe@gmail.com', '$2y$10$lMNvfYPMBmCiV7EMhhqoOe.bwfe47WwM78KNTZfp3rDjLhC.pIhXG', 'Department of Information Technology', 'BSIT-1A', '2024-11-30', '+639129452915', 'Male', '2024-11-30 10:18:11', 'Staff', 'inactive'),
(33, 'test', 'test@yahoes.com', '$2y$10$CXlrPpgDXC1OdmEw/wWmiOZkDJDneA9hjXQtJqdCpI7BMGjcrbV9W', 'Department of Information Technology', 'BSIT-1A', '2024-11-30', '9129452915', 'Male', '2024-11-30 10:48:30', 'Staff', 'inactive'),
(34, 'Ahmad Pandaog Aquino', 'geneticmodi@gmail.com', '$2y$10$nNAfriRU5vNAG6L6cdcteelvcCwx3/X1x7F.et4lAtuUCahxXtbSm', 'Department of Information Technology', 'BSIT-1A', '2024-12-14', '+639129452915', 'Male', '2024-12-14 02:06:51', 'Staff', 'inactive'),
(35, 'Ahmad Pandaog Aquino', 'geneticmodi1@gmail.com', '$2y$10$lMNvfYPMBmCiV7EMhhqoOe.bwfe47WwM78KNTZfp3rDjLhC.pIhXG', 'Department of Computer Science', 'BSCS-1A', '2024-12-14', '+639129452915', 'Select a gender', '2024-12-14 02:13:31', 'Staff', 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `staff_notifications`
--

CREATE TABLE `staff_notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('teacher','student','class','subject','semester','account') NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `link` text NOT NULL,
  `status` enum('read','unread') NOT NULL DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `staff_notifications`
--

INSERT INTO `staff_notifications` (`id`, `user_id`, `type`, `title`, `description`, `date`, `link`, `status`) VALUES
(49, 29, 'teacher', 'New Staff Account Registration', 'A new staff account has been registered successfully.', '2024-12-14 02:13:31', 'teacher_management.php', 'read'),
(50, 29, 'teacher', 'New Class Additon with Teacher', 'A new class to be taught has been added by .John Doe', '2024-12-14 02:20:11', 'teacher_management.php', 'read'),
(51, 29, 'teacher', 'New Class Addition', 'A new class to be taught has been added by John Doe', '2024-12-14 02:20:33', 'teacher_management.php', 'read');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `fullName` text NOT NULL,
  `student_id` int(11) NOT NULL,
  `gender` text NOT NULL,
  `course` text NOT NULL,
  `year_level` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `role` text NOT NULL DEFAULT 'Student',
  `status` text NOT NULL DEFAULT 'inactive',
  `reset_token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `fullName`, `student_id`, `gender`, `course`, `year_level`, `email`, `password`, `role`, `status`, `reset_token`) VALUES
(4, 'Nifled Sespene', 12345679, 'Male', 'BSIT-1A', '2nd year', 'nifledtest@gmail.com', '$2y$10$0St3gmFjzctqxNpIWNFzd./f22qEvdxs1G5AI.XDAlS94Tbu2F7vS', 'Student', 'inactive', NULL),
(101, 'Leonard Aquino', 12345678, 'Male', 'BSIT-1A', '2nd year', 'leotest@gmail.com', '$2y$10$0St3gmFjzctqxNpIWNFzd./f22qEvdxs1G5AI.XDAlS94Tbu2F7vS', 'Student', 'inactive', NULL),
(103, 'Fatima Fitra', 12345677, 'Female', 'BSIT-1A', '2nd year', 'fitratest@gmail.com', '$2y$10$0St3gmFjzctqxNpIWNFzd./f22qEvdxs1G5AI.XDAlS94Tbu2F7vS', 'Student', 'inactive', NULL),
(104, 'Leonardo da Vinci Aquino', 202001523, 'Male', 'BSIT-1A', '1', 'leonardo123@gmail.com', '$2y$10$0St3gmFjzctqxNpIWNFzd./f22qEvdxs1G5AI.XDAlS94Tbu2F7vS', 'Student', 'inactive', NULL),
(110, 'Test name', 202001524, '', 'BSIT', '1st Year', 'xt202001524@wmsu.edu.ph', '$2y$10$C3J3es0DVkr/hGbfRSb3fuxPKOona/ajMK7IeOuw/giiGQRiWBgqi', 'Student', 'active', NULL),
(111, 'Test name', 202001522, '', 'BSIT', '1st Year', 'geneticmodi@wmsu.edu.ph', '$2y$10$mDkUCk02tTS7VopGR4YMmOmdbrmKJ9cwBi4XV.1CadloqoJzoCaW2', 'Student', 'inactive', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students_enrollments`
--

CREATE TABLE `students_enrollments` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `students_enrollments`
--

INSERT INTO `students_enrollments` (`id`, `class_id`, `student_id`) VALUES
(33, 64, 12345679),
(36, 64, 12345677),
(37, 75, 12345677),
(39, 80, 12345677);

-- --------------------------------------------------------

--
-- Table structure for table `student_grades`
--

CREATE TABLE `student_grades` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `midterm_grade` text DEFAULT NULL,
  `final_grade` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` text DEFAULT 'for_approval'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_grades`
--

INSERT INTO `student_grades` (`id`, `class_id`, `student_id`, `midterm_grade`, `final_grade`, `updated_at`, `status`) VALUES
(12, 64, 12345679, '5', '5', '2024-12-13 13:22:13', 'for_approval'),
(15, 64, 12345677, '5', '5', '2024-12-13 13:22:13', 'for_approval'),
(16, 75, 12345677, NULL, NULL, '2024-12-12 08:31:26', 'for_approval'),
(18, 80, 12345677, '5', '5', '2024-12-13 13:24:51', 'for_approval'),
(19, 80, 12345677, '5', '5', '2024-12-13 13:37:12', 'for_approval');

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE `student_info` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `course_year` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `emergency_contact` varchar(20) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `picture` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`id`, `student_id`, `full_name`, `email`, `phone_number`, `course_year`, `address`, `emergency_contact`, `gender`, `picture`) VALUES
(1, '12345679', 'Ahmad Aquino', 'test@gmail.com', '09129452915', 'BSIT-1A', 'test', '09129452915', 'Male', ''),
(2, '202001523', 'Leonardo Aquino', 'leonardo@gmail.com', '09129452915', 'BSIT-1A', 'Block 8, Lot 8 Extension, H.B Homes, Tumaga, Zamboanga City, Zamboanga del Sur, Philippines', '09129452915', 'Male', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` text NOT NULL,
  `code` text NOT NULL,
  `semester` text NOT NULL,
  `datetime_added` datetime NOT NULL DEFAULT current_timestamp(),
  `is_archived` int(11) NOT NULL DEFAULT 0,
  `course` varchar(100) NOT NULL,
  `year_level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `type`, `code`, `semester`, `datetime_added`, `is_archived`, `course`, `year_level`) VALUES
(43, 'Software Engineering', 'Lecture', 'IT - 141', '1st Semester', '2024-11-30 14:34:15', 0, 'BSIT', '1A'),
(44, 'Introduction to Computing', 'Lecture', 'IT - 141', '1st Semester', '2024-11-30 14:34:15', 0, 'BSIT', '1A'),
(45, 'Introduction to Computing', 'Laboratory', 'IT - 141', '1st Semester', '2024-11-30 14:34:15', 0, 'BSIT', '1A'),
(47, 'Capstone Project and Research 1', 'Lecture', 'IT 145', '2nd Semester', '2024-12-14 06:55:07', 0, 'BSIT', '4A');

-- --------------------------------------------------------

--
-- Table structure for table `subjects_meetings`
--

CREATE TABLE `subjects_meetings` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `subject_id` int(11) NOT NULL,
  `status` text NOT NULL,
  `start_time` text NOT NULL,
  `end_time` text NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `subjects_meetings`
--

INSERT INTO `subjects_meetings` (`id`, `date`, `subject_id`, `status`, `start_time`, `end_time`, `type`) VALUES
(24, '2024-10-29', 43, 'aguy', '14:22', '14:52', 'Regular'),
(25, '2024-10-29', 64, 'aguy', '7:50 PM', '7:53 PM', 'Regular'),
(28, '2024-10-26', 43, 'Scheduled', '11:51 AM', '12:51 PM', 'Regular'),
(31, '2024-11-01', 43, 'Ongoing', '11:42 PM', '11:50 PM', 'Regular'),
(34, '2024-11-02', 43, 'Ongoing', '8:59 AM', '10:56 AM', 'Regular');

-- --------------------------------------------------------

--
-- Table structure for table `subjects_schedules`
--

CREATE TABLE `subjects_schedules` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `meeting_days` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `start_time` varchar(555) NOT NULL,
  `end_time` varchar(555) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `subjects_schedules`
--

INSERT INTO `subjects_schedules` (`id`, `subject_id`, `meeting_days`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(7, 43, 'Monday', '12:42', '17:55', '2024-11-30 06:34:15', '2024-11-30 06:34:15'),
(8, 43, 'Thursday', '12:42', '17:55', '2024-11-30 06:34:15', '2024-12-12 13:07:34'),
(10, 47, 'Monday', '08:00', '12:00', '2024-12-13 22:55:07', '2024-12-13 22:55:07'),
(11, 47, 'Wednesday', '08:00', '12:00', '2024-12-13 22:55:07', '2024-12-13 22:55:07'),
(12, 47, 'Friday', '08:00', '12:00', '2024-12-13 22:55:07', '2024-12-13 22:55:07');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_notes`
--

CREATE TABLE `teacher_notes` (
  `id` int(11) NOT NULL,
  `teacher_name` varchar(255) NOT NULL,
  `note_title` varchar(255) NOT NULL,
  `note_content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teacher_notes`
--

INSERT INTO `teacher_notes` (`id`, `teacher_name`, `note_title`, `note_content`, `created_at`, `updated_at`) VALUES
(4, 'John Doe', 'test', 'test', '2024-12-07 15:00:19', '2024-12-07 15:00:19'),
(5, 'John Doe', 'hey', 'hey', '2024-12-07 15:07:30', '2024-12-07 15:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_reminders`
--

CREATE TABLE `teacher_reminders` (
  `id` int(11) NOT NULL,
  `teacher_name` varchar(255) NOT NULL,
  `reminder_content` text NOT NULL,
  `reminder_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teacher_reminders`
--

INSERT INTO `teacher_reminders` (`id`, `teacher_name`, `reminder_content`, `reminder_date`, `created_at`) VALUES
(13, 'John Doe', 'test', '2024-12-07', '2024-12-07 15:09:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_activity` (`title`,`class_id`,`subject_id`);

--
-- Indexes for table `activity_attachments`
--
ALTER TABLE `activity_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `activity_submissions`
--
ALTER TABLE `activity_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_auto_notifications`
--
ALTER TABLE `admin_auto_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_notes`
--
ALTER TABLE `admin_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_reminders`
--
ALTER TABLE `admin_reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `archived_semesters`
--
ALTER TABLE `archived_semesters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes_meetings`
--
ALTER TABLE `classes_meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_students`
--
ALTER TABLE `class_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `current_semester`
--
ALTER TABLE `current_semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laboratory_rubrics`
--
ALTER TABLE `laboratory_rubrics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learning_resources`
--
ALTER TABLE `learning_resources`
  ADD PRIMARY KEY (`resource_id`);

--
-- Indexes for table `lectures`
--
ALTER TABLE `lectures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecture_rubrics`
--
ALTER TABLE `lecture_rubrics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_accounts`
--
ALTER TABLE `staff_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_notifications`
--
ALTER TABLE `staff_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students_enrollments`
--
ALTER TABLE `students_enrollments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_grades`
--
ALTER TABLE `student_grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_info`
--
ALTER TABLE `student_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects_meetings`
--
ALTER TABLE `subjects_meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects_schedules`
--
ALTER TABLE `subjects_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subject` (`subject_id`);

--
-- Indexes for table `teacher_notes`
--
ALTER TABLE `teacher_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_reminders`
--
ALTER TABLE `teacher_reminders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `activity_attachments`
--
ALTER TABLE `activity_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `activity_submissions`
--
ALTER TABLE `activity_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `admin_auto_notifications`
--
ALTER TABLE `admin_auto_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin_notes`
--
ALTER TABLE `admin_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `admin_reminders`
--
ALTER TABLE `admin_reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `archived_semesters`
--
ALTER TABLE `archived_semesters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `classes_meetings`
--
ALTER TABLE `classes_meetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `class_students`
--
ALTER TABLE `class_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `current_semester`
--
ALTER TABLE `current_semester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `laboratory_rubrics`
--
ALTER TABLE `laboratory_rubrics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `learning_resources`
--
ALTER TABLE `learning_resources`
  MODIFY `resource_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lectures`
--
ALTER TABLE `lectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lecture_rubrics`
--
ALTER TABLE `lecture_rubrics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=518;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `staff_accounts`
--
ALTER TABLE `staff_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `staff_notifications`
--
ALTER TABLE `staff_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `students_enrollments`
--
ALTER TABLE `students_enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `student_grades`
--
ALTER TABLE `student_grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `student_info`
--
ALTER TABLE `student_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `subjects_meetings`
--
ALTER TABLE `subjects_meetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `subjects_schedules`
--
ALTER TABLE `subjects_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `teacher_notes`
--
ALTER TABLE `teacher_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teacher_reminders`
--
ALTER TABLE `teacher_reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_attachments`
--
ALTER TABLE `activity_attachments`
  ADD CONSTRAINT `activity_attachments_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `class_students`
--
ALTER TABLE `class_students`
  ADD CONSTRAINT `class_students_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_students_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects_schedules`
--
ALTER TABLE `subjects_schedules`
  ADD CONSTRAINT `fk_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
