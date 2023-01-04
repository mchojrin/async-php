DROP DATABASE IF EXISTS `books`;

CREATE DATABASE `books`;

USE `books`;

CREATE TABLE `book` (
  ID INT AUTO_INCREMENT PRIMARY KEY,
  TITLE VARCHAR(255)
);

INSERT INTO `book` (TITLE) VALUES ("The catcher in the rye", "Game of Thrones");