-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 29, 2019 lúc 03:21 PM
-- Phiên bản máy phục vụ: 10.4.8-MariaDB
-- Phiên bản PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `computer`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `phone` char(15) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `level` tinyint(4) DEFAULT 1,
  `avatar` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `name`, `address`, `email`, `password`, `phone`, `status`, `level`, `avatar`, `created_at`, `updated_at`) VALUES
(9, 'Phan Công Tài', 'Đà Nẵng', 'phancongtaicntt2@gmail.com', '3d2326d4ff44929b3ffcd526c1a7870f', '0899086844', 1, 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cartitems`
--

CREATE TABLE `cartitems` (
  `id` int(11) NOT NULL,
  `shoppingcart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `cartitems`
--

INSERT INTO `cartitems` (`id`, `shoppingcart_id`, `product_id`, `qty`) VALUES
(17, 2, 7, 3);

--
-- Bẫy `cartitems`
--
DELIMITER $$
CREATE TRIGGER `InsertCartItemsTrigger` BEFORE INSERT ON `cartitems` FOR EACH ROW BEGIN
    DECLARE sl_co INT;
    
    SELECT number
    INTO sl_co
    FROM product WHERE id=new.product_id;
    
    IF sl_co < new.qty THEN
		SIGNAL SQLSTATE '45000'
  		SET MESSAGE_TEXT = 'You can not insert record';
    ELSE
        UPDATE product
         SET number=number-new.qty
         WHERE id=new.product_id; 
    END IF; 
 
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_cartitems_delete` AFTER DELETE ON `cartitems` FOR EACH ROW UPDATE product
SET number = number + old.qty
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_cartitems_update` BEFORE UPDATE ON `cartitems` FOR EACH ROW BEGIN
    DECLARE sl_co INT;
    SELECT number INTO sl_co FROM product WHERE id=new.product_id;
    IF sl_co < (new.qty-old.qty) THEN SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'You can not insert record';
    ELSE UPDATE product SET number=number-(new.qty-old.qty) WHERE id=new.product_id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `images` varchar(100) DEFAULT NULL,
  `banner` varchar(100) DEFAULT NULL,
  `home` tinyint(4) DEFAULT 0,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`, `slug`, `images`, `banner`, `home`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Asus', 'asus', NULL, NULL, 1, 1, '2019-12-01 02:06:06', '2019-12-28 16:16:16'),
(7, 'Macbook', 'macbook', NULL, NULL, 1, 1, '2019-12-01 02:07:13', '2019-12-27 06:05:04'),
(8, 'Dell', 'dell', NULL, NULL, 1, 1, '2019-12-01 13:18:32', '2019-12-03 14:04:39'),
(10, 'HP', 'hp', NULL, NULL, 0, 1, '2019-12-01 13:54:31', '2019-12-01 13:54:31'),
(11, 'Lenovo', 'lenovo', NULL, NULL, 1, 1, '2019-12-02 03:26:08', '2019-12-03 14:04:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` tinyint(4) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `transaction_id`, `product_id`, `qty`, `price`, `created_at`, `updated_at`) VALUES
(22, 13, 6, 2, 45125000, NULL, NULL),
(23, 13, 10, 1, 33570800, NULL, NULL),
(24, 14, 12, 1, 19990000, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `sale` tinyint(4) DEFAULT 0,
  `thunbar` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `number` int(11) NOT NULL DEFAULT 0,
  `head` int(11) DEFAULT 0,
  `view` int(11) DEFAULT 0,
  `hot` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `pay` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `name`, `slug`, `price`, `sale`, `thunbar`, `category_id`, `content`, `number`, `head`, `view`, `hot`, `created_at`, `updated_at`, `pay`) VALUES
(5, 'Macbook Pro Retina 15inch 2019', 'macbook-pro-retina-15inch-2019', 44000000, 0, 'macpro.png', 7, 'Macbook Pro 13inch - 15inch model 2019. Bảo hành 06 đến 12 tháng - Ship hàng toàn quốc - Miễn phí cài đặt phần mềm', 14, 0, 0, 0, NULL, '2019-12-29 12:45:34', 0),
(6, 'MacBook Pro Retina 15inch TouchBar', 'macbook-pro-retina-15inch-touchbar', 47500000, 5, 'mac-pro-2018.png', 7, 'Bảo hành phần cứng 12 tháng\r\n• Hỗ trợ:\r\n- Bảo dưỡng phần cứng\r\n- Cài đặt phần mềm\r\n- Xử lý các lỗi người dùng\r\n• Tặng bao da HNMac trị giá 400k\r\n• Giảm giá phụ kiện lên đến 20% khi mua cùng máy\r\n• Tặng Voucher 200k cho lần mua máy tiếp theo', 4, 0, 0, 0, NULL, '2019-12-29 12:45:34', 1),
(7, 'MacBook Pro 2011 - MC700', 'macbook-pro-2011---mc700', 7900000, 0, 'mac-pro-2011.png', 7, '- CPU: 2.3 Intel Core i5 3MB L3 Cache\r\n- RAM: 4GB 1333MHZ DDR3\r\n- Màn hình: 13.3-inch;\r\n- Độ phân giải: 1280 X 800\r\n- Graphics: Intel HD 3000\r\n- Dung lượng: HDD 320GB\r\n- Cổng mạng: Wireless 802.11n WiFi & Bluetooth 4.0\r\n- Khe cắm: Dual USB 3.0 Ports & Thunderbolt Port\r\n- Hệ điều hành: Includes Mac OS X 10.9 or OS X 10.8', 2, 0, 0, 0, NULL, '2019-12-29 12:54:57', 1),
(8, 'Laptop Dell Inspiron 3480', 'laptop-dell-inspiron-3480', 14899000, 0, 'dell1.jpg', 8, 'Cấu hình:\r\n\r\nCPU: Intel Core i5-8265U (1.6Ghz x 4) 3MB L3 cache\r\n\r\nRAM: 8GB, DDR4 2666 MHz\r\n\r\nĐĩa cứng: 256GB - SSD\r\n\r\nMàn hình: 14 inch HD (1366 x 768)\r\n\r\nĐồ họa: intel UHD 620\r\n\r\nHĐH: Win 10', 14, 0, 0, 0, NULL, '2019-12-29 12:45:34', 0),
(9, 'Dell Precision M5510 Xeon E3-1505', 'dell-precision-m5510-xeon-e3-1505', 24500000, 12, 'dell2.jpg', 8, 'Bảo hành 12 tháng phần cứng  . Miễn phí vệ sinh + cài đặt trọn đời máy\r\n\r\nHoàn 100% tiền nếu phát sinh lỗi trong 15 ngày đầu\r\nBảo hành miễn phí cả cháy nổ ic (các nơi khác từ chối bảo', 7, 0, 0, 0, NULL, '2019-12-29 12:45:34', 1),
(10, 'DELL XPS 15 9570 i7-8750H', 'dell-xps-15-9570-i7-8750h', 36490000, 8, 'dell4.jpg', 8, 'Bộ xử lý: Intel Core i7-8750H tốc độ 2.2Ghz- Max 4.1 Ghz\r\nBộ nhớ RAM: 8GB DDR4 2666 MHz\r\nỔ cứng SSD 256GB\r\nVGA: Nvidia Geforce GTX 1050Ti 4GB DDR5 VRAM\r\nMàn hình: 15.6″ Full HD 1920 x 1080\r\nWindows 10 64bit bản quyền\r\nTrọng lượng: khoảng 1.9 kg (có Pin)\r\nBảo hành 12 tháng. 7 ngày đổi trả nếu có lỗi từ nhà sản xuất.', 4, 0, 0, 0, NULL, '2019-12-29 12:45:34', 2),
(11, 'Dell Inspiron G7 N7591', 'dell-inspiron-g7-n7591', 29190000, 0, 'dell5.png', 8, 'Tặng Chuột không dây Zadez M390 Xem chi tiết\r\nKhách hàng được khuyến mại thêm:\r\n\r\nCơ hội trúng 10 chiếc iPhone 11 Xem chi tiết\r\nTặng Balo Laptop\r\nMua Combo Sinh viên: Office 365 Personal + Lạc Việt giá chỉ còn 690,000 đồng\r\nGiảm 20% Combo bảo vệ Laptop (Combo MDMH và Phần mềm Diệt virus Eset) khi mua kèm máy', 9, 0, 0, 0, NULL, '2019-12-29 12:45:34', 0),
(12, 'Asus ROG Strix G531GD-AL025T', 'asus-rog-strix-g531gd-al025t', 19990000, 0, 'asus1.jpg', 6, '- Balo Asus ROG Gaming trị giá 500.000đ\r\n- Mouse gaming LEG RGB chính hãng.\r\n- Lót chuột size XXXL\r\n- Túi chống sốc cao cấp\r\n- Bộ vệ sinh Laptop với 4 công cụ', 9, 0, 0, 0, NULL, '2019-12-29 12:45:34', 0),
(13, 'Surface Laptop', 'surface-laptop', 22500000, 5, 'asus2.jpg', 6, 'Bộ Office 365 Full bản quyền trọn đời trị giá 1.000.000 đ\r\nMiếng dán màn hình cường lực Sparin trị giá 500.000 đ\r\nDây Mini DisplayPort to HDMI dùng để kết nối Tivi hoặc máy chiếu\r\nHub USB 3 in 1\r\nGiảm giá 10% khi mua phụ kiện Surface', 11, 0, 0, 0, NULL, '2019-12-29 12:45:34', 0),
(14, 'HP EliteBook 840', 'hp-elitebook-840', 15490000, 0, 'hp1.png', 10, 'CPU: Intel® Core™ i7 6600U 4M bộ nhớ đệm, lên đến 3.40 GHz\r\nRAM: 8GB DDR4 SDRAM 2133MHz\r\nĐĩa cứng: SSD 256GB\r\nMàn hình: 14 inch FHD (1920 x 1080 pixels) LED Backlit Display \r\nCard đồ họa: Intel® HD Graphics 520', 20, 0, 0, 0, NULL, '2019-12-29 12:45:34', 0),
(15, 'Laptop HP Probook 440 G6', 'laptop-hp-probook-440-g6', 17690000, 10, 'hp2.jpg', 10, 'Hệ điều hành: Windows 10 Home 64\r\n\r\nBộ xử lý: 8th Generation Intel Core i5 processor\r\n\r\nRam: 8 GB DDR4-2400 SDRAM (1 x 8 GB)\r\n\r\nỔ cứng: 256 GB PCIe NVMe SSD\r\n\r\nĐồ họa: Intel UHD Graphics 620', 8, 0, 0, 0, NULL, '2019-12-29 12:45:34', 0),
(16, 'Laptop Lenovo IdeaPad S340', 'laptop-lenovo-ideapad-s340', 14659000, 20, 'lenovo1.jpg', 11, 'CPU: Intel Core i5-8265U 1.6GHz up to 3.9GHz 6MB\r\n\r\nRAM: 4GB DDR4 2400MHz (1 x SO-DIMM socket, up to 12GB SDRAM)\r\n\r\nỔ cứng: HDD 1TB 5400rpm, x 1 slot SSD M.2 SATA\r\n\r\nCard đồ họa: NVIDIA GeForce MX230 2GB GDDR5 + Intel UHD Graphics 620\r\n\r\nMàn hình: 15.6\" FHD (1920 x 1080) Anti-Glare\r\n\r\nCổng giao tiếp: 2 x USB 3.0, 1 x USB 3.0 Type-C, HDMI,RJ45\r\n\r\nHệ điều hành: Windows 10 Home\r\n\r\nPin: 3 Cells 52.5WHrs', 4, 0, 0, 0, NULL, '2019-12-29 12:45:34', 0),
(17, 'Lenovo Thinkpad T460S Core i5 6300U', 'lenovo-thinkpad-t460s-core-i5-6300u', 12800000, 0, 'lenovo2.jpg', 11, 'Bảo hành toàn bộ 12 tháng phần cứng  . Miễn phí vệ sinh + cài đặt trọn đời máy\r\n\r\nHoàn 100% tiền nếu phát sinh lỗi trong 15 ngày đầu.\r\nBảo hành miễn phí cả cháy nổ ic (các nơi khác từ chối bảo hành).\r\n\r\n Thế giới số 365 bảo hành toàn bộ phần cứng máy. Không bảo hành mập mờ (pin + màn hình) đều được bảo hành 01 năm không như một số cửa hàng khác bảo hành riêng từng linh kiện\r\nThegioiso365 không cộng thêm tiền webcam, bảo mật vân tay, bàn phím sáng như các nơi khác', 9, 0, 0, 0, NULL, '2019-12-29 12:45:34', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shoppingcart`
--

CREATE TABLE `shoppingcart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `shoppingcart`
--

INSERT INTO `shoppingcart` (`id`, `user_id`, `status`) VALUES
(2, 5, 0),
(6, 4, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `note` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `transaction`
--

INSERT INTO `transaction` (`id`, `amount`, `users_id`, `status`, `created_at`, `updated_at`, `note`) VALUES
(13, 111438720, 4, 1, '2019-12-29 12:26:01', '2019-12-29 12:26:12', 'giao nhanh nhanh ti'),
(14, 18990500, 4, 0, '2019-12-29 12:38:33', NULL, 'qua hay');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` char(15) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `token` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `password`, `avatar`, `status`, `token`, `created_at`, `update_at`) VALUES
(4, 'Ngô Quang Trưởng', 'truong@gmail.com', '0123456789', 'Tổ 10 Gia lai', '32e8512c007faaf409e0845a6f6a980d', NULL, 1, NULL, NULL, NULL),
(5, 'Hoàng Thị Kim Ngân', 'ngan@gmail.com', '0124578963', 'DakLak', 'fbf4f0ed9ac707753b9049f0626c0b5d', NULL, 1, NULL, NULL, NULL),
(6, 'Nguyễn Trung Sỹ', 'sy@gmail.com', '09050123456', 'Tổ 11 Gia Lai', 'cdda402411f2fcc964edf28655567d13', NULL, 1, NULL, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shoppingcart_id` (`shoppingcart_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `cartitems`
--
ALTER TABLE `cartitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `shoppingcart`
--
ALTER TABLE `shoppingcart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cartitems`
--
ALTER TABLE `cartitems`
  ADD CONSTRAINT `cartitems_ibfk_1` FOREIGN KEY (`shoppingcart_id`) REFERENCES `shoppingcart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
