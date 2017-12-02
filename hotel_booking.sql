-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 28, 2017 at 04:25 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE IF NOT EXISTS `booking` (
  `Bok_id` int(11) NOT NULL,
  `Bok_date_in` date NOT NULL,
  `Bok_date_out` date NOT NULL,
  `Bok_made_by` varchar(20) NOT NULL,
  `Bok_guest_id` int(11) NOT NULL,
  `Bok_number_of_nights` int(11) NOT NULL,
  `Bok_Booking_date` date NOT NULL,
  `Bok_room_id` int(11) NOT NULL,
  PRIMARY KEY (`Bok_id`),
  KEY `Bok_guest_id` (`Bok_guest_id`),
  KEY `Bok_room_id` (`Bok_room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `booking`
--

TRUNCATE TABLE `booking`;
-- --------------------------------------------------------

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE IF NOT EXISTS `city` (
  `Cty_id` int(11) NOT NULL,
  `Cty_Name` varchar(100) NOT NULL,
  `Cty_province_id` int(11) NOT NULL,
  PRIMARY KEY (`Cty_id`),
  KEY `Cty_province_id` (`Cty_province_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `city`
--

TRUNCATE TABLE `city`;
--
-- Dumping data for table `city`
--

INSERT INTO `city` (`Cty_id`, `Cty_Name`, `Cty_province_id`) VALUES
(100, 'Toronto', 1),
(101, 'Niagara', 1),
(102, 'Oshawa', 1),
(103, 'Ottawa', 1),
(104, 'Hamilton', 1),
(200, 'Montreal', 2),
(201, 'Quebic City', 2),
(202, 'Mont-Laurier?', 2),
(300, 'Halifax', 3),
(301, 'Cape Breton', 3);

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

DROP TABLE IF EXISTS `guest`;
CREATE TABLE IF NOT EXISTS `guest` (
  `Gst_id` int NOT NULL AUTO_INCREMENT,
  `Gst_first_name` varchar(80) NOT NULL,
  `Gst_last_name` varchar(80) NOT NULL,
  `Gst_member_since` date NOT NULL,
  `Gst_username` text NOT NULL,
  `Gst_password` text NOT NULL,
  `Gst_email` text NOT NULL,
  PRIMARY KEY (`Gst_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `guest`
--

TRUNCATE TABLE `guest`;
-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

DROP TABLE IF EXISTS `hotel`;
CREATE TABLE IF NOT EXISTS `hotel` (
  `Htl_id` int(11) NOT NULL,
  `Htl_name` varchar(80) NOT NULL,
  `Htl_Rate` int(11) NOT NULL,
  `Htl_city_id` int(11) NOT NULL,
  `Htl_province_id` int(11) NOT NULL,
  `Htl_address` varchar(200) NOT NULL,
  `Htl_postalCode` varchar(10) NOT NULL,
  PRIMARY KEY (`Htl_id`),
  KEY `Htl_city_id` (`Htl_city_id`,`Htl_province_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `hotel`
--

TRUNCATE TABLE `hotel`;
--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`Htl_id`, `Htl_name`, `Htl_Rate`, `Htl_city_id`, `Htl_province_id`, `Htl_address`, `Htl_postalCode`) VALUES
(1, 'ABC Hotel', 5, 100, 1, '100 king street W', 'L1G3S2'),
(2, 'Ramada Hotel', 4, 100, 1, '200 king street W', 'L1G3S3'),
(3, 'FourSeasons Hotel', 5, 100, 1, '421 king street W', 'L1G3S4'),
(4, 'knights Inn', 3, 100, 1, '698 king street W', 'L1G3S5'),
(5, 'Confort Inn', 3, 102, 1, '150 king street W', 'L1G3S6'),
(6, 'La Quinta Inn', 3, 102, 1, '300 king street W', 'L1G3S7'),
(7, 'Best Western', 2, 102, 1, '102 king street W', 'L1G3S8');

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

DROP TABLE IF EXISTS `pictures`;
CREATE TABLE IF NOT EXISTS `pictures` (
  `image_id` int(10) NOT NULL,
  `hotel_id` int(10) NOT NULL,
  `image` blob NOT NULL,
  PRIMARY KEY (`image_id`,`hotel_id`),
  KEY `hotel_id` (`hotel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `pictures`
--

TRUNCATE TABLE `pictures`;
--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`image_id`, `hotel_id`, `image`) VALUES
(1, 1, 0x433a5c696d616765735c312e6a7067),
(2, 2, 0x633a5c696d616765735c322e6a7067),
(3, 3, 0x633a5c696d616765735c332e6a7067),
(4, 4, 0x633a5c696d616765735c342e6a7067),
(5, 5, 0x633a5c696d616765735c352e6a7067),
(6, 6, 0x633a5c696d616765735c362e6a7067),
(7, 7, 0x633a5c696d616765735c372e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

DROP TABLE IF EXISTS `province`;
CREATE TABLE IF NOT EXISTS `province` (
  `Prv_id` int(11) NOT NULL,
  `Prv_Name` varchar(100) NOT NULL,
  PRIMARY KEY (`Prv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `province`
--

TRUNCATE TABLE `province`;
--
-- Dumping data for table `province`
--

INSERT INTO `province` (`Prv_id`, `Prv_Name`) VALUES
(1, 'Ontario'),
(2, 'Quebic'),
(3, 'Nova Scotia'),
(4, 'New Brunswick'),
(5, 'Manitoba'),
(6, 'Prince Edward Island'),
(7, 'Saskatchewan'),
(8, 'Alberta'),
(9, 'Newfoundland and Labrador');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
CREATE TABLE IF NOT EXISTS `room` (
  `Rm_id` int(11) NOT NULL,
  `Rm_number` varchar(10) NOT NULL,
  `Rm_name` varchar(40) NOT NULL,
  `Rm_status` varchar(10) NOT NULL,
  `Rm_smoke` tinyint(1) NOT NULL,
  `Rm_max_Capacity` int(11) NOT NULL,
  `Rm_price` decimal(4,0) NOT NULL,
  `Rm_Hotel_id` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `Rm_number_beds` int(11) NOT NULL,
  `Rm_price_weekend` decimal(6,2) NOT NULL,
  `Rm_free_barking` tinyint(1) NOT NULL,
  `Rm_free_breakfast` tinyint(1) NOT NULL,
  `Rm_free_internet` tinyint(1) NOT NULL,
  PRIMARY KEY (`Rm_id`),
  KEY `room_type_id` (`room_type_id`) USING BTREE,
  KEY `Rm_Hotel_id` (`Rm_Hotel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `room`
--

TRUNCATE TABLE `room`;
--
-- Dumping data for table `room`
--

INSERT INTO `room` (`Rm_id`, `Rm_number`, `Rm_name`, `Rm_status`, `Rm_smoke`, `Rm_max_Capacity`, `Rm_price`, `Rm_Hotel_id`, `room_type_id`, `Rm_number_beds`, `Rm_price_weekend`, `Rm_free_barking`, `Rm_free_breakfast`, `Rm_free_internet`) VALUES
(1, '101', 'Room1', '0', 0, 5, '100', 5, 1, 2, '120.00', 1, 1, 1),
(2, '102', 'Room2', '0', 0, 5, '120', 5, 2, 2, '140.00', 1, 1, 1),
(3, '103', 'Room3', '0', 0, 5, '140', 5, 3, 2, '180.00', 1, 1, 1),
(4, '104', 'Room4', '0', 0, 5, '200', 5, 4, 2, '250.00', 1, 1, 1),
(100, '101', 'Room1', '0', 0, 5, '90', 6, 1, 2, '120.00', 1, 1, 1),
(101, '102', 'Room2', '0', 0, 5, '115', 6, 2, 2, '140.00', 1, 1, 1),
(102, '103', 'Room3', '0', 0, 5, '145', 6, 3, 2, '180.00', 1, 1, 1),
(103, '104', 'Room4', '0', 0, 5, '210', 6, 4, 2, '250.00', 1, 1, 1),
(200, '101', 'Room1', '0', 0, 5, '65', 7, 1, 2, '120.00', 1, 1, 1),
(201, '102', 'Room2', '0', 0, 5, '100', 7, 2, 2, '140.00', 1, 1, 1),
(202, '103', 'Room3', '0', 0, 5, '110', 7, 3, 2, '180.00', 1, 1, 1),
(203, '104', 'Room4', '0', 0, 5, '150', 7, 4, 2, '250.00', 1, 1, 1),
(300, '101', 'Room1', '0', 0, 5, '300', 2, 1, 2, '350.00', 1, 1, 1),
(301, '102', 'Room2', '0', 0, 5, '400', 2, 2, 2, '450.00', 1, 1, 1),
(302, '103', 'Room3', '0', 0, 5, '450', 2, 3, 2, '550.00', 1, 1, 1),
(303, '104', 'Room4', '0', 0, 5, '700', 2, 4, 2, '950.00', 1, 1, 1),
(400, '101', 'Room1', '0', 0, 5, '300', 3, 1, 2, '450.00', 1, 1, 1),
(401, '102', 'Room2', '0', 0, 5, '500', 3, 2, 2, '650.00', 1, 1, 1),
(402, '103', 'Room3', '0', 0, 5, '650', 3, 3, 2, '750.00', 1, 1, 1),
(403, '104', 'Room4', '0', 0, 5, '800', 3, 4, 2, '1050.00', 1, 1, 1),
(500, '101', 'Room1', '0', 1, 5, '100', 4, 1, 2, '120.00', 1, 1, 1),
(501, '102', 'Room2', '0', 1, 5, '120', 4, 2, 2, '140.00', 1, 1, 1),
(502, '103', 'Room3', '0', 0, 5, '160', 4, 3, 2, '200.00', 1, 1, 1),
(503, '104', 'Room4', '0', 0, 5, '200', 4, 4, 2, '250.00', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `room_type`
--

DROP TABLE IF EXISTS `room_type`;
CREATE TABLE IF NOT EXISTS `room_type` (
  `Typ_id` int(11) NOT NULL,
  `Typ_description` varchar(80) NOT NULL,
  PRIMARY KEY (`Typ_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `room_type`
--

TRUNCATE TABLE `room_type`;
--
-- Dumping data for table `room_type`
--

INSERT INTO `room_type` (`Typ_id`, `Typ_description`) VALUES
(1, 'Single'),
(2, 'Double'),
(3, 'Suite'),
(4, 'Executive');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`Bok_room_id`) REFERENCES `room` (`Rm_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`Cty_province_id`) REFERENCES `province` (`Prv_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hotel`
--
ALTER TABLE `hotel`
  ADD CONSTRAINT `hotel_ibfk_1` FOREIGN KEY (`Htl_city_id`) REFERENCES `city` (`Cty_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pictures`
--
ALTER TABLE `pictures`
  ADD CONSTRAINT `pictures_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotel` (`Htl_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`room_type_id`) REFERENCES `room_type` (`Typ_id`),
  ADD CONSTRAINT `room_ibfk_2` FOREIGN KEY (`Rm_Hotel_id`) REFERENCES `hotel` (`Htl_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
