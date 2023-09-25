-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 23, 2023 at 11:22 AM
-- Server version: 10.6.12-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `3e_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `3e_account`
--

CREATE TABLE `3e_account` (
  `account_id` varchar(21) NOT NULL,
  `account_project_id` varchar(21) NOT NULL,
  `account_project_name` varchar(200) NOT NULL,
  `account_year` char(4) NOT NULL,
  `account_bank` varchar(5) NOT NULL,
  `account_bank_code` varchar(20) NOT NULL,
  `account_bank_name` varchar(150) NOT NULL,
  `tab1_obj` text NOT NULL,
  `tab2_obj` text NOT NULL,
  `tab3_obj` longtext NOT NULL,
  `tab4_obj` longtext NOT NULL,
  `tab5_obj` text NOT NULL,
  `account_member_username` varchar(50) NOT NULL,
  `account_member_permission` text NOT NULL,
  `account_status_complate_is` tinyint(1) NOT NULL,
  `account_status_complate_date` date DEFAULT NULL,
  `account_createdate` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `3e_account_file`
--

CREATE TABLE `3e_account_file` (
  `file_id` bigint(10) NOT NULL,
  `file_account_id` varchar(21) NOT NULL,
  `file_account_point` varchar(20) NOT NULL,
  `file_name` varchar(150) NOT NULL,
  `file_path` varchar(100) NOT NULL,
  `file_size` double NOT NULL,
  `file_member_username` varchar(50) NOT NULL,
  `file_createdate` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `3e_advance`
--

CREATE TABLE `3e_advance` (
  `advance_id` varchar(21) NOT NULL,
  `advance_code` varchar(15) NOT NULL,
  `advance_project_name` varchar(500) NOT NULL,
  `advance_central` varchar(150) NOT NULL,
  `advance_member_username` varchar(50) NOT NULL,
  `advance_detail` text NOT NULL,
  `advance_refunds_id` varchar(15) DEFAULT NULL,
  `advance_refunds_price` double DEFAULT NULL,
  `advance_verify_is` tinyint(1) NOT NULL,
  `advance_verrify_username` varchar(50) NOT NULL,
  `advance_verrify_datetime` datetime NOT NULL,
  `advance_is_pay` tinyint(1) NOT NULL,
  `advance_is_pay_username` varchar(50) NOT NULL,
  `advance_is_pay_datetime` datetime NOT NULL,
  `advance_createdate` datetime NOT NULL,
  `advance_updatedate` datetime NOT NULL,
  `advance_status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `3e_advance_clear`
--

CREATE TABLE `3e_advance_clear` (
  `advance_clear_id` int(5) NOT NULL,
  `advance_id` varchar(21) NOT NULL,
  `advance_clear_real_money` double NOT NULL,
  `advance_clear_price_total` double NOT NULL,
  `advance_clear_status` tinyint(1) DEFAULT NULL,
  `advance_clear_type` tinyint(1) NOT NULL,
  `advance_clear_type_note` varchar(100) DEFAULT NULL,
  `advance_clear_datetime` datetime NOT NULL,
  `advance_clear_verify_is` tinyint(4) NOT NULL,
  `advance_clear_verify_detail` varchar(1000) NOT NULL,
  `advance_clear_verify_username` varchar(50) NOT NULL,
  `advance_clear_verify_datetime` datetime NOT NULL,
  `advance_clear_approve_is` tinyint(4) NOT NULL,
  `advance_clear_approve_username` varchar(50) NOT NULL,
  `advance_clear_approve_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `3e_document_transfer`
--

CREATE TABLE `3e_document_transfer` (
  `transfer_id` varchar(21) NOT NULL,
  `transfer_type` varchar(10) NOT NULL,
  `transfer_code` varchar(100) NOT NULL,
  `transfer_no` varchar(100) DEFAULT NULL,
  `transfer_category_id` int(5) NOT NULL,
  `transfer_category_name` varchar(100) DEFAULT NULL,
  `transfer_date` date NOT NULL,
  `transfer_form` varchar(150) NOT NULL,
  `transfer_to` varchar(150) NOT NULL,
  `transfer_title` varchar(200) NOT NULL,
  `transfer_responsible` varchar(1000) NOT NULL,
  `transfer_responsible_other` varchar(150) DEFAULT NULL,
  `transfer_approve` tinyint(1) NOT NULL,
  `transfer_approve_username` varchar(50) NOT NULL,
  `transfer_approve_date` datetime NOT NULL,
  `transfer_createdate` datetime NOT NULL,
  `transfer_member_username` varchar(50) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `3e_document_transfer_category`
--

CREATE TABLE `3e_document_transfer_category` (
  `category_id` int(5) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `3e_document_transfer_file`
--

CREATE TABLE `3e_document_transfer_file` (
  `file_id` bigint(10) NOT NULL,
  `file_transfer_id` varchar(21) NOT NULL,
  `file_name` varchar(150) NOT NULL,
  `file_path` varchar(150) NOT NULL,
  `file_size` double NOT NULL,
  `file_createdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `3e_project`
--

CREATE TABLE `3e_project` (
  `project_id` varchar(21) NOT NULL,
  `project_code` varchar(21) NOT NULL,
  `project_name` varchar(200) NOT NULL,
  `project_name_en` varchar(200) NOT NULL,
  `project_funds` varchar(150) NOT NULL,
  `project_year` char(4) NOT NULL,
  `project_responsible` varchar(150) NOT NULL,
  `project_budget` double NOT NULL,
  `project_org` varchar(200) NOT NULL,
  `project_signdate` date NOT NULL,
  `project_startdate` date NOT NULL,
  `project_enddate` date NOT NULL,
  `project_status_ic` char(1) NOT NULL COMMENT 'i, c',
  `project_status_ic_date` date NOT NULL,
  `project_status_op` varchar(150) NOT NULL,
  `project_status` varchar(10) NOT NULL COMMENT 'pre, doing, done, research',
  `project_status_success` tinyint(1) NOT NULL COMMENT 'สถานะปิดบญชี 1 = success',
  `project_status_success_date` date NOT NULL,
  `project_pre` text DEFAULT NULL,
  `project_doing` text DEFAULT NULL,
  `project_done` text DEFAULT NULL,
  `project_create_member_username` varchar(50) NOT NULL,
  `project_member_permission` text NOT NULL,
  `project_createdate` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `3e_project_file`
--

CREATE TABLE `3e_project_file` (
  `file_id` bigint(20) NOT NULL,
  `file_project_id` varchar(21) NOT NULL,
  `file_preject_point` varchar(30) NOT NULL,
  `file_name` varchar(150) NOT NULL,
  `file_path` varchar(100) NOT NULL,
  `file_size` double NOT NULL,
  `file_member_username` varchar(50) NOT NULL,
  `file_createdate` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doc_research`
--

CREATE TABLE `doc_research` (
  `research_id` int(5) NOT NULL,
  `research_title` varchar(225) NOT NULL,
  `research_journal` varchar(225) NOT NULL,
  `research_year` char(4) NOT NULL,
  `research_author` varchar(150) NOT NULL,
  `research_status` varchar(100) NOT NULL,
  `research_tags` varchar(100) NOT NULL,
  `research_file` varchar(500) NOT NULL,
  `research_member_username` varchar(50) NOT NULL,
  `createdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doc_thesis`
--

CREATE TABLE `doc_thesis` (
  `thesis_id` int(5) NOT NULL,
  `thesis_title` varchar(225) NOT NULL,
  `thesis_year` char(4) NOT NULL,
  `thesis_owner` varchar(150) NOT NULL,
  `thesis_tags` varchar(100) NOT NULL,
  `thesis_class` varchar(50) NOT NULL,
  `thesis_member_username` varchar(50) NOT NULL,
  `createdate` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doc_thesis_file`
--

CREATE TABLE `doc_thesis_file` (
  `file_id` int(10) NOT NULL,
  `file_thesis_id` int(5) NOT NULL,
  `file_path` varchar(100) NOT NULL,
  `file_name` varchar(150) NOT NULL,
  `file_size` double NOT NULL,
  `createdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_username` varchar(50) NOT NULL,
  `member_password` varchar(150) NOT NULL,
  `member_name` varchar(100) NOT NULL,
  `member_email` varchar(150) NOT NULL,
  `member_position` varchar(100) NOT NULL,
  `member_img` varchar(100) NOT NULL,
  `member_secret` varchar(150) NOT NULL,
  `member_level` tinyint(1) NOT NULL,
  `member_status` tinyint(1) NOT NULL,
  `member_lastlogin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_username`, `member_password`, `member_name`, `member_email`, `member_position`, `member_img`, `member_secret`, `member_level`, `member_status`, `member_lastlogin`) VALUES
('admin', 'ab1e6e95a289d4a32834a9bab474e631', 'anonymous', '', '', 'avatar_5.png', '', 3, 1, '2023-05-09 19:56:44'),
('staff', 'd93c51bbb01f716d038b67c7ca1f45df', 'staff name', '', '', 'avatar_1.png', '', 1, 1, '2022-09-26 13:16:28');

-- --------------------------------------------------------

--
-- Table structure for table `member_log`
--

CREATE TABLE `member_log` (
  `log_id` bigint(20) NOT NULL,
  `log_member_username` varchar(50) NOT NULL,
  `log_action` varchar(1000) NOT NULL,
  `log_ua` varchar(1000) NOT NULL,
  `log_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vb_cfo`
--

CREATE TABLE `vb_cfo` (
  `cfo_id` varchar(21) NOT NULL,
  `cfo_month` int(2) NOT NULL,
  `cfo_year` char(4) NOT NULL,
  `cfo_project_name` varchar(250) NOT NULL,
  `cfo_cv_permission` varchar(500) NOT NULL,
  `cfo_cv_obj` text NOT NULL,
  `cfo_vd_permission` varchar(500) NOT NULL,
  `cfo_vd_obj` text NOT NULL,
  `createdate` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vb_document`
--

CREATE TABLE `vb_document` (
  `doc_id` int(5) NOT NULL,
  `doc_topic_id` int(5) NOT NULL,
  `doc_name` varchar(150) NOT NULL,
  `doc_file` varchar(150) NOT NULL,
  `createdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vb_document_set`
--

CREATE TABLE `vb_document_set` (
  `set_id` int(11) NOT NULL,
  `set_type` varchar(10) NOT NULL,
  `set_source_id` varchar(22) NOT NULL,
  `set_point` varchar(5) NOT NULL,
  `set_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vb_document_topic`
--

CREATE TABLE `vb_document_topic` (
  `topic_id` int(5) NOT NULL,
  `topic_name` varchar(200) NOT NULL,
  `topic_permission` text DEFAULT NULL,
  `topic_group` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vb_file`
--

CREATE TABLE `vb_file` (
  `file_id` bigint(10) NOT NULL,
  `file_source_id` varchar(22) NOT NULL,
  `file_point` varchar(5) NOT NULL,
  `file_type` varchar(10) NOT NULL,
  `file_name` varchar(150) NOT NULL,
  `file_path` varchar(150) NOT NULL,
  `file_size` double NOT NULL,
  `file_member_username` varchar(50) NOT NULL,
  `file_createdate` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vb_permissions`
--

CREATE TABLE `vb_permissions` (
  `id` int(5) NOT NULL,
  `cfo` text NOT NULL,
  `tver` text NOT NULL,
  `docs` text NOT NULL,
  `request` text NOT NULL,
  `updatedate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vb_tver`
--

CREATE TABLE `vb_tver` (
  `tver_id` varchar(21) NOT NULL,
  `tver_month` int(2) NOT NULL,
  `tver_year` char(4) NOT NULL,
  `tver_project_name` varchar(250) NOT NULL,
  `tver_cv_permission` varchar(500) NOT NULL,
  `tver_cv_obj` text NOT NULL,
  `tver_vd_permission` varchar(500) NOT NULL,
  `tver_vd_obj` text NOT NULL,
  `createdate` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `3e_account`
--
ALTER TABLE `3e_account`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `3e_account_file`
--
ALTER TABLE `3e_account_file`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `3e_advance`
--
ALTER TABLE `3e_advance`
  ADD PRIMARY KEY (`advance_id`);

--
-- Indexes for table `3e_advance_clear`
--
ALTER TABLE `3e_advance_clear`
  ADD PRIMARY KEY (`advance_clear_id`);

--
-- Indexes for table `3e_document_transfer`
--
ALTER TABLE `3e_document_transfer`
  ADD PRIMARY KEY (`transfer_id`);

--
-- Indexes for table `3e_document_transfer_category`
--
ALTER TABLE `3e_document_transfer_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `3e_document_transfer_file`
--
ALTER TABLE `3e_document_transfer_file`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `3e_project`
--
ALTER TABLE `3e_project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `3e_project_file`
--
ALTER TABLE `3e_project_file`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `doc_research`
--
ALTER TABLE `doc_research`
  ADD PRIMARY KEY (`research_id`);

--
-- Indexes for table `doc_thesis`
--
ALTER TABLE `doc_thesis`
  ADD PRIMARY KEY (`thesis_id`);

--
-- Indexes for table `doc_thesis_file`
--
ALTER TABLE `doc_thesis_file`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_username`);

--
-- Indexes for table `member_log`
--
ALTER TABLE `member_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `vb_cfo`
--
ALTER TABLE `vb_cfo`
  ADD PRIMARY KEY (`cfo_id`);

--
-- Indexes for table `vb_document`
--
ALTER TABLE `vb_document`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indexes for table `vb_document_set`
--
ALTER TABLE `vb_document_set`
  ADD PRIMARY KEY (`set_id`);

--
-- Indexes for table `vb_document_topic`
--
ALTER TABLE `vb_document_topic`
  ADD PRIMARY KEY (`topic_id`);

--
-- Indexes for table `vb_file`
--
ALTER TABLE `vb_file`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `vb_permissions`
--
ALTER TABLE `vb_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vb_tver`
--
ALTER TABLE `vb_tver`
  ADD PRIMARY KEY (`tver_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `3e_account_file`
--
ALTER TABLE `3e_account_file`
  MODIFY `file_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `3e_advance_clear`
--
ALTER TABLE `3e_advance_clear`
  MODIFY `advance_clear_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `3e_document_transfer_category`
--
ALTER TABLE `3e_document_transfer_category`
  MODIFY `category_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `3e_document_transfer_file`
--
ALTER TABLE `3e_document_transfer_file`
  MODIFY `file_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `3e_project_file`
--
ALTER TABLE `3e_project_file`
  MODIFY `file_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doc_research`
--
ALTER TABLE `doc_research`
  MODIFY `research_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doc_thesis`
--
ALTER TABLE `doc_thesis`
  MODIFY `thesis_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doc_thesis_file`
--
ALTER TABLE `doc_thesis_file`
  MODIFY `file_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_log`
--
ALTER TABLE `member_log`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vb_document`
--
ALTER TABLE `vb_document`
  MODIFY `doc_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vb_document_set`
--
ALTER TABLE `vb_document_set`
  MODIFY `set_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vb_document_topic`
--
ALTER TABLE `vb_document_topic`
  MODIFY `topic_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vb_file`
--
ALTER TABLE `vb_file`
  MODIFY `file_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vb_permissions`
--
ALTER TABLE `vb_permissions`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
