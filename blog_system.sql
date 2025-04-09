-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2025 at 03:46 PM
-- Server version: 8.0.36
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_38710471_blog_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password_hash`, `created_at`, `updated_at`) VALUES
(1, 'test1', 'test1@gmail.com', '$2y$10$spy3Ga5gSUBX3j7zXcTdn.S7/EYjVnxLMGbH8qyx9sbCD99nWcIvW', '2025-04-08 12:34:20', '2025-04-08 12:34:20'),
(2, '12345678', '12345678@example.com', '$2y$10$VWHFvSG3RCgNCoA0QoaZpOozTNYIA8RZHqaLnbyQHs6IoS6ImNyPi', '2025-04-08 13:52:02', '2025-04-08 13:52:02'),
(3, 'writer', 'teset@gmail.com', '$2y$10$mimOmPZwhLbHeylbyrZXrud/S.i3qtlgywrA9oZzcLzMpzqYPFHWK', '2025-04-08 13:56:44', '2025-04-08 13:56:44'),
(4, 'Harshad45', 'harshad@gmail.com', '$2y$10$/kgyHE4QONqn2LzuUPi3iOvF.UdL2f0.MQpzL/oSCySqFcnZkYlOe', '2025-04-08 15:03:52', '2025-04-08 15:03:52'),
(5, 'siddhesh28', 'siddheshmore0024@gmail.com', '$2y$10$TTpozH5mUguf82nUWbneSOMgYa087nfyiwkym6FSCCcmBlPzSftvW', '2025-04-09 11:31:11', '2025-04-09 11:31:11'),
(7, 'user', 'user@gmail.com', '$2y$10$GZJhiTp6hXlByRY8Kc70C.BfpaHqvd/W6I6znc40DL0BBwPeONLZa', '2025-04-09 11:33:23', '2025-04-09 11:33:23'),
(8, 'siddhesh', 'siddheshmore23@gmail.com', '$2y$10$5TD4vJRhPBseUVFjQzYUtOUBL1mDrEJ5Nlb/fTBkcldfp6fRkjaZW', '2025-04-09 11:38:09', '2025-04-09 11:38:09'),
(9, 'sid', 'sid@gmail.com', '$2y$10$KJ7Opd0ywLENjUqsGb1gPOWVkTI7Ycjql9BqvsNOVdQQZBCt0rXDm', '2025-04-09 11:39:28', '2025-04-09 11:39:28'),
(10, 'sid2', 'sid22@gmail.com', '$2y$10$THGMLRKxe0a.uA5vAeH5aupkdGAbQ.2JgvyEvthvli9vI6O.dsj2G', '2025-04-09 11:40:19', '2025-04-09 11:40:19'),
(11, 'sarang', 'sarang@gmail.com', '$2y$10$8KSov8Skry9KlDgYcvLFO.NVvXGgtwfnS98Ng9jq.BQKH.PdB5JiG', '2025-04-09 11:41:06', '2025-04-09 11:41:06');

-- --------------------------------------------------------

--
-- Table structure for table `blog_category`
--

CREATE TABLE `blog_category` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_category_relationship`
--

CREATE TABLE `blog_category_relationship` (
  `blog_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_comment`
--

CREATE TABLE `blog_comment` (
  `id` int NOT NULL,
  `blog_id` int NOT NULL,
  `commenter_name` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_table`
--

CREATE TABLE `blog_table` (
  `id` int NOT NULL,
  `admin_id` int NOT NULL,
  `title` varchar(200) NOT NULL,
  `subtitle` varchar(300) DEFAULT NULL,
  `content` longtext NOT NULL,
  `image_url` text,
  `status` enum('draft','published') DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `blog_table`
--

INSERT INTO `blog_table` (`id`, `admin_id`, `title`, `subtitle`, `content`, `image_url`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 'Heyyy', 'Subtitle', 'asivdbdsa jha', '', 'published', '2025-04-08 12:59:45', '2025-04-08 13:48:09'),
(4, 2, 'Test', 'Testing by Sujit', 'Hi very nice', '', 'published', '2025-04-08 13:53:24', '2025-04-08 13:53:24'),
(5, 3, 'Siddhesh More', 'GEM', 'I am a CAT Aspirant . Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.istockphoto.com%2Fphotos%2Fimag&psig=AOvVaw25MIx8wJ_j3EHfdbj6v-o1&ust=1744207135444000&source=images&cd=vfe&opi=89978449&ved=0CBEQjRxqFwoTCPjFyIfMyIwDFQAAAAAdAAAAABAE', 'published', '2025-04-08 13:59:11', '2025-04-08 13:59:11'),
(6, 4, 'Test', 'SubTest', 'hgy', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.istockphoto.com%2Fphotos%2Fimag&psig=AOvVaw25MIx8wJ_j3EHfdbj6v-o1&ust=1744207135444000&source=images&cd=vfe&opi=89978449&ved=0CBEQjRxqFwoTCPjFyIfMyIwDFQAAAAAdAAAAABAE', 'published', '2025-04-08 15:04:41', '2025-04-08 15:04:41'),
(7, 11, 'sdfiug', 'saougdI', 'DSAKUGIL', '', 'published', '2025-04-09 11:48:41', '2025-04-09 11:48:41'),
(8, 11, 'DKSUAGI FA', 'SKGUFA', 'SAUGID', '', 'published', '2025-04-09 11:49:11', '2025-04-09 11:49:11'),
(9, 11, 'dsakjbfdsa mn', 'dskuagsagd', 'dafgv', '', 'published', '2025-04-09 11:49:25', '2025-04-09 11:49:25'),
(10, 11, 'duogas', 'iygasd', 'sakgucsa', '', 'published', '2025-04-09 11:49:39', '2025-04-09 11:49:39'),
(11, 11, 'testing', 'its optional', 'asbka', 'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=1920&q=80', 'published', '2025-04-09 12:40:27', '2025-04-09 12:40:27');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `blog_id` int NOT NULL,
  `reader_id` int NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `blog_id`, `reader_id`, `comment`, `created_at`) VALUES
(1, 3, 1, 'nice blog', '2025-04-08 18:57:47'),
(2, 3, 1, 'nice', '2025-04-08 19:24:08'),
(3, 4, 1, 'Great', '2025-04-08 19:24:31');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int NOT NULL,
  `blog_id` int NOT NULL,
  `reader_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `blog_id`, `reader_id`, `created_at`) VALUES
(1, 7, 1, '2025-04-09 13:24:36'),
(2, 5, 1, '2025-04-09 13:28:32'),
(3, 11, 1, '2025-04-09 13:29:56');

-- --------------------------------------------------------

--
-- Table structure for table `reader`
--

CREATE TABLE `reader` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reader`
--

INSERT INTO `reader` (`id`, `username`, `email`, `password_hash`, `created_at`) VALUES
(1, 'reader1', 'reader1@gmail.com', '$2y$10$ouhWYezpot5.3TZrl4LNoOfMN1E9MpH8XIoUIQnl4qSuUiLQ4bsHu', '2025-04-08 13:14:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `blog_category`
--
ALTER TABLE `blog_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `blog_category_relationship`
--
ALTER TABLE `blog_category_relationship`
  ADD PRIMARY KEY (`blog_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `blog_comment`
--
ALTER TABLE `blog_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`);

--
-- Indexes for table `blog_table`
--
ALTER TABLE `blog_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `reader_id` (`reader_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_id` (`blog_id`,`reader_id`),
  ADD KEY `reader_id` (`reader_id`);

--
-- Indexes for table `reader`
--
ALTER TABLE `reader`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `blog_category`
--
ALTER TABLE `blog_category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_comment`
--
ALTER TABLE `blog_comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_table`
--
ALTER TABLE `blog_table`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reader`
--
ALTER TABLE `reader`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_category_relationship`
--
ALTER TABLE `blog_category_relationship`
  ADD CONSTRAINT `blog_category_relationship_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog_table` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_category_relationship_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `blog_category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_comment`
--
ALTER TABLE `blog_comment`
  ADD CONSTRAINT `blog_comment_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog_table` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_table`
--
ALTER TABLE `blog_table`
  ADD CONSTRAINT `blog_table_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog_table` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`reader_id`) REFERENCES `reader` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog_table` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`reader_id`) REFERENCES `reader` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
