-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 09, 2022 at 10:56 AM
-- Server version: 5.7.36
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `montres-api`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`) VALUES
(1, 'Montre de luxe', 'https://edgard-lelegant.com/wp-content/uploads/2019/07/Audemars-Piguet-Royal-Oak-e1563178183119.jpg'),
(2, 'Femme', 'https://ae01.alicdn.com/kf/H60aaf45fa8394e4a8208e7bf8e2114ddS/Fashion-Women-Watches-Simple-Romantic-Rose-Gold-Watch-Women-s-Wrist-Watch-Ladies-watch-relogio-feminino.jpg'),
(3, 'Men', 'https://content.api.news/v3/images/bin/9e887bb6e1921efa8550896c0840a3e3'),
(4, 'Legere', 'https://cdn.shopify.com/s/files/1/0314/1333/products/montre-homme-francaise-charlie-initial-automatique-coeur-ouvert-blanc-21_800x.jpg?v=1649665898'),
(5, 'Montres connecté', 'https://cdn.lesnumeriques.com/optim/comparison/39/39268/491f74ed-quelle-montre-connectee-choisir__1200_630__overflow.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20221007071651', '2022-10-07 09:16:54', 134);

-- --------------------------------------------------------

--
-- Table structure for table `montres`
--

DROP TABLE IF EXISTS `montres`;
CREATE TABLE IF NOT EXISTS `montres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id_id` int(11) DEFAULT NULL,
  `categories_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `price` bigint(20) DEFAULT NULL,
  `image` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_CA03B2699D86650F` (`user_id_id`),
  KEY `IDX_CA03B269A21214B7` (`categories_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `montres`
--

INSERT INTO `montres` (`id`, `user_id_id`, `categories_id`, `name`, `description`, `price`, `image`) VALUES
(4, NULL, 3, 'Montre 2', 'GROSSE DESCRIPTION', 9000, 'https://cdn.shopify.com/s/files/1/0067/7016/3748/products/Capture_d_ecran_2019-12-04_a_18.08.32_700x.png?v=1628232649'),
(5, NULL, 3, 'Montre 3', 'Grosse decription', 2000, 'https://cdn.shopify.com/s/files/1/0067/7016/3748/products/BlackMin_1024x1024_2x_0972855f-9821-4f09-a09f-5f728f72cb1b_700x.jpg?v=1625860673'),
(7, NULL, 2, 'Oppo', 'zadza', 1515, 'https://e-leclerc.scene7.com/is/image/gtinternet/6944284695566_1?op_sharpen=1&resmode=bilin&fmt=pjpeg&qlt=85&wid=450&fit=fit,1&hei=450'),
(8, NULL, 3, 'Montre 3', 'Grosse decription', 2000, 'https://cdn.shopify.com/s/files/1/0067/7016/3748/products/BlackMin_1024x1024_2x_0972855f-9821-4f09-a09f-5f728f72cb1b_700x.jpg?v=1625860673'),
(9, NULL, 4, 'Test', 'petit montre sympa', 8000, 'https://cdn.shopify.com/s/files/1/0067/7016/3748/products/gris-stella_600x.jpg?v=1628231286'),
(10, NULL, 3, 'Montre 5', 'afzf', 125, 'https://m.media-amazon.com/images/I/71ZbSvDPdeL._AC_SY355_.jpg'),
(11, NULL, 1, 'Montre de luxe', 'azdazd', 255, 'https://m.media-amazon.com/images/I/41dgLM+PdHL._SL500_.jpg'),
(12, NULL, 1, 'Luxe 2', '                                 Enter your description here...\r\n                                ', 455, 'https://www.cgv.fr/1042-large_default/GekoWatch-2.jpg'),
(13, NULL, 4, 'Montre legere', 'AFNOZAPFNAZF', 423, 'https://cdn.shopify.com/s/files/1/0067/7016/3748/products/Montre-connect-e-de-Sport-GTS-2-P8-plus-pour-hommes-et-femmes-enti-rement-tactile_jpg_Q90_jpg_700x.jpg?v=1649413679');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(3, 'maxenceely@gmail.com', '[\"ROLE_USER\"]', '$2y$13$OArzYVeXJu61oL48ZE/NUOP6UHgGp5z.JX15JZY3ORVYja7/xcoFm'),
(4, 'misti@gmail.com', '[\"ROLE_USER\"]', '$2y$13$WhjPsmeBp9uQOarpW5ee2eJyfPu51H7ha4MqVDnt8QeXgbT8yyxQW'),
(6, 'maxenczelgy@gmail.com', '[\"ROLE_USER\"]', '$2y$13$wZk5dUBZAUqa4dg7RBTPc.fiSiynLcnddzBQvCT.cXrqjcTOERZkW');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `montres`
--
ALTER TABLE `montres`
  ADD CONSTRAINT `FK_CA03B2699D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_CA03B269A21214B7` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
