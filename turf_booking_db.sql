-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 11:31 AM
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
  `user_id` int(11) NOT NULL,
  `turf_id` int(11) NOT NULL,
  `time_slot_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `status` enum('booked','cancelled','completed') DEFAULT 'booked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_slots`
--

CREATE TABLE `time_slots` (
  `id` int(11) NOT NULL,
  `slot_start` time NOT NULL,
  `slot_end` time NOT NULL,
  `is_available` tinyint(1) DEFAULT 1 COMMENT '1 = Available, 0 = Booked',
  `turf_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_slots`
--

INSERT INTO `time_slots` (`id`, `slot_start`, `slot_end`, `is_available`, `turf_id`) VALUES
(1, '05:00:00', '06:00:00', 1, 0),
(2, '06:00:00', '07:00:00', 1, 0),
(3, '07:00:00', '08:00:00', 1, 0),
(4, '08:00:00', '09:00:00', 1, 0),
(5, '09:00:00', '10:00:00', 1, 0),
(6, '10:00:00', '11:00:00', 1, 0),
(7, '11:00:00', '12:00:00', 1, 0),
(8, '12:00:00', '13:00:00', 1, 0),
(9, '13:00:00', '14:00:00', 1, 0),
(10, '14:00:00', '15:00:00', 1, 0),
(11, '15:00:00', '16:00:00', 1, 0),
(12, '16:00:00', '17:00:00', 1, 0),
(13, '17:00:00', '18:00:00', 1, 0),
(14, '18:00:00', '19:00:00', 1, 0),
(15, '19:00:00', '20:00:00', 1, 0),
(16, '20:00:00', '21:00:00', 1, 0),
(17, '21:00:00', '22:00:00', 1, 0),
(18, '22:00:00', '23:00:00', 1, 0),
(19, '23:00:00', '00:00:00', 1, 0);

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
  `status` enum('available','booked') NOT NULL DEFAULT 'available',
  `image_2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `turfs`
--

INSERT INTO `turfs` (`turf_id`, `turf_name`, `description`, `location`, `image`, `price`, `status`, `image_2`) VALUES
(1, 'Sparta Arena', 'Sparta Arena hosts a lot of semi-professional games. It also has cricket and beach volleyball facilities in the complex.', 'Oruvathilkotta, Thiruvananthapuram', 'assets\\images\\turf-images\\sparta-arena-2.jpg', 1000.00, 'available', 'assets\\images\\turf-images\\sparta-arena-1.jpeg'),
(2, 'Sporthood Turfpark', 'Sporthood Turfpark can simultaneously host 7-a-side and 5-a-side games. It is close to the biggest shopping mall in Kerala and has great access from the city’s arterial roads.', 'Edappally, Kochi', 'assets\\images\\turf-images\\sporthood-turfpark-2.jpg', 1000.00, 'available', 'assets\\images\\turf-images\\sporthood-turfpark-1.jpeg'),
(3, 'Gamma Football', 'Gamma Football has a FIFA-approved 3G artificial turf that’s designed to soften impact on the joints and decrease the likelihood of injury. They have a women\'s football programme called Gamma Girls.', 'Chilavannoor, Ernakulam', 'assets\\images\\turf-images\\gamma-football-2.jpg', 1000.00, 'available', 'assets\\images\\turf-images\\gamma-football-1.jpeg'),
(4, 'Parkway', 'Located in the heart of Kochi, Parkway is a multi-sport centre and a popular gathering place for sports enthusiasts in the city.', 'Kalamassery, Kochi', 'assets\\images\\turf-images\\parkway-2.jpg', 1000.00, 'available', 'assets\\images\\turf-images\\parkway-1.jpeg'),
(5, 'MTM Sports', 'Located at the heart of Ponnani, a place of historical importance, MTM Sports Village is Malabar’s first multi-sport arena. It was designed to be a community centre and has a wide range of sports: football, cricket, tennis, swimming, roller skating, basketball, badminton, volleyball, table tennis and beach volleyball.', 'Ponnani, Malappuram', 'assets\\images\\turf-images\\MTM-sports-2.jpg', 1000.00, 'available', 'assets\\images\\turf-images\\MTM-sports-1.jpeg'),
(6, 'Lake Zone', 'Lake Zone is a very good facility in Kolathara. The 5-a-side football turf is by the river. The place is well-known for water sports and boat rides.', 'Kolathara, Kozhikode', 'assets\\images\\turf-images\\Lake-Zone-2.jpg', 1000.00, 'available', 'assets\\images\\turf-images\\Lake-Zone-1.jpeg'),
(7, 'Just Futsal', 'Just Futsal is a stunning turf overlooking Thrissur City. It is equipped with a state-of-the-art FIFA-standard synthetic turf and excellent lighting.', 'Shobha City Mall, Thrissur', 'assets\\images\\turf-images\\Just-Futsal-2.jpg', 1500.00, 'available', 'assets\\images\\turf-images\\Just-Futsal-1.jpeg'),
(8, 'Goal Castle', 'Vazhakkad and its neighbouring areas have produced many state and national players -- U Sharafali (former Indian player), Ijaz Ali (Indian Junior Team), Hanan Javed (Indian Junior Team), Shakkeer Manuppa (former Kerala Blasters), Shabaz Saleel (India U-21). Goal Castle is one of the first artificial turfs in Malabar region. Good for 5-a-side matches.', 'Vazhakkad, Kozhikode', 'assets\\images\\turf-images\\Goal-Castle-2.jpg', 1000.00, 'available', 'assets\\images\\turf-images\\Goal-Castle-1.jpg'),
(9, 'Sporthood Espirito', 'Sporthood Espirito was the first turf in Kakkanad area. It is easily accessible from Infopark, an IT park complex in Kochi.', 'Kakkanad, Kochi', 'assets\\images\\turf-images\\Sporthood-Espirito-2.jpg', 800.00, 'available', 'assets\\images\\turf-images\\Sporthood-Espirito-1.jpeg'),
(10, 'Cochin Sports Arena', 'Cochin Sports Arena is the biggest 7-a-side ground in the locality and easily accessible from main areas like Kakkanad, Palarivattom and Edapally', 'Edappally, Kochi', 'assets\\images\\turf-images\\Cochin-Sports-Arena-2.jpg', 1000.00, 'available', 'assets\\images\\turf-images\\Cochin-Sports-Arena-1.jpeg'),
(11, 'Calicut Arena', 'Calicut Arena is one of the best and biggest turfs in the city of Calicut. The arena has two independent courts; one for 7-a-side and one for 5-a-side.', 'Moozhikkal, Kozhikode', 'assets\\images\\turf-images\\Calicut-Arena-2.jpg', 1000.00, 'available', 'assets\\images\\turf-images\\Calicut-Arena-1.jpeg');

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
(16, 'amal', 'amal@gmail.com', '$2y$10$XGIYfnR/LWbbsdAbF7Vk1utx1kbMjpLlyD4uj7pSI6kv7Yi/j5MC6'),
(17, 'jaseeena miss', 'jaseenamiss@gmail.com', '$2y$10$sRbykhuq2xRbqJjhPTqfx.mJmjp7W7UhB5HVvMTNLJcEmvYD/WHGy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `turf_id` (`turf_id`),
  ADD KEY `time_slot_id` (`time_slot_id`);

--
-- Indexes for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `time_slots`
--
ALTER TABLE `time_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `turfs`
--
ALTER TABLE `turfs`
  MODIFY `turf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`turf_id`) REFERENCES `turfs` (`turf_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`time_slot_id`) REFERENCES `time_slots` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
