-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2022 at 02:13 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cmsproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryId` int(3) NOT NULL,
  `categoryTitle` varchar(255) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryId`, `categoryTitle`, `userId`) VALUES
(2, 'Javascript Course', 22),
(3, 'PHP', 18),
(13, 'C#', 40),
(15, '    Python 3.0', 18);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentId` int(3) NOT NULL,
  `commentPostId` int(3) DEFAULT NULL,
  `commentAuthor` varchar(255) DEFAULT NULL,
  `commentEmail` varchar(255) DEFAULT NULL,
  `commentContent` text DEFAULT NULL,
  `commentStatus` varchar(255) DEFAULT NULL,
  `commentDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`commentId`, `commentPostId`, `commentAuthor`, `commentEmail`, `commentContent`, `commentStatus`, `commentDate`) VALUES
(17, 10, 'Dusan', 'dusan@gmail.com', 'Just a comment', 'disapproved', '2022-03-15'),
(20, 22, 'Dusan', 'pera@gmail.com', 'fghffhj', 'approved', '2022-04-01'),
(23, 10, 'bffghf', 'dusan@gmail.com', 'fghfhfgfg', 'approved', '2022-04-01'),
(24, 10, 'bffghf', 'dusan@gmail.com', 'fghfhfgfg', 'approved', '2022-04-01'),
(27, 48, 'Pera', 'dusan@gmail.com', 'dfgdfgdf', 'approved', '2022-04-06'),
(29, 46, 'Mika', 'mika@gmail.com', 'fgjfhgghj', 'approved', '2022-04-06'),
(30, 45, 'Dusan', 'dusan@gmail.com', 'dfhgffg', 'approved', '2022-04-06');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `postId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `userId`, `postId`) VALUES
(9, 18, 45),
(11, 18, 51),
(13, 18, 47),
(15, 18, 56),
(20, 18, 10);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postId` int(3) NOT NULL,
  `postCategoryId` int(3) DEFAULT NULL,
  `postTitle` varchar(255) DEFAULT NULL,
  `postAuthor` varchar(255) DEFAULT NULL,
  `postDate` date DEFAULT NULL,
  `postImage` text DEFAULT NULL,
  `postContent` text DEFAULT NULL,
  `postTags` varchar(255) DEFAULT NULL,
  `postCommentCount` int(11) NOT NULL DEFAULT 0,
  `postStatus` varchar(255) DEFAULT 'draft',
  `postViewsCount` int(3) DEFAULT 0,
  `likes` int(11) DEFAULT 0,
  `userId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postId`, `postCategoryId`, `postTitle`, `postAuthor`, `postDate`, `postImage`, `postContent`, `postTags`, `postCommentCount`, `postStatus`, `postViewsCount`, `likes`, `userId`) VALUES
(10, 2, 'Example News 5', 'mika', '2022-04-13', 'rb16-launches-silverstone.jfif', '        dfhgdzgdfgfdćčšž                                                                                                        ', 'bla, bla, bla', 8, 'draft', 233, 2, 22),
(22, 13, 'Example Post 5', 'dulex16', '2022-04-13', 'post1.jpg', '<p>fhfgfhf</p>                                ', 'bla, bla, bla', 0, 'published', 42, 1, 18),
(45, 3, 'Example News 4', 'dulex16', '2022-04-13', 'image_3.jpg', 'Just some content                        ', 'hello', 0, 'published', 12, 1, 18),
(46, 15, 'Example News 3', 'dulex16', '2022-04-13', 'image_2.jpg', '<p>dasdfsfdgdg</p><p>dfgh</p><p>fhfg</p><p>dh</p><p>jf</p><p>ghjgh</p><p>jhgf</p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p>jkfhgkjgf</p>                                ', 'bla, bla, bla', 0, 'published', 12, 0, 18),
(48, 3, 'Example Post 4', 'dulex16', '2022-04-13', 'image_4.jpg', '<p>LOERM RLEROEWMNDGIFJUKBDJKHGDFBGJKDFBGHFDJKHGBFDJKHFGFKGNH FGJHNBGFJKHFDGNBHJKDFNHFKJHNFKJHNFGJKHNFGKHNGFHKJFNHSJFKGHNFKJHGGSNFGHJKGFNSHFJK</p><p>FHFDHFGDJGFDJGFJGF</p><p>JFGJFGH</p><p>KJGFK</p>                        ', 'bla, bla, bla', 0, 'published', 7, 0, 18),
(50, 2, 'Example Post 3', 'dulex16', '2022-04-13', 'image_4.jpg', '<p>LOERM RLEROEWMNDGIFJUKBDJKHGDFBGJKDFBGHFDJKHGBFDJKHFGFKGNH FGJHNBGFJKHFDGNBHJKDFNHFKJHNFKJHNFGJKHNFGKHNGFHKJFNHSJFKGHNFKJHGGSNFGHJKGFNSHFJK</p><p>FHFDHFGDJGFDJGFJGF</p><p>JFGJFGH</p><p>KJGFK</p>                ', 'bla, bla, bla', 0, 'published', 0, 0, 18),
(52, 3, 'Example News 2', 'dulex16', '2022-04-13', 'image_2.jpg', '<p>dasdfsfdgdg</p><p>dfgh</p><p>fhfg</p><p>dh</p><p>jf</p><p>ghjgh</p><p>jhgf</p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p>jkfhgkjgf</p>                        ', 'bla, bla, bla', 0, 'published', 0, 0, 18),
(53, 13, 'Example Post 2', 'dulex16', '2022-04-13', 'image_3.jpg', 'Just some content                ', 'hello', 0, 'published', 0, 0, 18),
(54, 2, 'Example News 1', 'dulex16', '2022-04-13', 'post1.jpg', '<p>fhfgfhf</p>                ', 'bla, bla, bla', 0, 'published', 1, 0, 18),
(55, 13, 'Example Post 1', 'dulex16', '2022-04-13', 'image_4.jpg', 'lreoreoemroeremo        ', 'bla, bla, bla', 4, 'published', 0, 0, 18),
(56, 2, 'Example Post', 'mika', '2022-04-13', 'rb16-launches-silverstone.jfif', 'dfhgdzgdfgfdćčšž                        ', 'bla, bla, bla', 8, 'published', 2, 1, 22),
(57, 3, 'Example News', 'dulex16', '2022-04-12', 'rb16-launches-silverstone.jfif', '<p>dgkjoidhngkjdfndkjlgndkld</p>', 'bla, bla, bla', 0, 'published', 1, 0, 18);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(3) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `userPassword` varchar(255) DEFAULT NULL,
  `userFirstName` varchar(255) DEFAULT NULL,
  `userLastName` varchar(255) DEFAULT NULL,
  `userEmail` varchar(255) DEFAULT NULL,
  `userImage` text DEFAULT NULL,
  `userRole` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `username`, `userPassword`, `userFirstName`, `userLastName`, `userEmail`, `userImage`, `userRole`) VALUES
(18, 'dulex16', '', 'Dusan', 'Velickovic', 'dulex@gmail.com', NULL, 'admin'),
(22, 'mika', '$2y$10$kFZVKyPINXkYic2drpW0BOEBgQP52VP8zeZE/kXIss/nbuwDbkHtu', 'Mika', 'Mikic', 'mika@gmail.com', '', 'subscriber'),
(40, 'laza', '$2y$12$meUgXkelvKlg4QqGk9NsGOHUnIgCxLpMOCqVO0hcCh71yLdVClRFC', NULL, NULL, 'laza@gmail.com', NULL, 'subscriber');

-- --------------------------------------------------------

--
-- Table structure for table `users_online`
--

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL,
  `session` varchar(255) DEFAULT NULL,
  `time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_online`
--

INSERT INTO `users_online` (`id`, `session`, `time`) VALUES
(2, 'ps9n1koflg9l0p8saf85hret7l', 1648943069),
(3, 'g4uasjcgrp9qeb06dtgf60bhol', 1648911516),
(4, '2ho31rijoo5catl2ouje13lnvd', 1648913536),
(5, '3bikp8lhna8at42tsf9i1t2842', 1648913606),
(6, 's3kr13rvd4vstechi9q83egu6e', 1649116832),
(7, 'jsm4brlrfeo3u1gh1t6nolrmd8', 1649198340),
(8, 'rjr1ffkbta79igip8edavbfnps', 1649286444),
(9, '8p4ag2hbnrtkquhks6lj1k8orj', 1649376725),
(10, 'lp4k76fbvie0gpmu7om5715v99', 1649450771),
(11, 'u3r66c3j4devs17s3g4qsfh3uo', 1649628678),
(12, 'ki3n1ldvg3v8ipv90fv4sc3ra9', 1649720815),
(13, '12g5rev4dchks3d8aho3bl0s0r', 1649756933),
(14, 'pt1h9kmqpg5069a1k9kpfrfs20', 1649756978),
(15, 'c8e6n4bl5e737d2vakcqebv8d0', 1649758434),
(16, 'np69gdd6erqr13nmb7lahh3b5k', 1649806213),
(17, 'u6dvsqigcgrt4uhopo6hr1rkh4', 1649848114),
(18, 'ae3ngsb77r0dg24i386i33bf9p', 1649852038);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentId`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryId` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentId` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postId` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
