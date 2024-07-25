-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2024 at 11:00 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sakoplogin`
--

-- --------------------------------------------------------

--
-- Table structure for table `budget_info`
--

CREATE TABLE `budget_info` (
  `id` int(11) NOT NULL,
  `sk_chairman_id` int(11) DEFAULT NULL,
  `remaining_budget` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget_info`
--

INSERT INTO `budget_info` (`id`, `sk_chairman_id`, `remaining_budget`, `created_at`, `updated_at`) VALUES
(1, 20, '345000.00', '2024-07-18 19:13:07', '2024-07-18 19:13:30'),
(2, 21, '240000.00', '2024-07-18 18:36:13', '2024-07-19 08:38:57'),
(3, 22, '210000.00', '2024-07-19 07:45:11', '2024-07-19 07:45:11'),
(4, 23, '1233.00', '2024-07-19 08:40:52', '2024-07-19 08:52:35'),
(5, 27, '123.00', '2024-07-19 08:54:14', '2024-07-19 08:54:59'),
(7, 24, '12000.00', '2024-07-19 08:57:53', '2024-07-19 08:58:19'),
(8, 25, '30000.00', '2024-07-19 08:58:55', '2024-07-19 08:58:55');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `filename`, `file_path`, `upload_date`) VALUES
(1, 'blue-and-white-layout-e-sport-t-shirt-design-vector-21609832.jpg', 'C:/xampp2/htdocs/SaKOP/documents/blue-and-white-layout-e-sport-t-shirt-design-vector-21609832.jpg', '2024-07-16 07:03:39'),
(2, '35df4c0f2fb6a6ac8783c27b239b22be.jpg', 'C:/xampp2/htdocs/SaKOP/documents/35df4c0f2fb6a6ac8783c27b239b22be.jpg', '2024-07-16 07:36:21'),
(3, '382246586_1457127951809019_6896373447486894323_n.jpg', 'C:/xampp2/htdocs/SaKOP/documents/382246586_1457127951809019_6896373447486894323_n.jpg', '2024-07-16 07:36:53'),
(4, 'sample.jpg', 'C:/xampp2/htdocs/SaKOP/documents/sample.jpg', '2024-07-16 07:41:16'),
(5, 'samplejersey.png', 'C:/xampp2/htdocs/SaKOP/documents/samplejersey.png', '2024-07-16 07:41:58'),
(6, 'magie.png', 'C:/xampp2/htdocs/SaKOP/documents/magie.png', '2024-07-16 08:16:46'),
(7, 'test.jpg', 'C:/xampp2/htdocs/SaKOP/documents/test.jpg', '2024-07-16 08:39:28'),
(8, 'basta.docx', 'C:/xampp2/htdocs/SaKOP/documents/basta.docx', '2024-07-16 13:43:35'),
(9, 'Nasugbu Logo.png', 'C:/xampp2/htdocs/SaKOP/documents/Nasugbu Logo.png', '2024-07-17 08:12:29'),
(10, 'basta.jpeg', 'C:/xampp2/htdocs/SaKOP/documents/basta.jpeg', '2024-07-18 21:01:51'),
(11, 'basta.jpeg', 'C:/xampp2/htdocs/SaKOP/documents/basta.jpeg', '2024-07-18 21:04:42'),
(12, 'basta.jpeg', 'C:/xampp2/htdocs/SaKOP/documents/basta.jpeg', '2024-07-18 21:05:53'),
(13, 'samplejersey.png', 'C:/xampp2/htdocs/SaKOP/documents/samplejersey.png', '2024-07-18 21:09:30'),
(14, 'test.jpg', 'C:/xampp2/htdocs/SaKOP/documents/test.jpg', '2024-07-18 21:10:18'),
(15, 'try.jpg', 'C:/xampp2/htdocs/SaKOP/documents/try.jpg', '2024-07-19 05:19:23');

-- --------------------------------------------------------

--
-- Table structure for table `kk_members`
--

CREATE TABLE `kk_members` (
  `member_id` int(11) NOT NULL,
  `sk_chairman_id` int(11) DEFAULT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `birthday` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `barangay` varchar(100) DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kk_members`
--

INSERT INTO `kk_members` (`member_id`, `sk_chairman_id`, `firstname`, `middlename`, `lastname`, `birthday`, `address`, `barangay`, `contact_number`, `email`, `age`) VALUES
(1, 20, 'Karlo Mateo', 'Cruz', 'Mendoza', '2024-07-16', 'Carretunan, Calatagan, Batangas', 'Balok-Balok', '09057391591', 'karlomendoza22@gmail.com', 0),
(2, 20, 'Karlo Mateo', 'Cruz', 'Mendoza', '2024-07-12', 'Carretunan, Calatagan, Batangas', 'Balok-Balok', '09057391591', 'karlomendoza22@gmail.com', 0),
(3, 20, 'Maloi', 'Yves', 'Ricalde', '2016-02-18', '789 Oak Ave, Villagetown', 'Balok-Balok', '5551234567', 'maloi.ricalde@example.com', 8),
(4, 21, 'Sean Leoj', 'Ilao', 'Amorante', '2009-02-18', 'Nasugbu, Batangas', 'Banilad', '0966530679', 'sean@amorante', 15);

-- --------------------------------------------------------

--
-- Table structure for table `skchairman`
--

CREATE TABLE `skchairman` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `age` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `marital_status` varchar(50) DEFAULT NULL,
  `barangay` varchar(255) NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skchairman`
--

INSERT INTO `skchairman` (`id`, `firstname`, `middlename`, `lastname`, `birthday`, `age`, `address`, `marital_status`, `barangay`, `contact_number`, `email`, `password`) VALUES
(18, 'John', 'Michael', 'Smith', '1997-06-12', 27, 'Aga, Nasugbu, Batangas', 'Single', 'Aga', '09123456789', 'johnsmith@gmail.com', '$2y$10$oly1u3c5/5QK4b56Ltt2UOx9CUxyvxvwsciLBUBAfNr1GWnrSZ1q.'),
(19, 'Mariane', 'Theresa', 'Rodriguez', '1992-07-29', 31, 'Balaytigue, Nasugbu, Batangas', 'Married', 'Balaytigue', '09234567890', 'mariarodriguez@gmail.com', '$2y$10$bqktZRrMul9ovqv4MEtA9.FJEBZ8O.4Fhk/fKXKi7TNerC5irXzF6'),
(20, 'Mark', 'Anthony', 'Garcia', '1990-11-05', 33, 'Balok-Balok, Nasugbu, Batangas', 'Single', 'Balok-Balok', '09345678901', 'markgarcia@gmail.com', 'Mark'),
(21, 'Sarah', 'Jane', 'Lopez', '1991-09-18', 32, 'Banilad, Nasugbu, Batangas', 'Single', 'Banilad', '09456789012', 'sarahlopez@gmail.com', 'Sarah'),
(22, 'James', 'Patrick', 'Martinez', '1993-03-27', 31, 'Barangay 1, Nasugbu, Batangas', 'Married', 'Barangay 1', '09567890123', 'jamesmartinez@gmail.com', 'James'),
(23, 'Emily', 'Anne', 'Gonzales', '1990-08-09', 33, 'Barangay 2, Nasugbu, Batangas', 'Single', 'Barangay 2', '09678901234', 'emilygonzales@gmail.com', 'Emily'),
(24, 'Michael', 'David', 'Reyes', '1992-05-14', 32, 'Barangay 3, Nasugbu, Batangas', 'Married', 'Barangay 3', '09789012345', 'michaelreyes@gmail.com', 'Michael'),
(25, 'Jessica', 'Marie', 'Fernandez', '1991-07-07', 33, 'Barangay 4, Nasugbu, Batangas', 'Single', 'Barangay 4', '09890123456', 'jessicafernandez@gmail.com', 'Jessica'),
(26, 'Daniel', 'Joseph', 'Morales', '1990-10-23', 33, 'Barangay 5, Nasugbu, Batangas', 'Single', 'Barangay 5', '09901234567', 'danielmorales@gmail.com', 'Daniel'),
(27, 'Sophia', 'Grace', 'Cruz', '1993-06-30', 31, 'Barangay 6, Nasugbu, Batangas', 'Married', 'Barangay 6', '09102345678', 'sophiacruz@gmail.com', 'Sophia'),
(28, 'Ethan', 'Alexander', 'Ramirez', '1991-04-01', 33, 'Barangay 7, Nasugbu, Batangas', 'Single', 'Barangay 7', '09213456789', 'ethanramirez@gmail.com', 'Ethan'),
(29, 'Olivia', 'Nicole', 'Torres', '1990-08-17', 33, 'Barangay 8, Nasugbu, Batangas', 'Single', 'Barangay 8', '09324567890', 'oliviatorres@gmail.com', 'Olivia'),
(30, 'Noah', 'Benjamin', 'Flores', '1992-09-12', 31, 'Barangay 9, Nasugbu, Batangas', 'Married', 'Barangay 9', '09435678901', 'noahflores@gmail.com', 'Noah'),
(31, 'Isabella', 'Rose', 'Rivera', '1991-11-03', 32, 'Barangay 10, Nasugbu, Batangas', 'Single', 'Barangay 10', '09546789012', 'isabellarivera@gmail.com', 'Isabella'),
(32, 'Liam', 'Matthew', 'Santiago', '1990-05-26', 34, 'Barangay 11, Nasugbu, Batangas', 'Single', 'Barangay 11', '09657890123', 'liamsantiago@gmail.com', 'Liam'),
(33, 'Amelia', 'Elizabeth', 'Cruz', '1993-03-19', 31, 'Barangay 12, Nasugbu, Batangas', 'Married', 'Barangay 12', '09768901234', 'ameliacruz@gmail.com', 'Amelia'),
(34, 'Lucas', 'Jonathan', 'Alvarez', '1991-07-22', 32, 'Bilaran, Nasugbu, Batangas', 'Single', 'Bilaran', '09879012345', 'lucasalvarez@gmail.com', 'Lucas'),
(35, 'Aiden', 'Thomas', 'Romero', '1990-09-05', 33, 'Bucana, Nasugbu, Batangas', 'Single', 'Bucana', '09990123456', 'aidenromero@gmail.com', 'Aiden'),
(36, 'Mia', 'Harper', 'Gomez', '1992-08-13', 31, 'Bulihan, Nasugbu, Batangas', 'Married', 'Bulihan', '09101234567', 'miagomez@gmail.com', 'Mia'),
(37, 'Harper', 'Evelyn', 'Perez', '1991-06-16', 33, 'Bunducan, Nasugbu, Batangas', 'Single', 'Bunducan', '09212345678', 'harperperez@gmail.com', 'Harper'),
(38, 'Sebastian', 'Leo', 'Hernandez', '1990-04-09', 34, 'Butucan, Nasugbu, Batangas', 'Single', 'Butucan', '09323456789', 'sebastianhernandez@gmail.com', 'Sebastian'),
(39, 'Evelyn', 'Claire', 'Flores', '1993-10-28', 30, 'Calayo, Nasugbu, Batangas', 'Married', 'Calayo', '09434567890', 'evelynflores@gmail.com', 'Evelyn'),
(40, 'Riley', 'Hazel', 'Torres', '1991-11-15', 32, 'Catandaan, Nasugbu, Batangas', 'Single', 'Catandaan', '09545678901', 'rileyltorres@gmail.com', 'Riley'),
(41, 'Benjamin', 'Jack', 'Santos', '1990-05-08', 34, 'Kaylaway, Nasugbu, Batangas', 'Single', 'Kaylaway', '09656789012', 'benjaminsantos@gmail.com', 'Benjamin'),
(42, 'Zoe', 'Scarlett', 'Reyes', '1992-03-01', 32, 'Kayrilaw, Nasugbu, Batangas', 'Married', 'Kayrilaw', '09767890123', 'zoereyes@gmail.com', 'Zoe'),
(43, 'Henry', 'Andrew', 'Garcia', '1990-08-26', 33, 'Cogunan, Nasugbu, Batangas', 'Single', 'Cogunan', '09878901234', 'henrygarcia@gmail.com', 'Henry'),
(44, 'Scarlett', 'Nova', 'Martinez', '1993-09-17', 30, 'Dayap, Nasugbu, Batangas', 'Single', 'Dayap', '09989012345', 'scarlettmartinez@gmail.com', 'Scarlett'),
(45, 'Jackson', 'Wyatt', 'Lopez', '1991-04-04', 33, 'Latag, Nasugbu, Batangas', 'Married', 'Latag', '09190123456', 'jacksonlopez@gmail.com', 'Jackson'),
(46, 'Aria', 'Lily', 'Fernandez', '1990-12-29', 33, 'Looc, Nasugbu, Batangas', 'Single', 'Looc', '09201234567', 'ariafernandez@gmail.com', 'Aria'),
(47, 'David', 'Gabriel', 'Rivera', '1993-02-11', 31, 'Malapad Na Bato, Nasugbu, Batangas', 'Single', 'Malapad Na Bato', '09312345678', 'davidrivera@gmail.com', 'David'),
(48, 'Victoria', 'Madison', 'Santiago', '1991-10-24', 32, 'Mataas Na Pulo, Nasugbu, Batangas', 'Married', 'Mataas Na Pulo', '09423456789', 'victoriasantiago@gmail.com', 'Victoria'),
(49, 'Leo', 'Dylan', 'Gomez', '1992-08-08', 31, 'Maugat, Nasugbu, Batangas', 'Single', 'Maugat', '09534567890', 'leogomez@gmail.com', 'Leo'),
(50, 'Paisley', 'Charlie', 'Hernandez', '1991-06-11', 33, 'Munting Indang, Nasugbu, Batangas', 'Married', 'Munting Indang', '09645678901', 'paisleyhernandez@gmail.com', 'Paisley'),
(51, 'Ellie', 'Quinn', 'Flores', '1990-04-04', 34, 'Natipuan, Nasugbu, Batangas', 'Single', 'Natipuan', '09756789012', 'ellieflores@gmail.com', 'Ellie'),
(52, 'Reagan', 'Wesley', 'Morales', '1990-08-25', 33, 'Pantalan, Nasugbu, Batangas', 'Single', 'Pantalan', '09978901234', 'reaganmorales@gmail.com', 'Reagan'),
(53, 'Finley', 'Cameron', 'Perez', '1992-05-08', 32, 'Papaya, Nasugbu, Batangas', 'Married', 'Papaya', '09189012345', 'finleyperez@gmail.com', 'Finley'),
(54, 'Elliott', 'River', 'Rivera', '1993-09-22', 30, 'Putat, Nasugbu, Batangas', 'Single', 'Putat', '09290123456', 'elliottrivera@gmail.com', 'Elliott'),
(55, 'Parker', 'Carter', 'Alvarez', '1992-06-30', 32, 'Reparo, Nasugbu, Batangas', 'Married', 'Reparo', '09301234567', 'parkeralvarez@gmail.com', 'Parker'),
(56, 'Brooklyn', 'Emerson', 'Romero', '1990-04-12', 34, 'Talangan, Nasugbu, Batangas', 'Single', 'Talangan', '09412345678', 'brooklynromero@gmail.com', 'Brooklyn'),
(57, 'Mackenzie', 'Harley', 'Gomez', '1991-11-25', 32, 'Tumalim, Nasugbu, Batangas', 'Married', 'Tumalim', '09523456789', 'mackenziegomez@gmail.com', 'Mackenzie'),
(58, 'Charlie', 'Avery', 'Hernandez', '1990-12-08', 33, 'Utod, Nasugbu, Batangas', 'Single', 'Utod', '09634567890', 'charliehernandez@gmail.com', 'Charlie'),
(59, 'Sawyer', 'Finley', 'Flores', '1993-10-11', 30, 'Wawa, Nasugbu, Batangas', 'Married', 'Wawa', '09745678901', 'sawyerflores@gmail.com', 'Sawyer');

-- --------------------------------------------------------

--
-- Table structure for table `sk_documents`
--

CREATE TABLE `sk_documents` (
  `id` int(11) NOT NULL,
  `sk_chairman_id` int(11) NOT NULL,
  `skfilename` varchar(255) NOT NULL,
  `skfilepath` varchar(255) NOT NULL,
  `uploadfiledate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sk_documents`
--

INSERT INTO `sk_documents` (`id`, `sk_chairman_id`, `skfilename`, `skfilepath`, `uploadfiledate`) VALUES
(1, 20, 'sample.png', 'C:/xampp2/htdocs/SaKOP/documents/sample.png', '2024-07-18 23:07:40'),
(2, 20, 'test.jpeg', 'C:/xampp2/htdocs/SaKOP/documents/test.jpeg', '2024-07-18 23:10:57'),
(3, 20, 'test.png', 'C:/xampp2/htdocs/SaKOP/documents/test.png', '2024-07-19 07:05:25'),
(4, 20, 'newtest.png', 'C:/xampp2/htdocs/SaKOP/documents/newtest.png', '2024-07-19 13:07:20');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `sk_chairman_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `receipt_path` varchar(255) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `sk_chairman_id`, `amount`, `description`, `receipt_path`, `date`) VALUES
(3, 21, '200.00', 'Volleyball', 'C:/xampp2/htdocs/SaKOP/receipts/Red & Black Modern Online Course Certificate Landscape (3).png', '2024-07-18'),
(5, 20, '5000.00', 'Jersey', 'C:/xampp2/htdocs/SaKOP/receipts/449225258_451861104412826_4677127047987721135_n-removebg-preview.png', '2024-07-18'),
(6, 21, '200.00', 'Solicit', 'C:/xampp2/htdocs/SaKOP/receipts/f4b964f3-7569-4a04-b1d2-de809e88e975.jpeg', '2024-07-19');

-- --------------------------------------------------------

--
-- Table structure for table `transactions_history`
--

CREATE TABLE `transactions_history` (
  `id` int(11) NOT NULL,
  `sk_chairman_id` int(11) DEFAULT NULL,
  `type` enum('add','edit','transaction') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions_history`
--

INSERT INTO `transactions_history` (`id`, `sk_chairman_id`, `type`, `amount`, `description`, `date`) VALUES
(1, 21, 'add', '200000.00', 'Budget updated', '2024-07-19 02:16:26'),
(2, 21, 'add', '250000.00', 'Budget updated', '2024-07-19 02:37:02'),
(3, 21, 'add', '240000.00', 'Budget updated', '2024-07-19 02:38:57'),
(4, NULL, 'add', '0.00', 'Budget updated', '2024-07-19 02:46:19'),
(5, 23, 'add', '123.00', 'Budget updated', '2024-07-19 02:46:40'),
(6, 23, 'add', '1233.00', 'Budget updated', '2024-07-19 08:52:35'),
(7, 27, 'add', '123.00', 'Budget updated', '2024-07-19 08:54:59'),
(8, 24, 'edit', '12000.00', 'Budget Added', '2024-07-19 08:57:53'),
(9, 24, 'add', '123.00', 'Budget updated', '2024-07-19 08:58:02'),
(10, 24, 'add', '12000.00', 'Budget updated', '2024-07-19 08:58:19'),
(11, 25, 'edit', '30000.00', 'Budget Added', '2024-07-19 08:58:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', 'pass');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budget_info`
--
ALTER TABLE `budget_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sk_chairman_id` (`sk_chairman_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_members`
--
ALTER TABLE `kk_members`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `sk_chairman_id` (`sk_chairman_id`);

--
-- Indexes for table `skchairman`
--
ALTER TABLE `skchairman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sk_documents`
--
ALTER TABLE `sk_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sk_chairman_id` (`sk_chairman_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sk_chairman_id` (`sk_chairman_id`);

--
-- Indexes for table `transactions_history`
--
ALTER TABLE `transactions_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sk_chairman_id` (`sk_chairman_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budget_info`
--
ALTER TABLE `budget_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `kk_members`
--
ALTER TABLE `kk_members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `skchairman`
--
ALTER TABLE `skchairman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `sk_documents`
--
ALTER TABLE `sk_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transactions_history`
--
ALTER TABLE `transactions_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budget_info`
--
ALTER TABLE `budget_info`
  ADD CONSTRAINT `budget_info_ibfk_1` FOREIGN KEY (`sk_chairman_id`) REFERENCES `skchairman` (`id`);

--
-- Constraints for table `kk_members`
--
ALTER TABLE `kk_members`
  ADD CONSTRAINT `kk_members_ibfk_1` FOREIGN KEY (`sk_chairman_id`) REFERENCES `skchairman` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sk_documents`
--
ALTER TABLE `sk_documents`
  ADD CONSTRAINT `sk_documents_ibfk_1` FOREIGN KEY (`sk_chairman_id`) REFERENCES `skchairman` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`sk_chairman_id`) REFERENCES `skchairman` (`id`);

--
-- Constraints for table `transactions_history`
--
ALTER TABLE `transactions_history`
  ADD CONSTRAINT `transactions_history_ibfk_1` FOREIGN KEY (`sk_chairman_id`) REFERENCES `skchairman` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
