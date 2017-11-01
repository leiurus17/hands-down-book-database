-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 26, 2010 at 02:03 AM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `book_database`
--
CREATE DATABASE `book_database` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci;
USE `book_database`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `username` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(100) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`username`, `password`) VALUES
('hands', 'down');

-- --------------------------------------------------------

--
-- Table structure for table `book_information`
--

CREATE TABLE IF NOT EXISTS `book_information` (
  `ISBN` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Title` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Author` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Country` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Language` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Genre` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Publisher` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Publication_Date` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Pages` varchar(50) COLLATE latin1_general_ci NOT NULL,
  UNIQUE KEY `ISBN` (`ISBN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `book_information`
--

INSERT INTO `book_information` (`ISBN`, `Title`, `Author`, `Country`, `Language`, `Genre`, `Publisher`, `Publication_Date`, `Pages`) VALUES
('0-553-29698-1', 'The Diary of a Young Girl', 'Anne Frank', 'Netherlands / Holland', 'English', 'Non-Fiction / World War II', 'Bantam', '1993-07-01', '283'),
('0-425-16151-X', 'Middle Son', 'Deborah Iida', 'United States', 'English', 'Novel / Fiction', 'Berkley', '1998-01-02', '207'),
('0-345-37077-5', 'Jurassic Park', 'Michael Crichton', 'United States', 'English', 'Science Fiction', 'Ballantine', '1991-09-01', '399'),
('0-446-31078-6', 'To Kill A Mockingbird', 'Harper Lee', 'United States', 'English', 'Romance', 'Warner Books', '1982-12-01', '282'),
('0-345-40288-X', 'The Lost World', 'Michael Crichton', 'United States', 'English', 'Science Fiction', 'Balantine Book', '1996-06-01', '421'),
('0-439-08409-1', 'Real Teens: Diary of a Junior Year', 'Anonymous', 'United States', 'English', 'Non-Fiction', 'Scholastic', '1999-10-01', '175'),
('0-00-647208-7', 'The Doomsday Conspiracy', 'Sidney Sheldon', 'United States', 'English', 'Action / Suspense', 'Fontana', '1992-01-01', '445');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
