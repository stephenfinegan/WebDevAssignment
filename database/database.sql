-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 02, 2016 at 03:02 PM
-- Server version: 10.1.9-MariaDB-log
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment1_cvs`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `studentID` text NOT NULL,
  `jobID` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `studentID`, `jobID`) VALUES
(16, 'student', '6');

-- --------------------------------------------------------

--
-- Table structure for table `cvs`
--

CREATE TABLE `cvs` (
  `id` int(11) NOT NULL,
  `firstname` text NOT NULL,
  `surname` text NOT NULL,
  `email` text NOT NULL,
  `number` int(11) NOT NULL,
  `picture` text NOT NULL,
  `address` text NOT NULL,
  `town` text NOT NULL,
  `previousJobs` text NOT NULL,
  `qualifications` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cvs`
--

INSERT INTO `cvs` (`id`, `firstname`, `surname`, `email`, `number`, `picture`, `address`, `town`, `previousJobs`, `qualifications`) VALUES
(3, 'stephen', 'finegan', 'stephen@gmail.com', 871234567, 'itbLogo.gif', '10 street', 'dublin', 'imb, microsoft', 'programming and troubleshooting'),
(4, 'dale', 'flynn', 'testAgain@gmail.com', 56789033, 'gremlin.png', '1 street', 'ballymun', 'spar', 'maths, science');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `company` text NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `deadline` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `accepted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `username`, `company`, `title`, `description`, `deadline`, `accepted`) VALUES
(6, 'employer', 'IBM', 'Programmer', 'Looking for experience programmer to work full time with us', '2016-05-02 09:44:15', 1),
(13, 'employer', 'Microsoft', 'Developer', 'Develop with us and get paid', '2016-05-02 09:47:23', 1),
(18, 'employer', 'Grew constructions', 'Helper', 'dtyfvubinol;', '2016-05-02 09:51:50', 1),
(23, 'employer', 'Fairways Plumbing', 'Plumber', 'Plum the plum of plumbing', '2016-05-02 13:16:00', 1),
(24, 'employer', 'Microsoft', 'Programmer', 'ertyui', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `samplecvs`
--

CREATE TABLE `samplecvs` (
  `id` int(11) NOT NULL,
  `firstname` text NOT NULL,
  `surname` text NOT NULL,
  `email` text NOT NULL,
  `number` int(11) NOT NULL,
  `picture` text NOT NULL,
  `address` text NOT NULL,
  `town` text NOT NULL,
  `previousJobs` text NOT NULL,
  `qualifications` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `samplecvs`
--

INSERT INTO `samplecvs` (`id`, `firstname`, `surname`, `email`, `number`, `picture`, `address`, `town`, `previousJobs`, `qualifications`) VALUES
(1, 'stephen', 'finegan', 'test@gmail.com', 871234567, 'image.jpg', '10 road', 'finglas', 'programmer for itb', 'programming, maths, science');

-- --------------------------------------------------------

--
-- Table structure for table `test_assignment`
--

CREATE TABLE `test_assignment` (
  `id` int(11) NOT NULL,
  `firstname` text NOT NULL,
  `surname` text NOT NULL,
  `email` text NOT NULL,
  `number` int(11) NOT NULL,
  `picture` text NOT NULL,
  `address` text NOT NULL,
  `town` text NOT NULL,
  `previousJobs` text NOT NULL,
  `qualifications` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test_assignment`
--

INSERT INTO `test_assignment` (`id`, `firstname`, `surname`, `email`, `number`, `picture`, `address`, `town`, `previousJobs`, `qualifications`) VALUES
(1, 'stephen', 'finegan', 'finegan@gmail.com', 12345, 'finegan.jpg', '10 fairways', 'finglas', 'spar', 'programmer');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` text NOT NULL,
  `surname` text NOT NULL,
  `username` text NOT NULL,
  `hashedPassword` text NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `surname`, `username`, `hashedPassword`, `position`) VALUES
(10, 'stephen', 'finegan', 'student', '$2y$10$sN/l5DIwWMABpqbLwbjGvelebsQ.yMJwlCwvs7qlBmsYm7dn04g0S', 1),
(11, 'dale', 'flynn', 'lecturer', '$2y$10$Fmf707IHnaqnE5k0hgn67OSzOfk3WHNZ1Apa0L.pGTVBrLkMLlXGK', 2),
(12, 'john', 'parkes', 'employer', '$2y$10$Bzw/CV.O2AonTKUfoXBrf.itgGAxTy0NgLSTWAtVX4w2hAgy4v8ci', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cvs`
--
ALTER TABLE `cvs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `samplecvs`
--
ALTER TABLE `samplecvs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_assignment`
--
ALTER TABLE `test_assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `cvs`
--
ALTER TABLE `cvs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `samplecvs`
--
ALTER TABLE `samplecvs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `test_assignment`
--
ALTER TABLE `test_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
