-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 24, 2024 at 07:52 AM
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
-- Database: shop_db
--

-- --------------------------------------------------------

--
-- Table structure for table cart
--

CREATE TABLE cart (
  id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  pid int(11) NOT NULL,
  name varchar(100) NOT NULL,
  price int(11) NOT NULL,
  quantity int(11) NOT NULL,
  image varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table cart
--

INSERT INTO cart (id, user_id, pid, name, price, quantity, image) VALUES
(129, 14, 16, 'lavendor rose', 13, 1, 'lavendor rose.jpg'),
(130, 14, 18, 'red tulipa', 11, 1, 'red tulipa.jpg'),
(131, 14, 15, 'cottage rose', 15, 1, 'cottage rose.jpg'),
(132, 15, 13, 'pink rose', 10, 1, 'pink roses.jpg'),
(133, 15, 15, 'cottage rose', 15, 1, 'cottage rose.jpg'),
(134, 15, 16, 'lavendor rose', 13, 3, 'lavendor rose.jpg'),
(136, 16, 15, 'Cappuchino', 15, 4, 'Cappuchino.png');

-- --------------------------------------------------------

--
-- Table structure for table message
--

CREATE TABLE message (
  id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  name varchar(100) NOT NULL,
  email varchar(100) NOT NULL,
  number varchar(12) NOT NULL,
  message varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table message
--

INSERT INTO message (id, user_id, name, email, number, message) VALUES
(13, 14, 'shaikh anas', 'shaikh@gmail.com', '0987654321', 'hi, how are you?');

-- --------------------------------------------------------

--
-- Table structure for table orders
--

CREATE TABLE orders (
  id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  name varchar(100) NOT NULL,
  number varchar(12) NOT NULL,
  method varchar(50) NOT NULL,
  address varchar(500) NOT NULL,
  total_products varchar(1000) NOT NULL,
  total_price int(11) NOT NULL,
  placed_on varchar(50) NOT NULL,
  payment_status varchar(20) NOT NULL DEFAULT 'pending',
  card_number varchar(19) DEFAULT NULL,
  expiry_date varchar(5) DEFAULT NULL,
  cvv varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table orders
--

INSERT INTO orders (id, user_id, name, number, method, address, total_products, total_price, placed_on, payment_status, card_number, expiry_date, cvv) VALUES
(17, 14, 'shaikh anas', '0987654321', 'credit card', 'flat no. 321, jogeshwari, mumbai, india - 654321', ', cottage rose (3) , pink bouquet (1) , yellow queen rose (1) ', 80, '11-Mar-2022', 'pending', NULL, NULL, NULL),
(18, 14, 'shaikh anas', '1234567899', 'paypal', 'flat no. 321, jogeshwari, mumbai, india - 654321', ', yellow queen rose (1) , pink rose (2) ', 40, '11-Mar-2022', 'completed', NULL, NULL, NULL),
(19, 16, '', '', 'credit card', 'flat no. , , ,  - ', ', Cappuchino (5) ', 75, '22-Aug-2024', 'pending', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table products
--

CREATE TABLE products (
  id int(11) NOT NULL,
  name varchar(100) NOT NULL,
  details varchar(500) NOT NULL,
  price int(11) NOT NULL,
  image varchar(100) NOT NULL,
  quantity int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table products
--

INSERT INTO products (id, name, details, price, image, quantity) VALUES
(13, 'Americano', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque error earum quasi facere optio tenetur.', 12, 'americano.jpeg', 30),
(15, 'Cappuchino', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque error earum quasi facere optio tenetur.', 15, 'Cappuchino.png', -26),
(16, 'Caramel', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Rem, nobis tenetur voluptatibus officiis odit minus fugit dolore accusantium fuga ipsa!', 13, 'Caramel.jpeg', 20),
(17, 'Mocha', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque error earum quasi facere optio tenetur.', 14, 'Mochareal.png', 20),
(18, 'Espresso', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Rem, nobis tenetur voluptatibus officiis odit minus fugit dolore accusantium fuga ipsa!', 11, 'espresso.png', 20),
(19, 'Green Tea', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque error earum quasi facere optio tenetur.', 15, 'greentea.png', 20),
(20, 'Iced Frappe', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque error earum quasi facere optio tenetur.', 24, 'HotChocolate.png', 20);

-- --------------------------------------------------------

--
-- Table structure for table users
--

CREATE TABLE users (
  id int(11) NOT NULL,
  name varchar(100) NOT NULL,
  email varchar(100) NOT NULL,
  password varchar(100) NOT NULL,
  user_type varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table users
--

INSERT INTO users (id, name, email, password, user_type) VALUES
(10, 'admin A', 'admin01@gmail.com', '698d51a19d8a121ce581499d7b701668', 'admin'),
(14, 'user A', 'user01@gmail.com', '698d51a19d8a121ce581499d7b701668', 'user'),
(15, 'user B', 'user02@gmail.com', '698d51a19d8a121ce581499d7b701668', 'user'),
(16, 'mint97', 'mint97@gmail.com', '650cba8ffa4608e759a7ce5ded19eaf8', 'user');

-- --------------------------------------------------------

--
-- Table structure for table wishlist
--

CREATE TABLE wishlist (
  id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  pid int(11) NOT NULL,
  name varchar(100) NOT NULL,
  price int(11) NOT NULL,
  image varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table wishlist
--

INSERT INTO wishlist (id, user_id, pid, name, price, image) VALUES
(60, 14, 19, 'pink bouquet', 15, 'pink bouquet.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table cart
--
ALTER TABLE cart
  ADD PRIMARY KEY (id);

--
-- Indexes for table message
--
ALTER TABLE message
  ADD PRIMARY KEY (id);

--
-- Indexes for table orders
--
ALTER TABLE orders
  ADD PRIMARY KEY (id);

--
-- Indexes for table products
--
ALTER TABLE products
  ADD PRIMARY KEY (id);

--
-- Indexes for table users
--
ALTER TABLE users
  ADD PRIMARY KEY (id);

--
-- Indexes for table wishlist
--
ALTER TABLE wishlist
  ADD PRIMARY KEY (id);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table cart
--
ALTER TABLE cart
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table message
--
ALTER TABLE message
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table orders
--
ALTER TABLE orders
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table products
--
ALTER TABLE products
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table users
--
ALTER TABLE users
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table wishlist
--
ALTER TABLE wishlist
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;