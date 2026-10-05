-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2026 at 03:27 PM
-- Server version: 8.4.0
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blogapplication`
--
CREATE DATABASE IF NOT EXISTS `blogapplication` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `blogapplication`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `comment` mediumtext,
  `post_id` int NOT NULL,
  `comment_id` int DEFAULT NULL,
  `likes` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `post_id`, `comment_id`, `likes`, `user_id`) VALUES
(1, 'Very good writing!!!', 2, NULL, 0, 1),
(2, 'Very good writing.', 2, NULL, 0, 2),
(3, 'Amazing blog.', 8, NULL, 0, 1),
(4, 'Amazing blog.', 8, NULL, 0, 2),
(5, 'Amazing!!!', 8, NULL, 0, 2),
(6, 'Yup!', 2, 1, 0, 1),
(7, 'Awesome!', 2, 1, 0, 1),
(8, 'True!! 100%!!', 2, 7, 0, 1),
(9, 'Yup!', 8, 3, 0, 1),
(10, 'True! Amazing!', 8, 9, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `user_id`) VALUES
(2, 'First Blog', 'Hi,\r\n\r\nThis is my first blog.', 2),
(8, 'Second blog.', 'My Second Blog.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(25) DEFAULT NULL,
  `profile_pic` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'https://images.unsplash.com/photo-1586907835000-f692bbd4c9e0?q=80&w=1922&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile_pic`) VALUES
(1, 'admin', NULL, NULL, 'https://images.unsplash.com/photo-1586907835000-f692bbd4c9e0?q=80&w=1922&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'),
(2, 'test343', 'test1211@test.com', 'test123', 'http://localhost/blog_api/uploads/avatar/2.jpg'),
(3, 'test2', 'test2@test.com', 'test123', 'http://localhost/blog_api/uploads/avatar/3.jpg'),
(5, 'test3', 'test3@test.com', 'test123', 'https://images.unsplash.com/photo-1586907835000-f692bbd4c9e0?q=80&w=1922&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');

-- --------------------------------------------------------

--
-- Table structure for table `user_comment_likes`
--

CREATE TABLE `user_comment_likes` (
  `user_id` int NOT NULL,
  `comment_id` int NOT NULL,
  `is_liked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_comment_likes`
--

INSERT INTO `user_comment_likes` (`user_id`, `comment_id`, `is_liked`) VALUES
(2, 1, 1),
(2, 2, 0),
(2, 3, 1),
(2, 4, 0),
(2, 5, 1),
(2, 6, 0),
(2, 7, 0),
(2, 8, 1),
(3, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_post_likes`
--

CREATE TABLE `user_post_likes` (
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `is_liked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_post_likes`
--

INSERT INTO `user_post_likes` (`user_id`, `post_id`, `is_liked`) VALUES
(2, 2, 1),
(2, 8, 1),
(3, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_post_saved`
--

CREATE TABLE `user_post_saved` (
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  `is_saved` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_post_saved`
--

INSERT INTO `user_post_saved` (`post_id`, `user_id`, `is_saved`) VALUES
(2, 3, 1),
(8, 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_comment` (`post_id`),
  ADD KEY `comment_comment` (`comment_id`),
  ADD KEY `fk_comment_user` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ix_posts_id` (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `ix_users_id` (`id`);

--
-- Indexes for table `user_comment_likes`
--
ALTER TABLE `user_comment_likes`
  ADD PRIMARY KEY (`user_id`,`comment_id`),
  ADD KEY `comment_constraint` (`comment_id`);

--
-- Indexes for table `user_post_likes`
--
ALTER TABLE `user_post_likes`
  ADD PRIMARY KEY (`user_id`,`post_id`),
  ADD KEY `is_post_exists` (`post_id`);

--
-- Indexes for table `user_post_saved`
--
ALTER TABLE `user_post_saved`
  ADD PRIMARY KEY (`post_id`,`user_id`),
  ADD KEY `fk_user_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_comment` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `user_post relation` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_comment_likes`
--
ALTER TABLE `user_comment_likes`
  ADD CONSTRAINT `comment_constraint` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_constraint` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_post_likes`
--
ALTER TABLE `user_post_likes`
  ADD CONSTRAINT `is_post_exists` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `is_user_exists` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_post_saved`
--
ALTER TABLE `user_post_saved`
  ADD CONSTRAINT `fk_post_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
