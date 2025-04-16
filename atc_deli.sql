-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 08:25 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `atc_deli`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `full_name` varchar(55) NOT NULL,
  `img` varchar(55) NOT NULL DEFAULT 'df.png',
  `username` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `web_name` varchar(25) NOT NULL DEFAULT 'delivery',
  `logo` varchar(55) NOT NULL DEFAULT 'logo.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `full_name`, `img`, `username`, `password`, `address`, `phone`, `web_name`, `logo`) VALUES
(1, 'Admin ATC ', 'logo.png', 'admin', '$2y$10$UUEMMixxaLaHKmMEMof07uY30JYsNBG0xOAsasf9gKauEBHpqF.0W', 'Ayutthaya Technical College', '0638508500', 'ATC_Delivery', '892633510.png');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `cpn_id` int(11) NOT NULL,
  `cpn_code` varchar(25) NOT NULL,
  `cpn_discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`cpn_id`, `cpn_code`, `cpn_discount`) VALUES
(1, 'test', 5),
(2, 'atc', 50);

-- --------------------------------------------------------

--
-- Table structure for table `fav_food`
--

CREATE TABLE `fav_food` (
  `fav_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fav_food`
--

INSERT INTO `fav_food` (`fav_id`, `food_id`, `res_id`, `user_id`) VALUES
(1, 7, 1, 1),
(2, 8, 1, 1),
(3, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fav_res`
--

CREATE TABLE `fav_res` (
  `fav_id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fav_res`
--

INSERT INTO `fav_res` (`fav_id`, `res_id`, `user_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `food_id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `food_type_id` int(11) NOT NULL,
  `food_name` varchar(55) NOT NULL,
  `img` varchar(55) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) NOT NULL DEFAULT 0,
  `star` float NOT NULL DEFAULT 0 COMMENT 'คะแนนดาวเฉลี่ย',
  `rating` int(11) NOT NULL DEFAULT 0 COMMENT 'คะแนนทั้งหมด',
  `qty_sale` int(11) NOT NULL DEFAULT 0 COMMENT 'จำนวนการขาย',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT 'สถานะเมนูคงเหลือ\r\n1=คงเหลือ\r\n0=หมด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`food_id`, `res_id`, `food_type_id`, `food_name`, `img`, `price`, `discount`, `star`, `rating`, `qty_sale`, `status`) VALUES
(1, 1, 1, 'ข้าวผัดกุ้ง', '1755670882.jpg', 80, 0, 5, 5, 1, 1),
(2, 1, 1, 'ข้าวผัดต้มยำทะเล', '429381668.jpg', 120, 0, 0, 0, 0, 1),
(3, 1, 1, 'ผัดไทยกุ้งสด', '2119893494.jpg', 90, 0, 0, 0, 0, 1),
(4, 1, 2, 'ต้มยำกุ้ง', '1994073533.jpg', 80, 0, 0, 0, 0, 1),
(5, 1, 3, 'แกงส้มกุ้ง', '227492301.jpg', 80, 0, 0, 0, 0, 1),
(6, 1, 3, 'แกงเขียวหวาน', '1532063481.jpg', 70, 0, 0, 0, 0, 1),
(7, 1, 0, 'ข้าวไข่ข้นกุ้ง', '2025511965.png', 120, 80, 5, 5, 1, 1),
(8, 1, 6, 'กุ้งทอดพริกเกลือ', '10858350.png', 120, 40, 5, 5, 1, 1),
(9, 1, 5, 'แป๊ปสิ', '1056060168.png', 40, 10, 0, 0, 0, 1),
(10, 1, 5, 'น้ำส้ม', '293105809.jpg', 20, 0, 0, 0, 0, 1),
(11, 1, 4, 'ไอติม', '511056201.jpg', 25, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `food_order`
--

CREATE TABLE `food_order` (
  `food_order_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `food_name` varchar(55) NOT NULL,
  `img` varchar(55) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `food_order`
--

INSERT INTO `food_order` (`food_order_id`, `order_id`, `food_id`, `food_name`, `img`, `price`, `discount`, `qty`, `total_price`) VALUES
(1, 1, 7, 'ข้าวไข่ข้นกุ้ง', '2025511965.png', 120, 80, 3, 72),
(2, 1, 8, 'กุ้งทอดพริกเกลือ', '10858350.png', 120, 40, 2, 144),
(3, 1, 1, 'ข้าวผัดกุ้ง', '1755670882.jpg', 80, 0, 2, 160);

-- --------------------------------------------------------

--
-- Table structure for table `food_type`
--

CREATE TABLE `food_type` (
  `food_type_id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `food_type` varchar(55) NOT NULL,
  `img` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `food_type`
--

INSERT INTO `food_type` (`food_type_id`, `res_id`, `food_type`, `img`) VALUES
(1, 1, 'ผัด', '168112111.jpg'),
(2, 1, 'ต้ม', '1400857782.jpg'),
(3, 1, 'แกง', '1484798171.jpg'),
(4, 1, 'ของหวาน', '54292756.jpg'),
(5, 1, 'เครื่องดื่ม', '692800508.jpg'),
(6, 1, 'อาหารทอด', '486839448.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `order_id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `all_price` float NOT NULL COMMENT 'ราคาทั้งหมด',
  `cpn_discount` int(11) NOT NULL COMMENT 'ส่วนลดเป็นเปอร์เซ็นต์',
  `sum_price` float NOT NULL COMMENT 'ราคาหลังหักส่วนลด',
  `user_id` int(55) NOT NULL,
  `full_name` varchar(55) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `slip` varchar(25) DEFAULT NULL,
  `rider_id` int(11) DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `time` time NOT NULL DEFAULT current_timestamp(),
  `star` int(11) NOT NULL DEFAULT 0,
  `review` varchar(255) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT 2 COMMENT 'สถานะของออร์เดอร์\r\n-1=ถูกยกเลิกแล้ว\r\n0=ถููกยกเลิก รอลูกค้ายืนยัน\r\n1=รอร้านยืนยันสลิป\r\n2=รอไรเดอร์กดรับ\r\n3=รอร้านทำอาหาร\r\n4=ร้านทำอาหารเสร็จ\r\n5=ไรเดอร์กำลังส่ง\r\n6=จัดส่งเสร็จ รอลูกค้ารีวิว\r\n7=ออร์เดอร์เสร็จสิ้น'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`order_id`, `res_id`, `all_price`, `cpn_discount`, `sum_price`, `user_id`, `full_name`, `address`, `phone`, `slip`, `rider_id`, `date`, `time`, `star`, `review`, `status`) VALUES
(1, 1, 376, 50, 188, 1, 'teerapat suksam-ang', 'Ayutthaya Technical College', '0638508500', NULL, 1, '2025-04-15', '00:19:58', 5, 'ส่งไวมากครับ ไข่ข้นกุ้งกับกุ้งทอดพริกเกลืออร่อยมากๆครับเจ๊จูน', 7);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `res_id` int(11) NOT NULL,
  `full_name` varchar(55) NOT NULL,
  `img` varchar(55) NOT NULL DEFAULT 'res_df.png',
  `username` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `res_name` varchar(25) NOT NULL COMMENT 'ชื่อร้าน',
  `res_type_id` int(11) NOT NULL COMMENT 'หมวดหมู่ร้าน',
  `star` float NOT NULL DEFAULT 0 COMMENT 'คะแนนดาวเฉลี่ย',
  `rating` int(11) NOT NULL DEFAULT 0 COMMENT 'คะแนนทั้งหมด',
  `qty_sale` int(11) NOT NULL DEFAULT 0 COMMENT 'จำนวนครั้งที่ขายได้',
  `status` int(11) NOT NULL DEFAULT 0,
  `bank` varchar(25) DEFAULT NULL COMMENT 'ชื่อธนาคาร',
  `qr_code` varchar(25) DEFAULT NULL,
  `ac_num` varchar(25) DEFAULT NULL COMMENT 'เลขบัญชี',
  `ac_name` varchar(25) DEFAULT NULL COMMENT 'ชื่อบัญชี',
  `note` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`res_id`, `full_name`, `img`, `username`, `password`, `address`, `phone`, `res_name`, `res_type_id`, `star`, `rating`, `qty_sale`, `status`, `bank`, `qr_code`, `ac_num`, `ac_name`, `note`) VALUES
(1, 'เจ๊ จูน', '485298275.jpg', 'res1', '$2y$10$idmXaJAPi.okXB.gO6X0LewBBRASRhpPwu0Xd7zv7wnwAJkguV/S.', 'Ayutthaya Technical College', '1234567890', 'ตามสั่งเจ๊จูน', 1, 5, 5, 1, 1, 'กสิกรไทย', '698916606.jpeg', '171-1-10043-8', 'ธีรภัทร สุขสำอางค์', '');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_type`
--

CREATE TABLE `restaurant_type` (
  `res_type_id` int(11) NOT NULL,
  `res_type` varchar(55) NOT NULL,
  `img` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurant_type`
--

INSERT INTO `restaurant_type` (`res_type_id`, `res_type`, `img`) VALUES
(1, 'อาหารตามสั่ง', '44919845.png'),
(2, 'ก๋วยเตี๋ยว', '1231368668.jpg'),
(3, 'อาหารอีสาน', '1537671581.jpg'),
(4, 'เครื่องดื่ม', '1341279160.jpg'),
(5, 'อาหารญี่ปุ่น', '10668521.jpg'),
(6, 'พิซซ่า', '1559057679.png'),
(7, 'ไอติม/ของหวาน', '609090793.png');

-- --------------------------------------------------------

--
-- Table structure for table `rider`
--

CREATE TABLE `rider` (
  `rider_id` int(11) NOT NULL,
  `full_name` varchar(55) NOT NULL,
  `img` varchar(55) NOT NULL DEFAULT 'df.png',
  `username` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `note` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rider`
--

INSERT INTO `rider` (`rider_id`, `full_name`, `img`, `username`, `password`, `address`, `phone`, `status`, `note`) VALUES
(1, 'passakorn kanpai', '1557305621.png', 'rider1', '$2y$10$u37r/V8pgDZuRs8bUQISwuHInhwK5/6Gfwp4xuUSZpUJ9p.u4AHQ.', 'Ayutthaya Technical College', '1234567890', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(55) NOT NULL,
  `img` varchar(55) NOT NULL DEFAULT 'df.png',
  `username` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `note` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `full_name`, `img`, `username`, `password`, `address`, `phone`, `status`, `note`) VALUES
(1, 'teerapat suksam-ang', '2138689452.png', 'user1', '$2y$10$DSKMWAcGDpjxAK0w.hXhK.MgH/1DgsUa.d5CO0Vtl5SAojWlk0Bxa', 'Ayutthaya Technical College', '0638508500', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`cpn_id`);

--
-- Indexes for table `fav_food`
--
ALTER TABLE `fav_food`
  ADD PRIMARY KEY (`fav_id`);

--
-- Indexes for table `fav_res`
--
ALTER TABLE `fav_res`
  ADD PRIMARY KEY (`fav_id`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`food_id`);

--
-- Indexes for table `food_order`
--
ALTER TABLE `food_order`
  ADD PRIMARY KEY (`food_order_id`);

--
-- Indexes for table `food_type`
--
ALTER TABLE `food_type`
  ADD PRIMARY KEY (`food_type_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`res_id`);

--
-- Indexes for table `restaurant_type`
--
ALTER TABLE `restaurant_type`
  ADD PRIMARY KEY (`res_type_id`);

--
-- Indexes for table `rider`
--
ALTER TABLE `rider`
  ADD PRIMARY KEY (`rider_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `cpn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fav_food`
--
ALTER TABLE `fav_food`
  MODIFY `fav_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fav_res`
--
ALTER TABLE `fav_res`
  MODIFY `fav_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `food_order`
--
ALTER TABLE `food_order`
  MODIFY `food_order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `food_type`
--
ALTER TABLE `food_type`
  MODIFY `food_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `restaurant_type`
--
ALTER TABLE `restaurant_type`
  MODIFY `res_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rider`
--
ALTER TABLE `rider`
  MODIFY `rider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
