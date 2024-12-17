-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2024 at 10:08 AM
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
(19, 'test', 'quiz', 'test', '2024-12-09', '03:32PM', 25, 55, 64, 43, '2024-12-09 00:31:55', '2024-12-09 00:31:55', 'midterm'),
(20, 'tester', 'quiz', '25', '2024-12-09', '04:10PM', 25, 55, 64, 43, '2024-12-09 01:10:34', '2024-12-09 01:10:34', 'midterm'),
(21, 'asdasd', 'activity', 'hahaha', '2024-12-09', '04:25PM', 25, 50, 64, 43, '2024-12-09 01:25:37', '2024-12-09 01:25:37', 'midterm');

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
(9, 19, 'Capstone 2 - FINAL DOCUMENTATION (Updated).pdf', '../../../../uploads/files/67569ceb8143c-Capstone 2 - FINAL DOCUMENTATION (Updated).pdf', '2024-12-09 08:31:55'),
(10, 20, 'IT140_CapstoneProjectAndResearch2_FINAL_DOCUMENTATION-updated file.pdf', '../../../../uploads/files/6756a5fa3eda7-IT140_CapstoneProjectAndResearch2_FINAL_DOCUMENTATION-updated file.pdf', '2024-12-09 09:10:34'),
(11, 21, 'csms_system (19).sql', '../../../../uploads/files/6756a9816ca77-csms_system (19).sql', '2024-12-09 09:25:37');

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
(13, 19, 12345678, NULL, 0, NULL, 'pending', NULL),
(14, 19, 12345679, NULL, 0, NULL, 'pending', NULL),
(15, 20, 12345678, NULL, 0, NULL, 'pending', NULL),
(16, 20, 12345679, NULL, 0, NULL, 'pending', NULL),
(17, 21, 12345678, NULL, 0, NULL, 'pending', NULL),
(18, 21, 12345679, NULL, 0, NULL, 'pending', NULL);

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
  `gender` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `first_name`, `middle_name`, `last_name`, `date_created`, `last_login`, `phone_number`, `gender`) VALUES
(11, 'admin_ccs', 'admin_ccs@wmsu.com', '$2y$10$wpEG6wnmQVbA2OTEFlCOJOMRuoFSq2kW4yzoR7FrIxF9UwNqg1oqG', 'Lucas', 'Alexander', 'Mitchell', '2024-09-22', '2024-12-09 10:32:49', '+639123456789', 'Male');

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
  `icon` text NOT NULL,
  `id` int(11) NOT NULL,
  `type` enum('teacher','student','class','subject','semester','account') NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `link` text NOT NULL,
  `status` enum('read','unread') NOT NULL DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `class_id`, `meeting_id`, `status`, `timestamp`, `date`) VALUES
(61, 12345679, 64, 39, 'late', '2024-12-06 06:49:46', '2024-12-06'),
(62, 12345678, 64, 39, 'late', '2024-12-06 06:54:45', '2024-12-06');

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
(80, 'BSIT-1A', 'Laboratory', 'Introduction to Computing', 44, 'IT - 141', 'John Doe', '1st Semester', 0, 'test', 'Q096XO', NULL, 'accepted', NULL, '2024-12-09 11:01:22', 0);

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
(24, '2024-10-29', 64, 'aguy', '14:22', '14:52', 'Regular'),
(25, '2024-10-29', 64, 'aguy', '7:50 PM', '7:53 PM', 'Regular'),
(28, '2024-10-26', 64, 'Scheduled', '11:51 AM', '12:51 PM', 'Regular'),
(31, '2024-11-01', 64, 'Ongoing', '11:42 PM', '11:50 PM', 'Regular'),
(34, '2024-11-02', 64, 'Ongoing', '8:59 AM', '10:56 AM', 'Regular'),
(35, '2024-12-31', 64, 'Scheduled', '12:42 PM', '5:55 PM', 'Regular'),
(36, '2024-12-02', 64, 'Scheduled', '12:42 PM', '5:55 PM', 'Regular'),
(37, '2024-12-01', 64, 'Ongoing', '12:42 PM', '5:55 PM', 'Regular'),
(38, '2024-12-02', 64, 'Ongoing', '7:00 AM', '9:00 AM', 'Regular'),
(39, '2024-12-06', 64, 'Ongoing', '2:40 PM', '5:55 PM', 'Regular'),
(40, '2024-12-06', 64, 'Ongoing', '12:42 PM', '5:55 PM', 'Regular'),
(41, '2024-12-07', 64, 'Scheduled', '12:42 PM', '5:55 PM', 'Regular'),
(42, '2024-12-08', 64, 'Scheduled', '1:13 AM', '1:55 AM', 'Regular');

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
(5, 64, 43, 'Test', 'document', 'test', 'CERTIFICATE.pdf', '2024-12-06 02:52:09');

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
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_type` enum('admin','student','staff') NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `receiver_type` enum('admin','student','staff') NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `sender_type`, `receiver_id`, `receiver_type`, `message`, `timestamp`) VALUES
(265, 29, 'staff', 29, 'staff', 'uy', '2024-12-07 11:36:08'),
(266, 29, 'staff', 11, 'admin', 'heyy', '2024-12-07 11:36:31'),
(267, 11, 'admin', 29, 'staff', 'yoo', '2024-12-07 11:36:40'),
(268, 29, 'staff', 11, 'admin', 'hey there', '2024-12-07 11:36:47'),
(269, 11, 'admin', 29, 'staff', 'wait', '2024-12-07 11:36:53'),
(270, 29, 'staff', 11, 'admin', 'hey', '2024-12-07 11:36:55'),
(271, 11, 'admin', 29, 'staff', 'hey', '2024-12-07 11:38:13'),
(272, 29, 'staff', 11, 'admin', 'heyy', '2024-12-07 11:38:15'),
(273, 29, 'staff', 11, 'admin', 'This is from the staff', '2024-12-07 11:38:23'),
(274, 11, 'admin', 29, 'staff', 'This is from the admin', '2024-12-07 11:38:29'),
(275, 29, 'staff', 11, 'admin', 'Hey', '2024-12-07 11:38:38'),
(276, 11, 'admin', 29, 'staff', 'hey', '2024-12-07 11:39:40'),
(277, 29, 'staff', 11, 'admin', 'yo', '2024-12-07 11:39:44'),
(278, 29, 'staff', 11, 'admin', 'I don\'t quite get it.', '2024-12-07 11:39:54'),
(279, 11, 'admin', 29, 'staff', 'Sir?', '2024-12-07 11:39:59'),
(280, 11, 'admin', 29, 'staff', 'hey', '2024-12-07 11:44:17'),
(281, 29, 'staff', 11, 'admin', 'heyy', '2024-12-07 11:44:20'),
(282, 29, 'staff', 11, 'admin', 'hii', '2024-12-07 11:44:24'),
(283, 11, 'admin', 29, 'staff', 'po', '2024-12-07 11:44:27'),
(284, 11, 'admin', 29, 'staff', 'hey', '2024-12-07 11:46:04'),
(285, 29, 'staff', 11, 'admin', 'heyy', '2024-12-07 11:46:08'),
(286, 29, 'staff', 11, 'admin', 'hey', '2024-12-07 11:46:10'),
(287, 29, 'staff', 11, 'admin', 'hey', '2024-12-07 11:46:11'),
(288, 29, 'staff', 11, 'admin', 'hey', '2024-12-07 11:46:12'),
(289, 29, 'staff', 11, 'admin', 'hey', '2024-12-07 11:46:13'),
(290, 29, 'staff', 11, 'admin', 'ASDASDASDSA', '2024-12-07 11:46:19'),
(291, 11, 'admin', 29, 'staff', 'tangina mo!', '2024-12-07 11:46:25'),
(292, 29, 'staff', 11, 'admin', 'HUH', '2024-12-07 11:47:06'),
(293, 11, 'admin', 29, 'staff', 'gago ka!', '2024-12-07 11:47:12'),
(294, 29, 'staff', 11, 'admin', 'TANGINA MO PO!', '2024-12-07 11:47:19'),
(295, 11, 'admin', 29, 'staff', 'huy bat ka nagmumura?', '2024-12-07 11:47:27'),
(297, 29, 'staff', 11, 'admin', 'HALA OO PALA', '2024-12-07 11:47:38'),
(298, 11, 'admin', 29, 'staff', 'hey', '2024-12-07 12:11:32'),
(299, 11, 'admin', 29, 'staff', 'hey', '2024-12-07 12:12:33'),
(300, 11, 'admin', 29, 'staff', 'asdasd', '2024-12-07 12:19:53'),
(301, 29, 'staff', 11, 'admin', 'ashdashd', '2024-12-07 12:19:57'),
(302, 29, 'staff', 11, 'admin', 'asdhsahd', '2024-12-07 12:20:00'),
(303, 11, 'admin', 29, 'staff', 'HELLO', '2024-12-07 12:20:05'),
(304, 29, 'staff', 11, 'admin', 'hello admin', '2024-12-07 12:20:10'),
(305, 11, 'admin', 29, 'staff', 'zczxczxczxc', '2024-12-07 12:23:58'),
(306, 29, 'staff', 11, 'admin', 'asdasdasdasd', '2024-12-07 12:24:01'),
(307, 29, 'staff', 4, 'student', 'hey', '2024-12-07 16:36:19'),
(308, 29, 'staff', 11, 'admin', 'HAHAHAHA', '2024-12-07 17:17:45');

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
  `datetime_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `staff_accounts`
--

INSERT INTO `staff_accounts` (`id`, `fullName`, `email`, `password`, `department`, `class`, `date_created`, `phone_number`, `gender`, `datetime_added`) VALUES
(29, 'John Doe', 'johndoe@gmail.com', '$2y$10$hi7fm38tEwbnCG8/aPpMqusseA6ym4vM5lYULLeZMXRAeey0MKhoW', 'Department of Information Technology', 'BSIT-1A', '2024-11-30', '+639129452915', 'Male', '2024-11-30 10:18:11'),
(33, 'test', 'test@yahoes.com', '$2y$10$CXlrPpgDXC1OdmEw/wWmiOZkDJDneA9hjXQtJqdCpI7BMGjcrbV9W', 'Department of Information Technology', 'None', '2024-11-30', '9129452915', 'Male', '2024-11-30 10:48:30');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `fullName` text NOT NULL,
  `student_id` int(11) NOT NULL,
  `course` text NOT NULL,
  `year_level` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `qr_code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `fullName`, `student_id`, `course`, `year_level`, `email`, `password`, `qr_code`) VALUES
(4, 'Nifled Sespene', 12345679, 'BSIT-1A', '2nd year', '25', 'testpass', 'test'),
(101, 'Leonard Aquino', 12345678, 'BSIT-1A', '2nd year', 'leotest@gmail.com', 'testpass', 'test');

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
(19, 64, 12345678),
(20, 64, 12345679);

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE `student_info` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `course_year` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
(45, 'Introduction to Computing', 'Laboratory', 'IT - 141', '1st Semester', '2024-11-30 14:34:15', 0, 'BSIT', '1A');

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
(8, 43, 'Friday', '12:42', '17:55', '2024-11-30 06:34:15', '2024-11-30 06:34:15');

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
-- Indexes for table `student_info`
--
ALTER TABLE `student_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `activity_attachments`
--
ALTER TABLE `activity_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `activity_submissions`
--
ALTER TABLE `activity_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `classes_meetings`
--
ALTER TABLE `classes_meetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

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
-- AUTO_INCREMENT for table `learning_resources`
--
ALTER TABLE `learning_resources`
  MODIFY `resource_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lectures`
--
ALTER TABLE `lectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=309;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `staff_accounts`
--
ALTER TABLE `staff_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `students_enrollments`
--
ALTER TABLE `students_enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `student_info`
--
ALTER TABLE `student_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `subjects_meetings`
--
ALTER TABLE `subjects_meetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `subjects_schedules`
--
ALTER TABLE `subjects_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teacher_notes`
--
ALTER TABLE `teacher_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Constraints for table `student_info`
--
ALTER TABLE `student_info`
  ADD CONSTRAINT `student_info_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects_schedules`
--
ALTER TABLE `subjects_schedules`
  ADD CONSTRAINT `fk_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
