-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2016 at 12:02 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(3) NOT NULL,
  `cat_title` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(22, 'Bussiness'),
(23, 'Entertainment'),
(24, 'News'),
(25, 'Sports'),
(26, 'National'),
(27, 'International'),
(28, 'Cities'),
(29, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment_post_id` int(3) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_email` varchar(255) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` varchar(255) NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`) VALUES
(6, 3, 'ergk', 'df@twe.ert', 'gjhw erht', 'Approved', '2016-12-03'),
(7, 2, 'dk', 'jlsjdl@ydd.efw', '	sf ij4r3', 'UnApproved', '2016-12-03');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(3) NOT NULL,
  `post_category_id` int(3) NOT NULL,
  `post_title` varchar(250) NOT NULL,
  `post_by` varchar(250) NOT NULL,
  `post_user` varchar(255) NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text NOT NULL,
  `post_content` text NOT NULL,
  `post_tags` varchar(255) NOT NULL,
  `post_comment_count` int(10) NOT NULL,
  `post_status` varchar(255) NOT NULL DEFAULT 'drafts',
  `post_view_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `post_title`, `post_by`, `post_user`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_view_count`) VALUES
(2, 29, 'CMS', 'vibakar', '', '2016-12-05', 'image_1.jpg', '<h2>This is simple cms project done by vibakar.Here you can make your posts.Go and sign up to make your first post.Be quick lot more stuffs are waiting for you</h2>', 'cms,vibakar', 0, 'published', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(3) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_gender` varchar(10) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_nation` varchar(30) NOT NULL,
  `user_city` varchar(30) NOT NULL,
  `user_mobile` varchar(15) NOT NULL,
  `user_image` text NOT NULL,
  `user_role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_firstname`, `user_lastname`, `user_gender`, `user_email`, `user_nation`, `user_city`, `user_mobile`, `user_image`, `user_role`) VALUES
(26, 'virat', '$2y$12$vc6Oyc2aRAZbtdhFB92ELuqu7ri7mK5O1LEN5Fh272pBmKta6zsN6', 'virat', 'kohli', 'male', 'virat@gmail.com', 'India', 'Coimbatore', '7639228797', '20150120130553.jpg', 'Subscriber'),
(27, 'vibakar', '$2y$12$q0oDF16wRczMX/eBc8fI5e/pzeuuQL8Bm0kOqbYSJ2MIvLLjZis26', 'Vibakar', 'k v', 'male', 'viba.2394@gmail.com', 'India', 'Coimbatore', '7639228797', 'CYMERA_viba.jpg', 'Admin'),
(28, 'viba', '$2y$12$5hWPWvj9zHQuQP9PWxevoujRducRt/NMRo8zKIVyQjL0Lzj9TzdY.', '', '', 'male', 'viba@gmail.com', '', '', '', 'men.jpg', 'Subscriber'),
(29, 'saina', '$2y$12$HSr6qGHX4Gw26pIKo3S09e/ppuusryawouXbekLa4R8pW99OUXPfi', '', '', 'female', 'saina@gmail.com', '', '', '', 'women.jpg', 'Subscriber'),
(30, 'chikoo', '$2y$12$GNuoSduWNc9MY8zkm4zUm.D2gpxJjHrN1lQX0BOIorUEEb2fOsETC', '', '', 'male', 'chikoo@gmail.com', '', '', '', 'men.jpg', 'Subscriber');

-- --------------------------------------------------------

--
-- Table structure for table `users_online`
--

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_online`
--

INSERT INTO `users_online` (`id`, `session`, `time`) VALUES
(1, 'qruph8l1nuosjupq18f833u0d1', 1479919549),
(2, '355sk6nlc0mtsd4d5clmm0u7k6', 1479917704),
(3, '0ea4od1dnietekdlpjimohai46', 1479917657),
(4, 'lm7gn98r4fnfpla8jse7b991t6', 1479918426),
(5, 'h9adej1pc0bn5db17uk99kb3b6', 1479918439),
(6, 'g4aps7aqh4lskp44pq90vfpv05', 1479954630),
(7, 'ddufaled8ic9j5vsefifar4js6', 1479954606),
(8, 'bj876smf7jukk5oivsjpu4mfi7', 1480008313),
(9, 'dc19anpj7lkuk68jthpj5ncmv6', 1480001794),
(10, '1elucdvhqnblp34m8i1pnft9a3', 1480092398),
(11, 'nsujuovuq7f7samcbjl6r0eqo7', 1480154317),
(12, '82kppguk6ho7k318k2gc3s5pj3', 1480161111),
(13, 'oqjadilfmvjenffuphh443coa7', 1480218656),
(14, 'qam43q8l93pmsqmaq0nb4gkkn2', 1480235691),
(15, 'u997oa2glp8sjah0ckqm5idm96', 1480240905),
(16, '6klg3ah2t62c98rq9u1kv9ae53', 1480273852),
(17, 't48c5uuu5iq5mfk1m48anglbm0', 1480426953),
(18, 'b364p0qv7is24pmdtq0fbc2f62', 1480415709),
(19, 'rug473prvbu4mch4d7aa6o6qu1', 1480417782),
(20, '1bq1t19806pigeolg4qfhvu2c2', 1480497945),
(21, 'vd7k876fiedqvco4jcqu95l594', 1480507668),
(22, 'tncvs830u043984vriicv1t584', 1480518203),
(23, 'ngjl23efthqku5onotohcrnlc3', 1480573076),
(24, 'ddd739f58plcecseqjt7v7mn66', 1480589932),
(25, 'cfr8n0hoa9tdf80h26031k7or0', 1480590129),
(26, 'qet59iv96vr12gjtjqft29g1q5', 1480590785),
(27, 'qb4h8smnchkhtvusama72nhdj0', 1480597042),
(28, 'b2gnnp09adkd7770h05s3drob3', 1480689215),
(29, 'uld7ngp4gbpf0cfm2oam6ghl66', 1480694748),
(30, 'dq9acac6gdlsonk8m0mv9ijt63', 1480740896),
(31, 'bjuapm4qf5norl7ks383gf62t1', 1480747429),
(32, '7jetu00giq9v6t2r1hj596ap30', 1480744952),
(33, 'av8vrn87gio5innu6p3aclohi6', 1480750375),
(34, 'kdgc3fto3nfse19mp7is4snni2', 1480757663),
(35, 't1dn55oe1chg87kdceklecee15', 1480763054),
(36, 'tj2oe7lb9rhj19f84o7g0iji03', 1480763832),
(37, 'oho3s7rdhf24cb8jsbv884erh2', 1480866289),
(38, 'lmltcnachfu3tmcumn7gnr6hr4', 1480935704);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

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
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
