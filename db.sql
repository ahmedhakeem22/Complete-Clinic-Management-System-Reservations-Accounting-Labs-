-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 17 نوفمبر 2024 الساعة 14:40
-- إصدار الخادم: 8.0.37
-- PHP Version: 8.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `najmdb`
--

-- --------------------------------------------------------

--
-- بنية الجدول `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `a_name` varchar(55) NOT NULL,
  `u_pass` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `blood_admin`
--

CREATE TABLE `blood_admin` (
  `id` int NOT NULL,
  `u_name` varchar(55) NOT NULL,
  `u_pass` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `blood_test`
--

CREATE TABLE `blood_test` (
  `id_test` int NOT NULL,
  `pat_id` int NOT NULL,
  `hb` mediumtext NOT NULL,
  `wbc` mediumtext NOT NULL,
  `neutrophil` mediumtext NOT NULL,
  `lymphocyte` mediumtext NOT NULL,
  `monocyte` mediumtext NOT NULL,
  `esoinophil` mediumtext NOT NULL,
  `platelats` mediumtext NOT NULL,
  `esr` mediumtext NOT NULL,
  `malaria` mediumtext NOT NULL,
  `ct` mediumtext NOT NULL,
  `pt` mediumtext NOT NULL,
  `ptc` mediumtext NOT NULL,
  `inr` mediumtext NOT NULL,
  `bt` mediumtext NOT NULL,
  `reticulocyte` mediumtext NOT NULL,
  `sickling` mediumtext NOT NULL,
  `ptt` mediumtext NOT NULL,
  `pttc` mediumtext NOT NULL,
  `d_dimer` mediumtext NOT NULL,
  `fbs` mediumtext NOT NULL,
  `rbs` mediumtext NOT NULL,
  `p_pbs` mediumtext NOT NULL,
  `hba` mediumtext NOT NULL,
  `urea` mediumtext NOT NULL,
  `creatinine` mediumtext NOT NULL,
  `s_got` mediumtext NOT NULL,
  `s_gpt` mediumtext NOT NULL,
  `total_bilirubin` mediumtext NOT NULL,
  `dirict_bilirubin` mediumtext NOT NULL,
  `alk_phospats` mediumtext NOT NULL,
  `albumin` mediumtext NOT NULL,
  `ca` mediumtext NOT NULL,
  `k` mediumtext NOT NULL,
  `na` mediumtext NOT NULL,
  `cl` mediumtext NOT NULL,
  `mg` mediumtext NOT NULL,
  `ck` mediumtext NOT NULL,
  `ck_mb` mediumtext NOT NULL,
  `ldh` mediumtext NOT NULL,
  `cholesterol` mediumtext NOT NULL,
  `triglyceride` mediumtext NOT NULL,
  `ldl` mediumtext NOT NULL,
  `hdl` mediumtext NOT NULL,
  `uricacid` mediumtext NOT NULL,
  `t_patinte` mediumtext NOT NULL,
  `aso` mediumtext NOT NULL,
  `crp` mediumtext NOT NULL,
  `rf` mediumtext NOT NULL,
  `salmon_o` mediumtext NOT NULL,
  `salmon_h` mediumtext NOT NULL,
  `salmon_a` mediumtext NOT NULL,
  `salmon_b` mediumtext NOT NULL,
  `brucella_a` mediumtext NOT NULL,
  `brucella_m` mediumtext NOT NULL,
  `blood_group` mediumtext NOT NULL,
  `tb` mediumtext NOT NULL,
  `hiv` mediumtext NOT NULL,
  `hcv` mediumtext NOT NULL,
  `hbs_ag` mediumtext NOT NULL,
  `vdrl` mediumtext NOT NULL,
  `h_pylori_rb` mediumtext NOT NULL,
  `h_pylori_ag` mediumtext NOT NULL,
  `ethanol` mediumtext NOT NULL,
  `dlhjpam` mediumtext NOT NULL,
  `marijuana` mediumtext NOT NULL,
  `tramedol` mediumtext NOT NULL,
  `heroin` mediumtext NOT NULL,
  `pethidine` mediumtext NOT NULL,
  `cocaine` mediumtext NOT NULL,
  `amphetamine` mediumtext NOT NULL,
  `t3` mediumtext NOT NULL,
  `t4` mediumtext NOT NULL,
  `tsh` mediumtext NOT NULL,
  `prolactin` mediumtext NOT NULL,
  `psa` mediumtext NOT NULL,
  `ps3` mediumtext NOT NULL,
  `vitb` mediumtext NOT NULL,
  `vitd` mediumtext NOT NULL,
  `ca153` mediumtext NOT NULL,
  `ca125` mediumtext NOT NULL,
  `today_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `box_bh`
--

CREATE TABLE `box_bh` (
  `box_id` int NOT NULL,
  `name_box` varchar(100) DEFAULT NULL,
  `box_cost` float DEFAULT NULL,
  `box_date` date DEFAULT NULL,
  `box_note` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `buy_invpice`
--

CREATE TABLE `buy_invpice` (
  `id_invoice` int NOT NULL,
  `date_buy` date NOT NULL,
  `delegate` mediumtext NOT NULL,
  `name_med` mediumtext NOT NULL,
  `countity` int NOT NULL,
  `expired_date` date NOT NULL,
  `sale_price` float NOT NULL,
  `buy_price` float NOT NULL,
  `name_sinc` mediumtext NOT NULL,
  `copny_name` mediumtext NOT NULL,
  `mad_chos` mediumtext NOT NULL,
  `num_bact` int NOT NULL,
  `date_do` date NOT NULL,
  `box_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int NOT NULL,
  `pat_id` int NOT NULL,
  `fname` varchar(255) NOT NULL,
  `name_ser` varchar(20) NOT NULL,
  `cost_ser` float NOT NULL,
  `invoice_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `invoice_pharm`
--

CREATE TABLE `invoice_pharm` (
  `id` int NOT NULL,
  `typeinvoice` mediumtext NOT NULL,
  `decrip` mediumtext NOT NULL,
  `total` float NOT NULL,
  `date_invo` date NOT NULL,
  `num_rand` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `medical`
--

CREATE TABLE `medical` (
  `id` int NOT NULL,
  `pat_id` mediumtext NOT NULL,
  `fname` mediumtext NOT NULL,
  `med_name` mediumtext NOT NULL,
  `usee` mediumtext NOT NULL,
  `date_t` date NOT NULL,
  `countity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `mediciness`
--

CREATE TABLE `mediciness` (
  `id_med` int NOT NULL,
  `name_med` mediumtext NOT NULL,
  `name_chemical` mediumtext NOT NULL,
  `company` mediumtext NOT NULL,
  `delegate` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `patinte`
--

CREATE TABLE `patinte` (
  `pat_id` int NOT NULL,
  `fname` varchar(30) DEFAULT NULL,
  `age` tinyint DEFAULT NULL,
  `phone` char(9) DEFAULT NULL,
  `gander` char(1) DEFAULT NULL,
  `contry` varchar(10) DEFAULT NULL,
  `city` varchar(10) DEFAULT NULL,
  `soc_sts` varchar(10) DEFAULT NULL,
  `chel_num` tinyint DEFAULT NULL,
  `jop` varchar(10) DEFAULT NULL,
  `rig_pat` varchar(10) DEFAULT NULL,
  `date_com` datetime DEFAULT NULL,
  `user_id` varchar(20) DEFAULT NULL,
  `note_pat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `pay_bill`
--

CREATE TABLE `pay_bill` (
  `bill_id` int NOT NULL,
  `recip_name` varchar(55) NOT NULL,
  `amount` float NOT NULL,
  `bill_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `ph_admin`
--

CREATE TABLE `ph_admin` (
  `id` int NOT NULL,
  `p_name` varchar(50) NOT NULL,
  `p_pass` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `ph_buy_admin`
--

CREATE TABLE `ph_buy_admin` (
  `id` int NOT NULL,
  `b_name` varchar(50) NOT NULL,
  `b_pass` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `ph_store_admin`
--

CREATE TABLE `ph_store_admin` (
  `id` int NOT NULL,
  `s_name` varchar(50) NOT NULL,
  `s_pass` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `provider`
--

CREATE TABLE `provider` (
  `id` int NOT NULL,
  `cost_ser` float NOT NULL,
  `name_pro` varchar(70) NOT NULL,
  `note` mediumtext NOT NULL,
  `date_pro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `p_admin`
--

CREATE TABLE `p_admin` (
  `id` int NOT NULL,
  `p_name` varchar(50) NOT NULL,
  `u_pass` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `r_admin`
--

CREATE TABLE `r_admin` (
  `id` int NOT NULL,
  `r_name` varchar(55) NOT NULL,
  `u_pass` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `sale_invoice`
--

CREATE TABLE `sale_invoice` (
  `id_invoice` int NOT NULL,
  `pat_id` int NOT NULL,
  `fname` mediumtext NOT NULL,
  `medicines_name` mediumtext NOT NULL,
  `unit` int NOT NULL,
  `sale_price` float NOT NULL,
  `sale_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `session`
--

CREATE TABLE `session` (
  `pat_id` int NOT NULL,
  `date_now` date NOT NULL,
  `date_pev` date NOT NULL,
  `date_next` date NOT NULL,
  `main_com` text NOT NULL,
  `period_ill` text NOT NULL,
  `sex_hist` text NOT NULL,
  `person_hist` text NOT NULL,
  `curr_hist` text NOT NULL,
  `last_hist` text NOT NULL,
  `fam_hist` text NOT NULL,
  `work_hist` text NOT NULL,
  `basic_dig` text NOT NULL,
  `diff_dig` text NOT NULL,
  `appear` text NOT NULL,
  `behav` text NOT NULL,
  `speech` varchar(255) DEFAULT NULL,
  `mood` text NOT NULL,
  `killer` text NOT NULL,
  `thin_shep` text NOT NULL,
  `thin_con` text NOT NULL,
  `percep` text NOT NULL,
  `memory` text NOT NULL,
  `ability` text NOT NULL,
  `insight` mediumtext,
  `fores` text NOT NULL,
  `degree` tinyint NOT NULL,
  `id_session` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `tests`
--

CREATE TABLE `tests` (
  `test_id` int NOT NULL,
  `test_name` varchar(255) NOT NULL,
  `category_id` int NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `normal_range` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `test_categories`
--

CREATE TABLE `test_categories` (
  `category_id` int NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `test_psychological`
--

CREATE TABLE `test_psychological` (
  `id_Psychological` int NOT NULL,
  `pat_id` int NOT NULL,
  `name_test` varchar(50) DEFAULT NULL,
  `result` varchar(50) DEFAULT NULL,
  `notes` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `test_results`
--

CREATE TABLE `test_results` (
  `result_id` int NOT NULL,
  `pat_id` int NOT NULL,
  `test_id` int NOT NULL,
  `value` varchar(255) NOT NULL,
  `result_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_admin`
--
ALTER TABLE `blood_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_test`
--
ALTER TABLE `blood_test`
  ADD PRIMARY KEY (`id_test`),
  ADD KEY `pat_id` (`pat_id`);

--
-- Indexes for table `box_bh`
--
ALTER TABLE `box_bh`
  ADD UNIQUE KEY `box_id` (`box_id`);

--
-- Indexes for table `buy_invpice`
--
ALTER TABLE `buy_invpice`
  ADD PRIMARY KEY (`id_invoice`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `pat_id` (`pat_id`);

--
-- Indexes for table `invoice_pharm`
--
ALTER TABLE `invoice_pharm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical`
--
ALTER TABLE `medical`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mediciness`
--
ALTER TABLE `mediciness`
  ADD PRIMARY KEY (`id_med`);

--
-- Indexes for table `patinte`
--
ALTER TABLE `patinte`
  ADD PRIMARY KEY (`pat_id`);

--
-- Indexes for table `pay_bill`
--
ALTER TABLE `pay_bill`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `ph_admin`
--
ALTER TABLE `ph_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ph_buy_admin`
--
ALTER TABLE `ph_buy_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ph_store_admin`
--
ALTER TABLE `ph_store_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p_admin`
--
ALTER TABLE `p_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `r_admin`
--
ALTER TABLE `r_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_invoice`
--
ALTER TABLE `sale_invoice`
  ADD PRIMARY KEY (`id_invoice`),
  ADD KEY `pat_id` (`pat_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id_session`),
  ADD KEY `pat_id` (`pat_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`test_id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `test_categories`
--
ALTER TABLE `test_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `test_psychological`
--
ALTER TABLE `test_psychological`
  ADD PRIMARY KEY (`id_Psychological`),
  ADD KEY `pat_id` (`pat_id`);

--
-- Indexes for table `test_results`
--
ALTER TABLE `test_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `pat_id` (`pat_id`),
  ADD KEY `test_id` (`test_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blood_admin`
--
ALTER TABLE `blood_admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blood_test`
--
ALTER TABLE `blood_test`
  MODIFY `id_test` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buy_invpice`
--
ALTER TABLE `buy_invpice`
  MODIFY `id_invoice` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_pharm`
--
ALTER TABLE `invoice_pharm`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical`
--
ALTER TABLE `medical`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mediciness`
--
ALTER TABLE `mediciness`
  MODIFY `id_med` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patinte`
--
ALTER TABLE `patinte`
  MODIFY `pat_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_bill`
--
ALTER TABLE `pay_bill`
  MODIFY `bill_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ph_admin`
--
ALTER TABLE `ph_admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ph_buy_admin`
--
ALTER TABLE `ph_buy_admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ph_store_admin`
--
ALTER TABLE `ph_store_admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provider`
--
ALTER TABLE `provider`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `p_admin`
--
ALTER TABLE `p_admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `r_admin`
--
ALTER TABLE `r_admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_invoice`
--
ALTER TABLE `sale_invoice`
  MODIFY `id_invoice` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id_session` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `test_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_categories`
--
ALTER TABLE `test_categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_psychological`
--
ALTER TABLE `test_psychological`
  MODIFY `id_Psychological` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
  MODIFY `result_id` int NOT NULL AUTO_INCREMENT;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `blood_test`
--
ALTER TABLE `blood_test`
  ADD CONSTRAINT `blood_test_ibfk_1` FOREIGN KEY (`pat_id`) REFERENCES `patinte` (`pat_id`);

--
-- قيود الجداول `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`pat_id`) REFERENCES `patinte` (`pat_id`);

--
-- قيود الجداول `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`pat_id`) REFERENCES `patinte` (`pat_id`);

--
-- قيود الجداول `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `test_categories` (`category_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tests_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `test_categories` (`category_id`) ON DELETE CASCADE;

--
-- قيود الجداول `test_psychological`
--
ALTER TABLE `test_psychological`
  ADD CONSTRAINT `test_psychological_ibfk_1` FOREIGN KEY (`pat_id`) REFERENCES `patinte` (`pat_id`);

--
-- قيود الجداول `test_results`
--
ALTER TABLE `test_results`
  ADD CONSTRAINT `test_results_ibfk_1` FOREIGN KEY (`pat_id`) REFERENCES `patinte` (`pat_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_results_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `tests` (`test_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
