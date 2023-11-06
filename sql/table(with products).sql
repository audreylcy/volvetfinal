-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2023 at 02:04 PM
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
-- Database: `volvet`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `address_1` varchar(255) DEFAULT NULL,
  `address_2` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postal` varchar(20) DEFAULT NULL,
  `delivery_method` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `orderdetail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description_image1` varchar(255) DEFAULT NULL,
  `description_image2` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_size` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_description`, `product_price`, `category`, `description_image1`, `description_image2`, `product_image`, `product_size`) VALUES
(1, 'Bottega Veneta Crossbody Bag', 'This is an authentic BOTTEGA VENETA Nappa Maxi Intrecciato Padded Cassette Crossbody Bag in Caramel. This stylish shoulder bag is crafted of soft nappa leather in light brown. The bag features an adjustable leather shoulder strap and opens to a nappa leat', 2100.00, 'Bag', 'bottega_bag_3.jpg', 'bottega_bag_2.jpg', 'bottega_bag_1.jpg', 'Base length: 7.5 in\r\nHeight: 4.75 in\r\nWidth: 2.25 in\r\nDrop: 20.5 in'),
(2, 'YSL Medium College Bag', 'This is an authentic SAINT LAURENT Smooth Calfskin Cotton Canvas Matelasse Chevron Monogram Medium College Bag in Deeply Blue. This chic shoulder bag is crafted of quilted cotton. It features an optional aged gold chain-link shoulder strap with a dark blu', 2245.00, 'Bag', 'ysl_bag_3.jpg', 'ysl_bag_2.jpg', 'ysl_bag_1.jpg', 'Base length: 9.5 in\r\nHeight: 7 in\r\nWidth: 2.25 in\r\nDrop: 2.25 in\r\nDrop: 22 in'),
(3, 'Chanel 22 Grey', 'This is an authentic CHANEL Shiny Calfskin Quilted Large Chanel 22 in Grey. This chic bag is crafted of shiny diamond-stitched calfskin leather in grey. The bag features a leather-threaded aged gold chain shoulder strap with a Chanel CC medallion, and a m', 5455.00, 'Bag', 'chanel_bag_3.jpg', 'chanel_bag_2.jpg', 'chanel_bag_1.jpg', 'Base length: 14.25 in\r\nHeight: 18.25 in\r\nWidth: 4 in\r\nDrop: 5.5 in'),
(4, 'Chloe Ribbon Tote', 'This is an authentic CHLOE Cotton Calfskin Small Woody Ribbon Tote With Strap in Light Blue. This stylish tote is crafted of natural beige canvas, with light blue leather trim. It features canvas top handles and an optional leather strap. The top opens to', 940.00, 'Bag', 'chloe_bag_3.jpg', 'chloe_bag_2.jpg', 'chloe_bag_1.jpg', 'Length: 10.25 in\r\nHeight: 8.5 in\r\nWidth: 3 in\r\nDrop: 4 in\r\nDrop: 20 in'),
(5, 'Gucci Slide Sandals', 'This is an authentic pair of GUCCI Soft Rubber Womens Interlocking G Platform 42mm Slide Sandals size 38 in White. These stylish sandals are crafted of white rubber with a GUCCI GG logo on the front.', 415.00, 'Shoe', 'gucci_shoe_3.jpg', 'gucci_shoe_2.jpg', 'gucci_shoe_1.jpg', 'Size: 38 EU'),
(6, 'LV Trainer Sneakers', 'This is an authentic pair of LOUIS VUITTON Calfskin Embossed Monogram Denim Mens LV Trainer Sneakers in Blue. These stylish sneakers are crafted of white leather and monogram denim. The tongue displays the LV logo as well as the heel of the shoe and the L', 1315.00, 'Shoe', 'lv_shoe_3.jpg', 'lv_shoe_2.jpg', 'lv_shoe_1.jpg', 'Size: 6.5 US'),
(7, 'Bottega Veneta Boots', 'These are an authentic pair of BOTTEGA VENETA Calfskin The Tire Chelsea Boots in Black Camping. The stunning boots are crafted of smooth black calfskin leather and feature a 2.5-inch heel.', 865.00, 'Shoe', 'bottega_shoe_3.jpg', 'bottega_shoe_2.jpg', 'bottega_shoe_1.jpg', 'Size: 38 EU\r\nShaft: 9 in\r\nHeel: 2 in\r\nPlatform: 1.25 in'),
(8, 'Hermes Sandals', 'This is an authentic pair of HERMES Calfskin Womens Empire Sandals size 37 in Black. These sandals are crafted of black calfskin leather. They feature palladium hardware and leather-lined insoles.', 940.00, 'Shoe', 'hermes_shoe_3.jpg', 'hermes_shoe_2.jpg', 'hermes_shoe_1.jpg', 'Size: 37 EU'),
(9, 'Chanel Crystal Bracelet', 'This is an authentic CHANEL Pearl Crystal CC Bracelet in Silver. This bracelet features a strand of faux pearls with a small hanging silver Chanel CC logo pendant lined with crystals and faux pearls.', 775.00, 'Jewellery ', 'chanel_jewellery_3.jpg', 'chanel_jewellery_2.jpg', 'chanel_jewellery_1.jpg', 'Circumference: 6.25 in\r\nWidth: 0.25 in'),
(10, 'Van Cleef & Arpels 18k White Gold Alhambra Pendant', 'This is an authentic VAN CLEEF & ARPELS 18K White Gold Diamond Celadon Green Sevres Porcelain Vintage Alhambra Pendant Necklace. The necklace is crafted of 18 karat white gold and features an Alhambra clover motif set with a green porcelain and a single b', 5455.00, 'Jewellery', 'vancleef_jewellery_3.jpg', 'vancleef_jewellery_2.jpg', 'vancleef_jewellery_1.jpg', 'Length: 14.75 in to 16.50 in\r\nPendant: 15 mm\r\nWidth: 15 mm'),
(11, 'Cartier LOVE Cuff Bracelet 16', 'This is an authentic CARTIER 18K Yellow Gold 1 Diamond LOVE Cuff Bracelet 16. The bracelet is crafted of 18 karat yellow gold and features the signature engraved LOVE screw symbol motif throughout the open cuff with a single round brilliant cut diamond in', 5980.00, 'Jewellery', 'cartier_jewellery_3.jpg', 'cartier_jewellery_2.jpg', 'cartier_jewellery_1.jpg', 'Circumference: 5.5 in\r\nWidth: 6 mm\r\nSize: 16 cm'),
(12, 'Hermes Mini H Earrings', 'This is an authentic HERMES Rose Gold Lacquered Mini Pop H Earrings in White. The complex yet classic design of these Hermes earrings have a distinctive quality of sophistication. The earrings are rose gold tone metal and crafted in ring styled with an “H', 0.00, 'Jewellery', 'hermes_jewellery_3.jpg', 'hermes_jewellery_2.jpg', 'hermes_jewellery_1.jpg', 'Length: 0.25 mm\r\nHeight: 0.25 mm'),
(13, 'LV Pocket Organizer', 'This is an authentic LOUIS VUITTON Monogram Pocket Organizer NM. This lovely card holder is made of traditional monogram coated canvas in brown and opens to a brown crossgrain leather interior with card slots and patch pockets.\r\n\r\n', 415.00, 'Accessory', 'lv_accessories_3.jpg', 'lv_accessories_2.jpg', 'lv_accessories_1.jpg', 'Base length: 3 in\r\nHeight: 4.25 in'),
(14, 'Christian Dior Canvas Shoulder Strap', 'This is an authentic CHRISTIAN DIOR Canvas Embroidered Shoulder Strap in Black and White. This elegant strap is crafted of canvas in black and white, with aged gold hardware.\r\n\r\n', 1045.00, 'Accessory', 'dior_accessories_3.jpg', 'dior_accessories_2.jpg', 'dior_accessories_1.jpg', 'Length: 44 in\r\nHeight: 1.5 in'),
(15, 'Hermes Apple Watch', 'This is an authentic HERMES Swift Circuit 24 45mm Apple Watch Single Tour Band in Encre and Beton. This watch band is crafted of calfskin leather in beige with a blue intricate design. This watch band features black hardware and can be connected to a 42, ', 500.00, 'Accessory', 'hermes_accessories_3.jpg', 'hermes_accessories_2.jpg', 'hermes_accessories_1.jpg', 'Length: 8 in\r\nWidth: 0.75 in'),
(16, 'Chanel Sunglasses White', 'This is an authentic CHANEL Acetate Pearl Cat Eye CC Sunglasses 5481-H-A in White. These ultra-chic sunglasses have a cutting edge white frame with cat eye rims with a resin pearl embellishment, and gradient dark grey lenses.\r\n\r\n', 550.00, 'Accessory', 'chanel_accessories_3.jpg', 'chanel_accessories_2.jpg', 'chanel_accessories_1.jpg', 'Length: 5.25 in\r\nHeight: 1.75 in\r\nWidth: 5.75 in');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`orderdetail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderdetail`
--
ALTER TABLE `orderdetail`
  MODIFY `orderdetail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `orderdetail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `orderdetail_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orderdetail_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `cart` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
