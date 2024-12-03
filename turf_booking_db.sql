-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 07:02 AM
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
-- Database: `turf_booking_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `turf_name` varchar(100) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `booking_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `turfs`
--

CREATE TABLE `turfs` (
  `turf_id` int(11) NOT NULL,
  `turf_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(150) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('available','booked') NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `turfs`
--

INSERT INTO `turfs` (`turf_id`, `turf_name`, `description`, `location`, `image`, `price`, `status`) VALUES
(1, 'Sparta Arena', 'Sparta Arena hosts a lot of semi-professional games. It also has cricket and beach volleyball facilities in the complex.', 'Oruvathilkotta, Thiruvananthapuram', 'assets\\images\\turf-images\\sparta-arena-1.jpeg', 1000.00, 'available'),
(2, 'Sporthood Turfpark', 'Sporthood Turfpark can simultaneously host 7-a-side and 5-a-side games. It is close to the biggest shopping mall in Kerala and has great access from the city’s arterial roads.', 'Edappally, Kochi', 'assets\\images\\turf-images\\sporthood-turfpark-1.jpeg', 1000.00, 'available'),
(3, 'Gamma Football', 'Gamma Football has a FIFA-approved 3G artificial turf that’s designed to soften impact on the joints and decrease the likelihood of injury. They have a women\'s football programme called Gamma Girls.', 'Chilavannoor, Ernakulam', 'assets\\images\\turf-images\\gamma-football-1.jpeg', 1000.00, 'available'),
(4, 'Parkway', 'Located in the heart of Kochi, Parkway is a multi-sport centre and a popular gathering place for sports enthusiasts in the city.', 'Kalamassery, Kochi', 'assets\\images\\turf-images\\parkway-1.jpeg', 1000.00, 'available'),
(5, 'MTM Sports', 'Located at the heart of Ponnani, a place of historical importance, MTM Sports Village is Malabar’s first multi-sport arena. It was designed to be a community centre and has a wide range of sports: football, cricket, tennis, swimming, roller skating, basketball, badminton, volleyball, table tennis and beach volleyball.', 'Ponnani, Malappuram', 'assets\\images\\turf-images\\MTM-sports-1.jpeg', 1000.00, 'available'),
(6, 'Lake Zone', 'Lake Zone is a very good facility in Kolathara. The 5-a-side football turf is by the river. The place is well-known for water sports and boat rides.', 'Kolathara, Kozhikode', 'assets\\images\\turf-images\\Lake-Zone-1.jpeg', 1000.00, 'available'),
(7, 'Just Futsal', 'Just Futsal is a stunning turf overlooking Thrissur City. It is equipped with a state-of-the-art FIFA-standard synthetic turf and excellent lighting.', 'Shobha City Mall, Thrissur', 'assets\\images\\turf-images\\Just-Futsal-1.jpeg', 1500.00, 'available'),
(8, 'Goal Castle', 'Vazhakkad and its neighbouring areas have produced many state and national players -- U Sharafali (former Indian player), Ijaz Ali (Indian Junior Team), Hanan Javed (Indian Junior Team), Shakkeer Manuppa (former Kerala Blasters), Shabaz Saleel (India U-21). Goal Castle is one of the first artificial turfs in Malabar region. Good for 5-a-side matches.', 'Vazhakkad, Kozhikode', '\\assets\\images\\turf-images\\Goal-Castle-1.jpg', 1000.00, 'available'),
(9, 'Sporthood Espirito', 'Sporthood Espirito was the first turf in Kakkanad area. It is easily accessible from Infopark, an IT park complex in Kochi.', 'Kakkanad, Kochi', 'assets\\images\\turf-images\\Sporthood-Espirito-1.jpeg', 800.00, 'available'),
(10, 'Cochin Sports Arena', 'Cochin Sports Arena is the biggest 7-a-side ground in the locality and easily accessible from main areas like Kakkanad, Palarivattom and Edapally', 'Edappally, Kochi', 'assets\\images\\turf-images\\Cochin-Sports-Arena.jpeg', 1000.00, 'available'),
(11, 'Calicut Arena', 'Calicut Arena is one of the best and biggest turfs in the city of Calicut. The arena has two independent courts; one for 7-a-side and one for 5-a-side.', 'Moozhikkal, Kozhikode', 'assets\\images\\turf-images\\Calicut-Arena.jpeg', 1000.00, 'available');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'amal', 'amal@gmail.com', 'amal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `turfs`
--
ALTER TABLE `turfs`
  ADD PRIMARY KEY (`turf_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `turfs`
--
ALTER TABLE `turfs`
  MODIFY `turf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
