-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 07, 2023 at 08:02 PM
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
  `user_email` varchar(255) NOT NULL,
  `address_1` varchar(255) DEFAULT NULL,
  `address_2` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postal` int(11) DEFAULT NULL,
  `delivery_method` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `user_email`, `address_1`, `address_2`, `state`, `postal`, `delivery_method`) VALUES
(10, 'ruth142976@gmail.com', 'Kang Ching Road 339B', NULL, 'Singapore', 612339, 'standard'),
(11, 'ruth142976@gmail.com', 'Kang Ching Road 339B', '#15-336', 'Singapore', 612339, 'standard'),
(12, 'testing@gmail.com', '662 Choa Chu Kang Crescent #12-271', '#12-271', 'dfsds', 680662, 'Standard Shipping'),
(13, 'eh@test.com', '662 Choa Chu Kang Crescent #12-271', '#12-271', 'da', 680662, 'Standard Shipping'),
(14, 'testing@gmail.com', '662 Choa Chu Kang Crescent #12-271', '#12-271', 'Not applicable', 680662, 'Standard Shipping'),
(15, 'testing@gmail.com', '17 CANBERRA DRIVE', '#13-34', 'Not applicable', 768074, 'Standard Shipping'),
(16, 'audrey.lcy4@gmail.com', '17 CANBERRA DRIVE', '#13-34', 'Not applicable', 768074, 'Standard Shipping');

-- --------------------------------------------------------

--
-- Table structure for table `checkout_details`
--

CREATE TABLE `checkout_details` (
  `checkout_id` int(11) NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkout_details`
--

INSERT INTO `checkout_details` (`checkout_id`, `user_email`, `address_id`, `total_price`, `created_at`) VALUES
(33, 'testing@gmail.com', 12, 2245.00, '2023-11-07'),
(34, 'eh@test.com', 13, 2745.00, '2023-11-07'),
(35, 'testing@gmail.com', 14, 4200.00, '2023-11-07'),
(36, 'testing@gmail.com', 15, 9945.00, '2023-11-07'),
(37, 'testing@gmail.com', 15, 2100.00, '2023-11-07'),
(38, 'audrey.lcy4@gmail.com', 16, 2245.00, '2023-11-07');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `address_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `user_email` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `address_id`, `total`, `user_email`, `product_id`, `product_price`, `quantity`) VALUES
(65, NULL, 2100.00, 'testing@gmail.com', 1, 2100.00, 1),
(66, NULL, 2245.00, 'testing@gmail.com', 2, 2245.00, 1),
(67, NULL, 5455.00, 'testing@gmail.com', 3, 5455.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_id` int(11) NOT NULL,
  `checkout_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_id`, `checkout_id`, `product_id`, `quantity`, `subtotal`, `product_price`) VALUES
(51273, 32, 2, 1, 2245.00, 2245.00),
(51274, 33, 2, 1, 2245.00, 2245.00),
(51275, 34, 15, 1, 500.00, 500.00),
(51276, 34, 2, 1, 2245.00, 2245.00),
(51277, 35, 1, 1, 2100.00, 2100.00),
(51278, 35, 1, 1, 2100.00, 2100.00),
(51279, 36, 2, 1, 2245.00, 2245.00),
(51280, 36, 2, 1, 2245.00, 2245.00),
(51281, 36, 3, 1, 5455.00, 5455.00),
(51282, 37, 1, 1, 2100.00, 2100.00),
(51283, 38, 2, 1, 2245.00, 2245.00);

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
  `product_size` varchar(255) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_description`, `product_price`, `category`, `description_image1`, `description_image2`, `product_image`, `product_size`, `product_quantity`) VALUES
(1, 'Bottega Veneta Crossbody Bag', 'This is an authentic BOTTEGA VENETA Nappa Maxi Intrecciato Padded Cassette Crossbody Bag in Caramel. This stylish shoulder bag is crafted of soft nappa leather in light brown. The bag features an adjustable leather shoulder strap and opens to a nappa leat', 2100.00, 'Bag', 'bottega_bag_3.jpg', 'bottega_bag_2.jpg', 'bottega_bag_1.jpg', 'Base length: 7.5 in\r\nHeight: 4.75 in\r\nWidth: 2.25 in\r\nDrop: 20.5 in', 1),
(2, 'YSL Medium College Bag', 'This is an authentic SAINT LAURENT Smooth Calfskin Cotton Canvas Matelasse Chevron Monogram Medium College Bag in Deeply Blue. This chic shoulder bag is crafted of quilted cotton. It features an optional aged gold chain-link shoulder strap with a dark blu', 2245.00, 'Bag', 'ysl_bag_3.jpg', 'ysl_bag_2.jpg', 'ysl_bag_1.jpg', 'Base length: 9.5 in\r\nHeight: 7 in\r\nWidth: 2.25 in\r\nDrop: 2.25 in\r\nDrop: 22 in', 1),
(3, 'Chanel 22 Grey', 'This is an authentic CHANEL Shiny Calfskin Quilted Large Chanel 22 in Grey. This chic bag is crafted of shiny diamond-stitched calfskin leather in grey. The bag features a leather-threaded aged gold chain shoulder strap with a Chanel CC medallion, and a m', 5455.00, 'Bag', 'chanel_bag_3.jpg', 'chanel_bag_2.jpg', 'chanel_bag_1.jpg', 'Base length: 14.25 in\r\nHeight: 18.25 in\r\nWidth: 4 in\r\nDrop: 5.5 in', 1),
(4, 'Chloe Ribbon Tote', 'This is an authentic CHLOE Cotton Calfskin Small Woody Ribbon Tote With Strap in Light Blue. This stylish tote is crafted of natural beige canvas, with light blue leather trim. It features canvas top handles and an optional leather strap. The top opens to', 940.00, 'Bag', 'chloe_bag_3.jpg', 'chloe_bag_2.jpg', 'chloe_bag_1.jpg', 'Length: 10.25 in\r\nHeight: 8.5 in\r\nWidth: 3 in\r\nDrop: 4 in\r\nDrop: 20 in', 1),
(5, 'Gucci Slide Sandals', 'This is an authentic pair of GUCCI Soft Rubber Womens Interlocking G Platform 42mm Slide Sandals size 38 in White. These stylish sandals are crafted of white rubber with a GUCCI GG logo on the front.', 415.00, 'Shoe', 'gucci_shoe_3.jpg', 'gucci_shoe_2.jpg', 'gucci_shoe_1.jpg', 'Size: 38 EU', 1),
(6, 'LV Trainer Sneakers', 'This is an authentic pair of LOUIS VUITTON Calfskin Embossed Monogram Denim Mens LV Trainer Sneakers in Blue. These stylish sneakers are crafted of white leather and monogram denim. The tongue displays the LV logo as well as the heel of the shoe and the L', 1315.00, 'Shoe', 'lv_shoe_3.jpg', 'lv_shoe_2.jpg', 'lv_shoe_1.jpg', 'Size: 6.5 US', 1),
(7, 'Bottega Veneta Boots', 'These are an authentic pair of BOTTEGA VENETA Calfskin The Tire Chelsea Boots in Black Camping. The stunning boots are crafted of smooth black calfskin leather and feature a 2.5-inch heel.', 865.00, 'Shoe', 'bottega_shoe_3.jpg', 'bottega_shoe_2.jpg', 'bottega_shoe_1.jpg', 'Size: 38 EU\r\nShaft: 9 in\r\nHeel: 2 in\r\nPlatform: 1.25 in', 1),
(8, 'Hermes Sandals', 'This is an authentic pair of HERMES Calfskin Womens Empire Sandals size 37 in Black. These sandals are crafted of black calfskin leather. They feature palladium hardware and leather-lined insoles.', 940.00, 'Shoe', 'hermes_shoe_3.jpg', 'hermes_shoe_2.jpg', 'hermes_shoe_1.jpg', 'Size: 37 EU', 1),
(9, 'Chanel Crystal Bracelet', 'This is an authentic CHANEL Pearl Crystal CC Bracelet in Silver. This bracelet features a strand of faux pearls with a small hanging silver Chanel CC logo pendant lined with crystals and faux pearls.', 775.00, 'Jewellery ', 'chanel_jewellery_3.jpg', 'chanel_jewellery_2.jpg', 'chanel_jewellery_1.jpg', 'Circumference: 6.25 in\r\nWidth: 0.25 in', 1),
(10, 'Van Cleef & Arpels 18k White Gold Alhambra Pendant', 'This is an authentic VAN CLEEF & ARPELS 18K White Gold Diamond Celadon Green Sevres Porcelain Vintage Alhambra Pendant Necklace. The necklace is crafted of 18 karat white gold and features an Alhambra clover motif set with a green porcelain and a single b', 5455.00, 'Jewellery', 'vancleef_jewellery_3.jpg', 'vancleef_jewellery_2.jpg', 'vancleef_jewellery_1.jpg', 'Length: 14.75 in to 16.50 in\r\nPendant: 15 mm\r\nWidth: 15 mm', 1),
(11, 'Cartier LOVE Cuff Bracelet 16', 'This is an authentic CARTIER 18K Yellow Gold 1 Diamond LOVE Cuff Bracelet 16. The bracelet is crafted of 18 karat yellow gold and features the signature engraved LOVE screw symbol motif throughout the open cuff with a single round brilliant cut diamond in', 5980.00, 'Jewellery', 'cartier_jewellery_3.jpg', 'cartier_jewellery_2.jpg', 'cartier_jewellery_1.jpg', 'Circumference: 5.5 in\r\nWidth: 6 mm\r\nSize: 16 cm', 1),
(12, 'Hermes Mini H Earrings', 'This is an authentic HERMES Rose Gold Lacquered Mini Pop H Earrings in White. The complex yet classic design of these Hermes earrings have a distinctive quality of sophistication. The earrings are rose gold tone metal and crafted in ring styled with an “H', 0.00, 'Jewellery', 'hermes_jewellery_3.jpg', 'hermes_jewellery_2.jpg', 'hermes_jewellery_1.jpg', 'Length: 0.25 mm\r\nHeight: 0.25 mm', 1),
(13, 'LV Pocket Organizer', 'This is an authentic LOUIS VUITTON Monogram Pocket Organizer NM. This lovely card holder is made of traditional monogram coated canvas in brown and opens to a brown crossgrain leather interior with card slots and patch pockets.\r\n\r\n', 415.00, 'Accessory', 'lv_accessories_3.jpg', 'lv_accessories_2.jpg', 'lv_accessories_1.jpg', 'Base length: 3 in\r\nHeight: 4.25 in', 1),
(14, 'Christian Dior Canvas Shoulder Strap', 'This is an authentic CHRISTIAN DIOR Canvas Embroidered Shoulder Strap in Black and White. This elegant strap is crafted of canvas in black and white, with aged gold hardware.\r\n\r\n', 1045.00, 'Accessory', 'dior_accessories_3.jpg', 'dior_accessories_2.jpg', 'dior_accessories_1.jpg', 'Length: 44 in\r\nHeight: 1.5 in', 1),
(15, 'Hermes Apple Watch', 'This is an authentic HERMES Swift Circuit 24 45mm Apple Watch Single Tour Band in Encre and Beton. This watch band is crafted of calfskin leather in beige with a blue intricate design. This watch band features black hardware and can be connected to a 42, ', 500.00, 'Watch', 'hermes_accessories_3.jpg', 'hermes_accessories_2.jpg', 'hermes_accessories_1.jpg', 'Length: 8 in\r\nWidth: 0.75 in', 1),
(16, 'Chanel Sunglasses White', 'This is an authentic CHANEL Acetate Pearl Cat Eye CC Sunglasses 5481-H-A in White. These ultra-chic sunglasses have a cutting edge white frame with cat eye rims with a resin pearl embellishment, and gradient dark grey lenses.\r\n\r\n', 550.00, 'Accessory', 'chanel_accessories_3.jpg', 'chanel_accessories_2.jpg', 'chanel_accessories_1.jpg', 'Length: 5.25 in\r\nHeight: 1.75 in\r\nWidth: 5.75 in', 1),
(17, 'Cartier Tank Solo XL Gold Watch', 'This is an authentic Cartier Tank Solo XL Automatic Stainless Steel Watch. Introducing the exquisite Cartier Tank Solo XL Automatic Stainless Steel Watch. This iconic timepiece is the embodiment of timeless elegance and precision engineering. ', 800.00, 'Watch', 'cartier_watch_2.jpg', 'cartier_watch_1.jpg', 'cartier_watch_1.jpg', 'Length: 8 in\r\nWidth: 0.75 in', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`) VALUES
(1, 'heyhey'),
(2, 'audrey@gmail.com'),
(3, 'yoohoo'),
(4, 'yyyyy'),
(5, 'hehe'),
(6, 'hellos'),
(7, 'fds'),
(8, 'hey'),
(9, 'test'),
(10, 'isworking?'),
(11, 'sjl'),
(12, ''),
(13, 'heyhye');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `email`, `dob`) VALUES
(1, '$2y$10$RMB7TQRMxxaIBJxfX5h75.YZUBAQLdMDEemfd4w2okMwl7B8XBNOi', 'ruth142976@gmail.com', '2023-10-14'),
(2, '$2y$10$ktRY3OLcrUq0R8Kre1aHq.oDkshWVmCm9Bx8NtLd4gneTJ8PvcoTq', 'i200008@e.ntu.edu.sg', '2023-10-13'),
(3, '$2y$10$Qm0B38rBKCee7PPujg9rhuLWgYWSM3Cvqzo7Sp1RmPEpkoS8tWpQG', 'testing@gmail.com', '2023-11-01'),
(4, '$2y$10$.58CQ.fahuoAjWinJ.BNWuUl2MeBrPojLWDTgNlKfieiUIVOggpUS', 'test@gmail.com', '2023-11-01'),
(5, '$2y$10$Ebn3qKuoMQsnN9hzjELR/eYB9TEefm16YT3f.N8bc22YPe4r2Zegi', 'fds@gmail.com', '2023-11-04'),
(6, '$2y$10$SLNe1bgnNiz/2wgPkMzGD.bugVpzJnfY6xXrqrwtxv6zsacSzPtsW', 'pls@gmail.com', '2023-11-02'),
(7, '$2y$10$ehh6ooWGXWtpr8jJWEJynuFTbk0gCxg.Z.ru3J3akd807Cj6B4qlO', 'eh@test.com', '2023-11-02'),
(8, '$2y$10$wXJHuVgEMT719yop34kRjuEmzUAHJ1lgYjGoWJj5IXngc2fOp7cja', 'test2@gmail.com', '2023-11-02'),
(9, '$2y$10$ycOoqA2lhWq936w7lDQKKOZ4ooNuy6RB1FV0fdEKUrm5jFsA2foVe', 'fdssff@hsjdkf.cm', '2023-11-05'),
(10, '$2y$10$3EboDHCWdjhO3KAmQSoneeDQsZ/ayJA7Rs2yYG68.//fOXn14iZj.', 'howcan@fsd.vd', '2023-11-01'),
(11, '$2y$10$sOsz8WhwcrYVj9PHiHvotOUZvO8AbsC6U6xSYtiAXDit9dq6jnstC', 'new@gmail.com', '2023-11-01'),
(12, '$2y$10$B5wFrQvgdYFM29b8GbIBYuqzkmZ39q2pN0hTkXizQgBFbl0n8Sqzi', 'ljsadfl@hmail.com', '2023-11-01'),
(13, '$2y$10$o05QUm4sMCqFn4uVTgZrYOFPfVQGISlZ8zCRuxhvZvHiUeFPgUn3q', 'heyyo@gmail.com', '2023-11-01'),
(14, '$2y$10$v6bj9VvfWFUa84pqWAmUTevRTOBd9xBENv9.whEd6cmaPRCX0LWwi', 'testing100@mail.com', '2023-11-01'),
(15, '$2y$10$stdoh5X2H90d9OmcSh27S.V1mO3NgdJf0b/uX3KOlXJtmJ24xcuBa', 'testing10q0@mail.com', '2023-11-01'),
(16, '$2y$10$jB1Pem0KHGBNDvLRsA4M4.p8CI3BKiZAIJuXGTwV0kGrg3szaC2SC', 'testing10dsq0@mail.com', '2023-11-01'),
(17, '$2y$10$ib3c2J2SkwEBghziREdmjeX58qoH5ctlZXB2NSLNGWSFz//w3M1Ye', 'testing10dsdsq0@mail.com', '2023-11-01'),
(18, '$2y$10$PWEcsgpG8B73v9h/LZqPcuFIpMO/PIhTTFd21d1wsTZVHoahsqhVu', 'te@gmail.com', '2023-11-01'),
(19, '$2y$10$Y.Xdg1gguoMa.FraN1z7hOuKM21AC.RID6KrhFtDNk79sO0Er4eDm', 'te@gmail.comd', '2023-11-01'),
(20, '$2y$10$YRST1jsDLK0JlKwqRoGM/.W3JTYUqeI.9fiVGNzQPgQwayub/ytCK', 'ssdsddfs@gmail.com', '2023-11-01'),
(21, '$2y$10$kr6/anFUN54pjFzQO60eTuxZ3C7wUxo0UxHrA7MilzYq/TGXX.esO', 'plsssss@gmail.com', '2023-11-02'),
(22, '$2y$10$yao.JEKBwPMe2zlpU9OG.eVzOQ0JWfPV3WIKPAn0HpJ6HCboiGi7e', 'change@gmail.com', '2023-11-01'),
(23, '$2y$10$19eH66Yo1Js/uNsKEQm7mO6Av7yG8UvruEN1lkls52T7aXUMVaIWG', 'a@gmail.com', '2023-11-01'),
(24, '$2y$10$iXTtSFcwNiHbjEHs9LyfqOmhPptGnWQGcaPSaySbhLAnZkPG9LEjy', 'audrey.lcy4@gmail.com', '2023-11-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `checkout_details`
--
ALTER TABLE `checkout_details`
  ADD PRIMARY KEY (`checkout_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
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
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `checkout_details`
--
ALTER TABLE `checkout_details`
  MODIFY `checkout_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51284;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
