


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE DATABASE flory_website_db;
USE flory_website_db;


-- flory_website_db


CREATE TABLE `users` (
  `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1,
  `name` varchar(100) NOT NULL UNIQUE,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(100) NOT NULL,
  `img` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
  PRIMARY KEY (id);
); 
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


CREATE TABLE `contact_` (
  `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `msg` varchar(100) NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
); 
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `products` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `img` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `department_type` varchar(100) NOT NULL,
  `section` varchar(100) NOT NULL,
  PRIMARY KEY(id)
);
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `orders` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tel_number` int(100) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `pin_code` int(100) NOT NULL,
  `total_price` int(100) NOT NULL,
  `order_statue` ENUM('pending','completed') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`),
  FOREIGN KEY (user_id) REFERENCES users(id)
);
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `orders_products` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `order_id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (product_id) REFERENCES products(id),
  PRIMARY KEY (`id`, `order_id`, `user_id`, `product_id`)
);
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `carts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (product_id) REFERENCES products(id),
  PRIMARY KEY(`id`, `user_id`, `product_id`)
);
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
