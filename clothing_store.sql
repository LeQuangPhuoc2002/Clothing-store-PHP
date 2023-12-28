-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 28, 2023 lúc 03:08 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `clothing_store`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `phonenumber` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_username`, `admin_password`, `phonenumber`, `email`, `name`) VALUES
(1, 'phuoc', '123', '9999999999', 'phuoc@gmail.com', 'Quang Phuoc'),
(2, 'nhan', '123', '1111111111', 'nhan@gmail.com', 'Thanh Nhan');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 17),
(16, 18),
(18, 21),
(20, 23),
(21, 24),
(22, 25),
(23, 26),
(24, 27);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_item`
--

CREATE TABLE `cart_item` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart_item`
--

INSERT INTO `cart_item` (`cart_item_id`, `cart_id`, `product_id`, `quantity`) VALUES
(517, 1, 70, 1),
(518, 1, 69, 1),
(519, 16, 70, 1),
(520, 16, 69, 1),
(543, 1, 5, 3),
(555, 1, 103, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_image`) VALUES
(1, 'Áo Nam', 'image1.jpeg'),
(2, 'Quần Nam', 'image2.jpeg'),
(3, 'Giày', 'image3.jpeg'),
(4, 'Áo khoác', 'image4.jpeg'),
(5, 'Áo nữ', 'image5.jpeg'),
(6, 'Quần nữ', 'image6.jpeg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_text` text DEFAULT NULL,
  `time_create` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`comment_id`, `product_id`, `user_id`, `comment_text`, `time_create`) VALUES
(1, 1, 1, 'Sản phẩm này tuyệt với quá', '2023-12-21 09:47:47'),
(3, 68, 1, 'ádasd', '2023-12-21 11:43:03'),
(4, 68, 1, 'sadasd', '2023-12-21 11:43:07'),
(5, 68, 1, 'sadasdádasd', '2023-12-21 11:46:26'),
(6, 68, 1, 'dsadsad', '2023-12-21 11:57:07'),
(7, 68, 1, 'sadsad', '2023-12-21 12:03:56'),
(8, 69, 1, 'đâsd', '2023-12-21 12:04:08'),
(9, 66, 1, 'sadasd', '2023-12-21 12:05:53'),
(10, 69, 1, 'Sản phẩm oke quá shop ơi\r\n', '2023-12-21 12:13:16'),
(11, 70, 18, 'hello\r\n', '2023-12-24 07:12:37'),
(12, 70, 23, 'sadasd', '2023-12-24 12:33:42'),
(13, 103, 25, 'san phẩm này tuyệt quá', '2023-12-25 15:54:31'),
(14, 68, 23, 'sản phẩm này rát tuyệt', '2023-12-25 15:55:43'),
(15, 68, 27, 'Sản phẩm này tmaj được ', '2023-12-25 16:06:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `order_address` varchar(255) DEFAULT NULL,
  `image_order` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order`
--

INSERT INTO `order` (`order_id`, `user_id`, `status_id`, `order_date`, `order_address`, `image_order`) VALUES
(1, 1, 3, '2023-12-22 19:28:16', '1 nguyễn Trãi', 'image1.jpeg'),
(2, 2, 3, '2023-12-15 19:28:52', '35 Nguyễn Huệ', 'image2.jpg'),
(3, 2, 3, '2023-12-25 13:49:16', '123 le lơi', 'image6.webp'),
(15, 2, 1, '2023-12-25 14:13:34', '35 nguyễn trãi', ''),
(16, 2, 3, '2023-12-25 16:24:54', '35 nguyễn huệ', 'image10.webp'),
(17, 23, 3, '2023-12-25 16:56:26', '1233 ông ích khiêm', 'shipper-giao-hang-nhanh_e081eeb73c004ecfa638eb4b90a20cd5_grande.webp'),
(18, 27, 1, '2023-12-25 17:07:38', '1222 nguyesxn trường tộ', ''),
(19, 21, 3, '2023-12-25 17:11:05', '23i123jijsadasd', 'meo-ship-hang-an-toan-cho-cac-shop-online-707x400.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_detail`
--

CREATE TABLE `order_detail` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `order_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_detail`
--

INSERT INTO `order_detail` (`order_detail_id`, `order_id`, `product_id`, `order_quantity`) VALUES
(1, 1, 1, 2),
(2, 1, 2, 1),
(3, 2, 3, 3),
(4, 2, 4, 2),
(5, 3, 36, 2),
(7, 15, 103, 2),
(8, 15, 69, 1),
(9, 16, 101, 2),
(10, 16, 68, 2),
(11, 16, 64, 1),
(12, 17, 69, 3),
(13, 17, 103, 3),
(14, 18, 67, 3),
(15, 19, 15, 3),
(16, 19, 4, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `price`, `category_id`, `image`, `image2`, `image3`, `description`, `quantity`) VALUES
(1, 'Áo Polo Nam', 2999, 1, 'image1_1.png', 'image1_2.png', 'image1_3.png', '0', 100),
(2, 'Quần Jeans Nam', 3999, 2, 'image2_1.jpg', 'image2_2.png', 'image2_3.png', 'Quần Jeans Nam có kiểu dáng hiện đại, chất liệu thoáng khí và thoải mái, là sự lựa chọn hoàn hảo cho phong cách cá nhân.', 80),
(3, 'Giày Sneakers nike', 4999, 3, 'image3_1.jpg', 'image3_2.jpg', 'image3_3.jpg', 'Giày Sneakers với thiết kế đẹp mắt, êm ái và bền bỉ, là sự kết hợp hoàn hảo giữa thời trang và thoải mái.', 120),
(4, 'Áo Khoác Đông', 5999, 4, 'image4_1.png', 'image4_2.png', 'image4_3.png', 'Áo Khoác Đông chống nước và giữ ấm tốt, là sự lựa chọn tuyệt vời cho những ngày lạnh giá.', 60),
(5, 'Áo Polo GolfBaudi Nam', 4599, 1, 'image5_1.png', 'image5_2.png', 'image5_3.png', 'Áo Polo Golf Nam với chất liệu chống nắng, phù hợp cho mọi sân golf.', 90),
(6, 'Quần ba tư Nike Nam', 3599, 2, 'image6_1.jpg', 'image6_2.jpg', 'image6_3.png', 'Quần Linen Nam với chất liệu nhẹ và thoáng khí, là lựa chọn tuyệt vời cho mùa hè.', 100),
(7, 'Giày Mules Nike 2 dây', 4999, 3, 'image7_1.jpg', 'image7_2.jpg', 'image7_3.jpg', 'Dép Mules với thiết kế đơn giản, thoải mái cho những bước đi dạo phố.', 120),
(8, 'Áo Khoác Puffer blue water', 5999, 4, 'image8_1.png', 'image8_2.png', 'image8_3.png', 'Áo Khoác Puffer với lớp đệm ấm áp, giữ ấm hiệu quả trong mùa đông.', 80),
(9, 'Áo Hoodie Nữ', 2599, 5, 'image9_1.png', 'image9_2.png', 'image9_3.png', 'Áo Hoodie Nữ với thiết kế thoải mái và ấm áp, phù hợp cho mùa đông.', 80),
(10, 'Quần Legging Nữ', 1799, 6, 'image10_1.jpg', 'image10_2.jpg', 'image10_3.jpg', 'Quần Legging Nữ với chất liệu co giãn, ôm sát cơ thể và thoải mái cho hoạt động thể thao.', 120),
(11, 'Giày thắp Gót', 5999, 3, 'image11_1.jpg', 'image11_2.jpg', 'image11_3.jpg', 'Giày Cao Gót với kiểu dáng sang trọng, phù hợp cho những dịp đặc biệt.', 50),
(12, 'Áo Thun Nam', 1899, 1, 'image12_1.png', 'image12_2.png', 'image12_3.png', 'Áo Thun Nam kiểu dáng đơn giản, phù hợp cho mọi hoạt động hàng ngày.', 150),
(13, 'Quần Jogger Nam', 2499, 2, 'image13_1.jpg', 'image13_2.jpg', 'image13_3.jpg', 'Quần Jogger Nam với phong cách thể thao và thoải mái, là sự lựa chọn tuyệt vời cho mọi dịp.', 100),
(14, 'Giày Bốt Đinh Tán', 6999, 3, 'image14_1.jpg', 'image14_2.jpg', 'image14_3.jpg', 'Giày Bốt Đinh Tán với kiểu dáng cá tính, phù hợp cho những ngày lạnh.', 70),
(15, 'Áo Sơ Mi Nữ', 3299, 5, 'image15_1.png', 'image15_2.png', 'image15_3.png', 'Áo Sơ Mi Nữ với thiết kế thanh lịch, phù hợp cho công việc và các sự kiện quan trọng.', 90),
(16, 'Quần Charlotes Nữ', 2199, 6, 'image16_1.jpg', 'image16_2.jpg', 'image16_3.jpg', 'Quần Charlotes Nữ với kiểu dáng rộng rãi và thoải mái, là sự lựa chọn thời trang cho mùa hè.', 110),
(17, 'Quần Linen Nam', 3599, 2, 'image17_1.jpg', 'image17_2.jpg', 'image17_3.jpg', 'Quần Linen Nam với chất liệu nhẹ và thoáng khí, là lựa chọn tuyệt vời cho mùa hè.', 100),
(18, 'Giày Mules', 4999, 3, 'image18_1.jpg', 'image18_2.jpg', 'image18_3.jpg', 'Dép Mules với thiết kế đơn giản, thoải mái cho những bước đi dạo phố.', 120),
(19, 'Áo Khoác Puffer', 5999, 4, 'image19_1.png', 'image19_2.png', 'image19_3.png', 'Áo Khoác Puffer với lớp đệm ấm áp, giữ ấm hiệu quả trong mùa đông.', 80),
(20, 'Áo Polo Nam healer', 2999, 1, 'image20_1.png', 'image20_2.png', 'image20_3.png', 'Áo Polo Nam là một sản phẩm chất lượng với thiết kế thời trang, phù hợp cho mọi dịp.', 100),
(21, 'Quần Nam ống dài ngắn rút gọn', 3999, 2, 'image21_1.jpg', 'image21_2.jpg', 'image21_3.jpg', 'Quần Nam chất liệu thoáng khí và thoải mái, phù hợp cho mọi hoạt động.', 80),
(22, 'Giày Sneakers', 4999, 3, 'image22_1.jpg', 'image22_2.jpg', 'image22_3.jpg', 'Giày Sneakers với thiết kế đẹp mắt, êm ái và bền bỉ, là sự kết hợp hoàn hảo giữa thời trang và thoải mái.', 120),
(23, 'Áo Khoác Đông có cổ áo bẻ', 5999, 4, 'image23_1.png', 'image23_2.png', 'image23_3.png', 'Áo Khoác Đông chống nước và giữ ấm tốt, là sự lựa chọn tuyệt vời cho những ngày lạnh giá.', 60),
(24, 'Quần Jean Skinny Nam', 3799, 2, 'image24_1.jpg', 'image24_2.jpg', 'image24_3.jpg', 'Quần Jean Skinny Nam ôm sát cơ thể, kiểu dáng thời trang.', 80),
(25, 'Giày Sandals Nữ', 2899, 3, 'image25_1.jpg', 'image25_2.jpg', 'image25_3.jpg', 'Giày Sandals Nữ với kiểu dáng thoải mái, phù hợp cho mùa hè năng động.', 120),
(26, 'Áo Khoác Dù Unisex', 4999, 4, 'image26_1.png', 'image26_2.png', 'image26_3.png', 'Áo Khoác Dù Unisex chống nước, phù hợp cho mọi hoạt động ngoại ô.', 70),
(27, 'Áo Polo Golf Nam', 3899, 1, 'image27_1.png', 'image27_2.png', 'image27_3.png', 'Áo Polo Golf Nam với chất liệu thoáng khí, phù hợp cho mọi sân golf.', 100),
(28, 'Quần Jogger Nữ có nút', 3199, 6, 'image28_1.jpg', 'image28_2.jpg', 'image28_3.jpg', 'Quần Jogger Nữ thoải mái và phong cách, là lựa chọn tốt cho mọi hoạt động.', 110),
(29, 'Giày Loafer', 4499, 3, 'image29_1.jpg', 'image29_2.jpg', 'image29_3.jpg', 'Giày Loafer với kiểu dáng lịch lãm, phù hợp cho công việc và các sự kiện quan trọng.', 50),
(30, 'Áo Khoác Bomber Unisex', 5399, 4, 'image30_1.png', 'image30_2.png', 'image30_3.png', 'Áo Khoác Bomber Unisex với kiểu dáng thời trang, là sự kết hợp hoàn hảo giữa thoải mái và phong cách.', 80),
(31, 'Quần Short Nam có thắc nịt', 1699, 2, 'image31_1.jpg', 'image31_2.jpg', 'image31_3.jpg', 'Quần Short Nam với chất liệu thoáng khí, phù hợp cho mùa hè năng động.', 120),
(32, 'Giày Sneakers Nữ', 4599, 3, 'image32_1.jpg', 'image32_2.jpg', 'image32_3.jpg', 'Giày Sneakers Nữ với kiểu dáng thời trang và thoải mái, là sự kết hợp hoàn hảo.', 100),
(33, 'Áo Vest Nam', 6299, 1, 'image33_1.png', 'image33_2.png', 'image33_3.png', 'Áo Vest Nam với kiểu dáng lịch lãm, phù hợp cho các dịp quan trọng.', 60),
(34, 'Áo Khoác Jean Nữ', 3799, 4, 'image34_1.png', 'image34_2.png', 'image34_3.png', 'Áo Khoác Jean Nữ với kiểu dáng trẻ trung, là một item thời trang không thể thiếu.', 80),
(35, 'Quần Culottes Nam', 2999, 2, 'image35_1.jpg', 'image35_2.jpg', 'image35_3.jpg', 'Quần Culottes Nam với kiểu dáng độc đáo, phù hợp cho những ngày thoải mái.', 90),
(36, 'Giày Oxford', 5399, 3, 'image36_1.jpg', 'image36_2.jpg', 'image36_3.jpg', 'Giày Oxford với kiểu dáng thanh lịch, phù hợp cho công việc và các sự kiện quan trọng.', 50),
(37, 'Áo Khoác Denim Unisex', 4899, 4, 'image37_1.png', 'image37_2.png', 'image37_3.png', 'Áo Khoác Denim Unisex với chất liệu jean bền đẹp, phù hợp cho mọi loại trang phục.', 70),
(38, 'Quần Culottes Nữ', 2899, 6, 'image38_1.jpg', 'image38_2.jpg', 'image38_3.jpg', 'Quần Culottes Nữ với kiểu dáng thoải mái và phong cách, là lựa chọn thời trang cho mọi ngày.', 110),
(39, 'Giày Chelsea Boots', 5199, 3, 'image39_1.jpg', 'image39_2.jpg', 'image39_3.jpg', 'Giày Chelsea Boots với kiểu dáng hiện đại, phù hợp cho mọi dịp.', 90),
(40, 'Áo Khoác Hoodie Unisex', 3499, 4, 'image40_1.png', 'image40_2.png', 'image40_3.png', 'Áo Khoác Hoodie Unisex với lớp lót ấm áp, giữ ấm hiệu quả trong mùa đông.', 70),
(41, 'Áo Polo Stripe Nam', 2999, 1, 'image41_1.png', 'image41_2.png', 'image41_3.png', 'Áo Polo Stripe Nam với kiểu dáng thể thao và trẻ trung.', 100),
(42, 'Quần Short Nữ', 1999, 6, 'image42_1.jpg', 'image42_2.jpg', 'image42_3.jpg', 'Quần Short Nữ với chất liệu nhẹ và thoải mái, là lựa chọn tốt cho mùa hè.', 120),
(43, 'Giày Slip-On', 4399, 3, 'image43_1.jpg', 'image43_2.jpg', 'image43_3.jpg', 'Giày Slip-On với thiết kế đơn giản và dễ kết hợp, phù hợp cho mọi trang phục.', 100),
(44, 'Áo Khoác Dù Nữ', 3899, 4, 'image44_1.png', 'image44_2.png', 'image44_3.jpg', 'Áo Khoác Dù Nữ chống nước và gió, là sự lựa chọn hoàn hảo cho mùa đông.', 80),
(45, 'Giày Sneakers Nữ Pastel', 899, 3, 'image45_1.jpg', 'image45_2.jpg', 'image45_3.jpg', 'Giày sneakers nữ màu pastel, kiểu dáng dễ phối hợp.', 120),
(46, 'Áo Hoodie Nam Dáng Rộng có thắt lưng', 999, 1, 'image46_1.png', 'image46_2.png', 'image46_3.png', 'Áo hoodie nam dáng rộng, phong cách streetwear.', 70),
(47, 'Áo Khoác Nữ Dạ Hội', 2499, 4, 'image47_1.png', 'image47_2.png', 'image47_3.png', 'Áo khoác nữ dạ hội với đính kim sa lấp lánh, lựa chọn hoàn hảo cho dịp đặc biệt.', 50),
(48, 'Quần Jeans Nữ Rách', 699, 6, 'image48_1.jpg', 'image48_2.jpg', 'image48_3.jpg', 'Quần jeans nữ kiểu dáng rách, phong cách và năng động.', 90),
(49, 'Áo Khoác Bomber Nam', 1299, 4, 'image49_1.png', 'image49_2.png', 'image49_3.png', 'Áo khoác bomber nam kiểu dáng thời trang, phù hợp cho mùa đông.', 60),
(50, 'Quần Jogger Nữ Chất Lụa', 799, 6, 'image50_1.jpg', 'image50_2.jpg', 'image50_3.jpg', 'Quần jogger nữ chất liệu lụa mềm mại, phù hợp cho dịp đặc biệt.', 80),
(51, 'Giày Sneak Nam vandel', 1099, 3, 'image51_1.jpg', 'image51_2.jpg', 'image51_3.jpg', 'Giày sneakers nam classic với kiểu dáng truyền thống, dễ kết hợp.', 100),
(52, 'Áo Sơ Mi Nữ Đen', 479, 5, 'image52_1.png', 'image52_2.png', 'image52_3.png', 'Áo sơ mi nữ màu đen cơ bản, kiểu dáng đơn giản nhưng thanh lịch.', 90),
(53, 'Áo Hoodie Nữ Dáng Hẹp có tai', 899, 5, 'image53_1.png', 'image53_2.png', 'image53_3.png', 'Áo hoodie nữ dáng rộng với kiểu dáng thoải mái, phù hợp cho mùa thu đông.', 70),
(54, 'Quần Short jean có ống Đùi', 449, 2, 'image54_1.jpg', 'image54_2.jpg', 'image54_3.jpg', 'Quần short nam đùi, phong cách thể thao.', 110),
(55, 'Áo Hoodie Nam có ảo trùm', 899, 1, 'image55_1.png', 'image55_2.png', 'image55_3.png', 'Áo hoodie nam dáng rộng với kiểu dáng thoải mái và phong cách hiện đại. Chất liệu cotton mềm mại, giữ ấm tốt trong mùa đông. Được thiết kế với túi kangaroo trước ngực và nón có dây rút, tạo điểm nhấn cho bản thân và thêm phần phong cách cho outfit của bạn', 80),
(56, 'Quần Jogger shreif Nữ ', 799, 6, 'image56_1.jpg', 'image56_2.jpg', 'image56_3.jpg', 'Quần jogger nữ chất liệu lụa mềm mại, phù hợp cho dịp đặc biệt. Kiểu dáng thoải mái với độ co giãn tốt, giúp bạn thoải mái di chuyển và duy trì phong cách thời trang. Quần có thể kết hợp linh hoạt với nhiều loại áo, phụ kiện khác nhau.', 80),
(57, 'Giày Sneakers Nam Classic', 1099, 3, 'image57_1.jpg', 'image57_2.jpg', 'image57_3.jpg', 'Giày sneakers nam classic với kiểu dáng truyền thống, dễ kết hợp với nhiều loại trang phục khác nhau. Chất liệu da tự nhiên bền bỉ, đế cao su chống trơn trượt, mang lại cảm giác thoải mái và an toàn khi sử dụng. Đây là sự lựa chọn hoàn hảo cho những người', 100),
(58, 'Áo Sơ Mi Nữ có buộc chân', 479, 5, 'image58_1.png', 'image58_2.png', 'image58_3.png', 'Áo sơ mi nữ màu đen cơ bản, kiểu dáng đơn giản nhưng thanh lịch. Chất liệu vải mềm mại, thoáng khí, giúp bạn cảm thấy thoải mái suốt cả ngày. Phù hợp cho nhiều dịp sử dụng, từ công sở đến các buổi gặp gỡ bạn bè.', 90),
(59, 'Áo Hoodie Nữ Dáng Rộng', 799, 5, 'image59_1.png', 'image59_2.png', 'image59_3.png', 'Áo hoodie nữ dáng rộng với kiểu dáng thoải mái, phù hợp cho mùa thu đông. Chất liệu cotton mềm mại, giữ ấm tốt và thoáng khí. Thiết kế trẻ trung với hình in độc đáo, tạo điểm nhấn cho outfit của bạn.', 70),
(60, 'Quần Short Nam Đùi', 449, 2, 'image60_1.jpg', 'image60_2.jpg', 'image60_3.jpg', 'Quần short nam đùi, phong cách thể thao và năng động. Chất liệu vải nhẹ, co giãn tốt, giúp bạn thoải mái vận động. Thiết kế đơn giản nhưng vẫn cá tính, phù hợp cho các hoạt động ngoại ô và các buổi dạo chơi cùng bạn bè.', 110),
(61, 'Áo Polo Nữ Trắng', 379, 5, 'image61_1.png', 'image61_2.png', 'image61_3.png', 'Áo polo nữ màu trắng tinh khôi, kiểu dáng thoải mái và phong cách. Chất liệu cotton thoáng khí, giúp bạn cảm thấy thoải mái trong mọi hoạt động. Phù hợp cho cả các dịp công sở và những buổi gặp gỡ bạn bè.', 90),
(62, 'Quần Jeans Nữ Ống Rộng', 699, 6, 'image62_1.jpg', 'image62_2.jpg', 'image62_3.jpg', 'Quần jeans nữ kiểu dáng ống rộng, phong cách retro và thời trang. Chất liệu denim co giãn, giúp bạn thoải mái di chuyển. Kết hợp cùng áo thun hay áo sơ mi, tạo nên outfit nổi bật.', 80),
(63, 'Giày Sneakers Nữ High-top', 999, 3, 'image63_1.jpg', 'image63_2.jpg', 'image63_3.jpg', 'Giày sneakers nữ high-top với kiểu dáng năng động và phong cách. Chất liệu da tự nhiên cao cấp, đế cao su chống trơn trượt. Thích hợp cho cả những buổi đi chơi và dạo phố.', 120),
(64, 'Áo Khoác Dạ Nam', 1899, 4, 'image64_1.png', 'image64_2.png', 'image64_3.png', 'Áo khoác dạ nam với chất liệu dạ cao cấp, giữ ấm tốt trong những ngày lạnh. Thiết kế sang trọng, phù hợp cho các sự kiện quan trọng hoặc dạo phố. Kết hợp cùng áo thun và quần jeans, tạo nên phong cách đẳng cấp.', 50),
(65, 'Áo Sơ Mi Nữ Caro', 549, 5, 'image65_1.png', 'image65_2.png', 'image65_3.png', 'Áo sơ mi nữ caro với họa tiết trẻ trung và cá tính. Chất liệu vải mềm mại, thoáng khí, phù hợp cho mọi dịp. Kết hợp cùng quần jeans hoặc chân váy, tạo nên phong cách thời trang.', 100),
(66, 'Quần Jogger Nam Nỉ', 799, 2, 'image66_1.jpg', 'image66_2.jpg', 'image66_3.jpg', 'Quần jogger nam nỉ, kiểu dáng thoải mái và ấm áp. Chất liệu nỉ mềm mại, co giãn tốt, phù hợp cho những ngày lạnh. Kết hợp cùng áo thun hay hoodie, tạo nên bộ trang phục thoải mái và trẻ trung.', 110),
(67, 'Áo Sweater Nữ Dáng Dài', 1199, 5, 'image67_1.png', 'image67_2.png', 'image67_3.png', 'Áo sweater nữ dáng dài với chất liệu len mềm mại, giữ ấm tốt trong mùa đông. Thiết kế hiện đại với đường xéo độc đáo và túi kangaroo phía trước. Phù hợp cho cả dịp đi làm hay dạo phố.', 70),
(68, 'Quần Culottes Nữ Linen', 549, 6, 'image68_1.jpg', 'image68_2.jpg', 'image68_3.jpg', 'Quần culottes nữ chất liệu linen thoáng khí và thoải mái. Kiểu dáng rộng rãi và bề thế, phù hợp cho mùa hè năng động. Kết hợp cùng áo thun hoặc áo sơ mi, tạo nên phong cách trẻ trung.', 80),
(69, 'Giày Sneakers Nữ Họa Tiết', 899, 3, 'image69_1.jpg', 'image69_2.jpg', 'image69_3.jpg', 'Giày sneakers nữ với họa tiết độc đáo và màu sắc tươi sáng. Chất liệu cao cấp và đế cao su chống trơn trượt. Thích hợp cho những buổi dạo chơi và các hoạt động ngoại ô.', 100),
(70, 'Áo Khoác Denim Nam', 1599, 4, 'image70_1.png', 'image70_2.png', 'image70_3.png', 'Áo khoác denim nam với chất liệu denim bền bỉ và thời trang. Thiết kế dáng dài, phù hợp cho mùa thu đông. Kết hợp cùng áo thun và quần jeans, tạo nên phong cách nam tính và cá tính.', 60),
(101, 'sadsad', 123, 2, 'image60.jpg', 'image21.webp', 'image13.webp', '0', 123),
(103, 'sad', 123, 1, 'image5.webp', 'image6.webp', 'image2.webp', '0', 123),
(115, 'Áo nam xám', 10, 1, 'image3.webp', 'image5.webp', 'image2.webp', '0', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `status`
--

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL,
  `status_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `status`
--

INSERT INTO `status` (`status_id`, `status_value`) VALUES
(1, 'Đã đặt hàng'),
(2, 'Đang xử lý'),
(3, 'Đã giao hàng'),
(4, 'Đã hủy');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phonenumber` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `phonenumber`, `name`, `email`) VALUES
(1, 'tin', '202cb962ac59075b964b07152d234b70', '1234567890', 'Nguyen Tin', 'tin@gmail.com'),
(2, 'sang', '202cb962ac59075b964b07152d234b70', '9876543210', 'Xuan Sang', 'sang@gmail.com'),
(3, 'Minh', '202cb962ac59075b964b07152d234b70', '777777777', 'Nhat Minh', 'minh@gmail.com'),
(4, '321', '202cb962ac59075b964b07152d234b70', 'sad', '32', 'ádsad@gmail.com'),
(5, 'đứa', '202cb962ac59075b964b07152d234b70', '78788789987897', '213123', 'dsad@gmail.com'),
(6, 'sao', '202cb962ac59075b964b07152d234b70', '78788789987897', '213123', 'sao@gmail.com'),
(7, '123', '202cb962ac59075b964b07152d234b70', '132321321', 'Iphone 19', '123@gmail.com'),
(8, 'ôpp', '202cb962ac59075b964b07152d234b70', '1212122121', 'op', 'oopop@gmail.com'),
(9, 'eq', '202cb962ac59075b964b07152d234b70', '3212333313323', 'qe', 'eq@gmail.com'),
(10, 'sss', '202cb962ac59075b964b07152d234b70', '13267988888', 'sss', 'sss@gmail.com'),
(11, 'f', '202cb962ac59075b964b07152d234b70', '3', '4', 'f@gmail.com'),
(12, '5', '202cb962ac59075b964b07152d234b70', '5', '5', '6@gmail.com'),
(13, '23', '202cb962ac59075b964b07152d234b70', '2323123213123', '23', '23@gmail.com'),
(14, 'y', '202cb962ac59075b964b07152d234b70', '123', 'i', 'y@gmail.com'),
(17, 'ysadasdsadasd', '202cb962ac59075b964b07152d234b70', '5125451651156', 'iádasddsfdsf', 'sadsad21312321y@gmail.com'),
(18, 'ysadaádsdsadasd', '202cb962ac59075b964b07152d234b70', '51254351651156', 'iádaádasdsddsfdsf', 'sadsaádd21312321y@gmail.com'),
(21, 'Trần Hữu Nhật', '2bef214336d1636730f6ad3a5f4c71ba', '100490354243692270736', 'Trần Hữu Nhật Minh', '20t1020460@husc.edu.vn'),
(23, 'Phước', '42f3cab0c12dbb7257bb10390bd40b79', '100094080573830668316', 'Phước Lê Quang', '20t1020652@husc.edu.vn'),
(24, 'Tín', '97d3d439e9aae230b7620b1f2ed86d67', '113171407385834088765', 'Tín Nguyễn Văn', '20t1020110@husc.edu.vn'),
(25, 'dung', '202cb962ac59075b964b07152d234b70', '090123123123', 'dung', 'dung@gmail.com'),
(26, 'tao', '202cb962ac59075b964b07152d234b70', '1231232131', 'tao', 'tao@gmail.com'),
(27, 'nguyendung', '202cb962ac59075b964b07152d234b70', '0912131231', 'nguyendung', 'nguyendung@gmail.com');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Chỉ mục cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=561;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`),
  ADD CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`);

--
-- Các ràng buộc cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`),
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
