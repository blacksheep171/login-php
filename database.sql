CREATE DATABASE php_login

CREATE TABLE `user` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('DEV','LEAD','MANAGER') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;