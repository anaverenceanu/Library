-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 22, 2025 at 11:21 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `document_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author_or_producer` varchar(255) DEFAULT NULL,
  `year_of_publication` year(4) DEFAULT NULL,
  `category` enum('book','film','game','cd','console') NOT NULL,
  `type` enum('children','teen','adult') NOT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`document_id`, `title`, `author_or_producer`, `year_of_publication`, `category`, `type`, `genre`, `description`, `isbn`) VALUES
(10111, 'The first document', 'Alice Break', '2022', 'book', 'teen', 'Fantasy', 'In a world where history is rewritten by the powerful, one unassuming archivist uncovers the truth that was never meant to be known. When Mia Calloway stumbles upon an ancient manuscript hidden in the depths of a crumbling library, she believes it\'s merely a relic of a forgotten time. But this isn\'t just any document—it\'s the first document: a record from humanity\'s earliest civilization, containing secrets capable of reshaping the future.\r\n\r\nAs Mia begins to decipher the document, she finds herself pursued by a shadowy organization that will stop at nothing to keep its contents buried. With the help of an enigmatic linguist and a rogue historian, she embarks on a perilous journey to uncover the truth, delving into cryptic languages, treacherous landscapes, and the darkest corners of human history.\r\n\r\nBut the closer she gets to unveiling the document’s secrets, the more she realizes the power it holds is far greater—and more dangerous—than she could have ever imagined.\r\n\r\nThe First Document is a pulse-pounding thriller that explores the fragile line between truth and myth, and how one discovery could change everything we think we know about our past—and our future.', '978-92-95055-02-5'),
(20000, 'The rock', 'Alan Walker', '1999', 'film', 'children', 'Documentary', 'In the remote expanse of the Pacific Ocean lies an island shrouded in legend and mystery. Known only as \"The Rock,\" it has been a forbidden zone for centuries, rumored to hold unimaginable riches—or unspeakable horrors.\r\n\r\nWhen an elite team of treasure hunters, led by ex-Navy SEAL Marcus Kane (played by [Lead Actor]), embarks on a daring mission to explore the island, they expect to uncover ancient artifacts and untold wealth. But what they find instead is a chilling secret that defies all logic.\r\n\r\nThe Rock harbors more than treasure—it is alive. An ancient force pulses within its jagged cliffs, twisting the minds of those who dare to trespass. As paranoia and betrayal fracture the team, Marcus must confront not only the island’s supernatural power but also his own inner demons.\r\n\r\nBlending heart-pounding action with psychological tension, The Rock is a visually stunning and deeply suspenseful film that asks: How far would you go to uncover the truth—and at what cost?', '');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `role` enum('regular','admin') NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `full_name`, `role`, `email`, `password`) VALUES
(1, 'Ana Value', 'regular', 'anavalue@gmail.com', '112233'),
(11, 'Julie Mcbroom', 'admin', 'juliemcbroom@gmail.com', '000');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `loan_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `loan_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `due_date` date NOT NULL,
  `status` enum('active','returned','late') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`loan_id`, `member_id`, `document_id`, `loan_date`, `return_date`, `due_date`, `status`) VALUES
(1, 1, 20000, '2025-01-15', '2025-02-16', '2025-01-15', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `full_name`, `address`, `phone`, `email`, `password`) VALUES
(1, 'John Doe', '198 5th avenue, New York, USA', '1112223333', 'johndoe@outlook.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `request_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `request_date` date NOT NULL,
  `status` enum('pending','accepted','canceled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`request_id`, `member_id`, `document_id`, `request_date`, `status`) VALUES
(1, 1, 10111, '2025-01-08', 'pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`loan_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `document_id` (`document_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `document_id` (`document_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20001;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`),
  ADD CONSTRAINT `loans_ibfk_2` FOREIGN KEY (`document_id`) REFERENCES `documents` (`document_id`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`document_id`) REFERENCES `documents` (`document_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
